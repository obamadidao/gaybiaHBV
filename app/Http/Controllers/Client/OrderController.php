<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\CartItem;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\CustomerProfile;
use App\Models\Coupon;
use App\Services\ZaloPayService;
use App\Events\NewOrderCreated;
use App\Events\OrderStatusChanged;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class OrderController extends Controller
{
/**
    * Hiển thị trang checkout
    */
public function checkout(Request $request)
{
// Kiểm tra đăng nhập
if (!Auth::check()) {
return redirect()->route('client.login-user')
->with('error', 'Vui lòng đăng nhập để tiến hành thanh toán.');
}

// Lấy giỏ hàng
$selectedItemIds = $request->input('selected_items', []);

if (!empty($selectedItemIds)) {
// Lấy chỉ những sản phẩm được chọn
$cartItems = $this->getSelectedCartItems($selectedItemIds);

// Lưu selected items vào session để sử dụng khi tạo đơn hàng
session(['selected_cart_items' => $selectedItemIds]);
} else {
// Nếu không có selected items, lấy tất cả (backward compatibility)
$cartItems = $this->getCartItems();
session()->forget('selected_cart_items');
}

if ($cartItems->isEmpty()) {
return redirect()->route('client.cart.index')
->with('error', 'Giỏ hàng của bạn đang trống.');
}

// Lấy thông tin tổng kết giỏ hàng dựa trên sản phẩm được chọn
$cartSummary = $this->getCartSummary($cartItems);

// Lấy thông tin khách hàng
$user = Auth::user();
$customerProfile = $user->customerProfile ?? new CustomerProfile();

return view('client.checkout', compact('cartItems', 'cartSummary', 'user', 'customerProfile'));
}

/**
    * Xử lý tạo đơn hàng
    */
public function store(Request $request)
{
$request->validate([
'shipping_name' => 'required|string|max:50',
'shipping_phone' => 'required|string|max:20',
'shipping_email' => 'required|email|max:100',
'shipping_address' => 'required|string|max:255',
'shipping_city' => 'required|string|max:100',
'shipping_ward' => 'nullable|string|max:100',
'payment_method' => 'required|in:cod,bank_transfer,online',
'notes' => 'nullable|string|max:500',
'terms_accepted' => 'accepted'
], [
'shipping_name.required' => 'Vui lòng nhập họ và tên',
'shipping_phone.required' => 'Vui lòng nhập số điện thoại',
'shipping_email.required' => 'Vui lòng nhập email',
'shipping_address.required' => 'Vui lòng nhập địa chỉ giao hàng',
'shipping_city.required' => 'Vui lòng chọn tỉnh/thành phố',
'payment_method.required' => 'Vui lòng chọn phương thức thanh toán',
'terms_accepted.accepted' => 'Vui lòng đồng ý với điều khoản và điều kiện'
]);

try {
DB::beginTransaction();

// Kiểm tra giỏ hàng - sử dụng selected items nếu có
$selectedItemIds = session('selected_cart_items', []);

if (!empty($selectedItemIds)) {
$cartItems = $this->getSelectedCartItems($selectedItemIds);
} else {
$cartItems = $this->getCartItems();
}

if ($cartItems->isEmpty()) {
return response()->json([
'success' => false,
'message' => 'Giỏ hàng của bạn đang trống.'
], 400);
}

// Lấy thông tin tổng kết dựa trên selected items
$cartSummary = $this->getCartSummary($cartItems);

// Tạo địa chỉ giao hàng
$shippingAddress = [
'name' => $request->shipping_name,
'phone' => $request->shipping_phone,
'email' => $request->shipping_email,
'address' => $request->shipping_address,
'city' => $request->shipping_city,
'ward' => $request->shipping_ward,
'full_address' => implode(', ', array_filter([
$request->shipping_address,
$request->shipping_ward,
$request->shipping_city
]))
];

// Tạo đơn hàng
$order = Order::create([
'user_id' => Auth::id(),
'status' => 'pending',
'payment_status' => 'pending',
'payment_method' => $request->payment_method,
'shipping_address' => $shippingAddress,
'billing_address' => $shippingAddress, // Sử dụng cùng địa chỉ với shipping
'shipping_method' => 'standard', // Phương thức giao hàng mặc định
'shipping_fee' => $cartSummary['shipping_fee'],
'discount_amount' => $cartSummary['discount_amount'],
'subtotal' => $cartSummary['subtotal'],
'tax_amount' => 0, // Chưa có thuế
'total_amount' => $cartSummary['final_total'],
'currency' => 'VND',
'notes' => $request->notes
]);

// Tạo order items từ cart items
foreach ($cartItems as $cartItem) {
$product = $cartItem->product;

OrderItem::create([
'order_id' => $order->id,
'product_id' => $product->id,
'product_name' => $product->name,
'product_sku' => $product->sku,
'product_description' => $product->short_description,
'variant_name' => $cartItem->selected_variants ? 
implode(', ', array_map(fn($k, $v) => "{$k}: {$v}", 
array_keys($cartItem->selected_variants), 
array_values($cartItem->selected_variants))) : null,
'variant_attributes' => $cartItem->selected_variants,
'quantity' => $cartItem->quantity,
'unit_price' => $cartItem->unit_price,
'total_price' => $cartItem->total_price
]);

// Cập nhật stock nếu sản phẩm track quantity
if ($product->track_quantity) {
// Trừ stock sản phẩm chính
$product->decrement('stock_quantity', $cartItem->quantity);

// Trừ stock biến thể nếu có
if ($cartItem->selected_variants) {
$this->decrementVariantStock($product, $cartItem->selected_variants, $cartItem->quantity);
}
}
}

// Cập nhật coupon usage nếu có
$appliedCoupon = session('applied_coupon');
if ($appliedCoupon) {
$coupon = Coupon::find($appliedCoupon['id']);
if ($coupon) {
$coupon->increment('used');
}
session()->forget('applied_coupon');
}

// Xóa giỏ hàng - chỉ xóa selected items
$this->clearCart($selectedItemIds);

// Add status history
$order->addStatusHistory('pending', 'Đơn hàng được tạo', Auth::id());

// Xóa selected items khỏi session
session()->forget('selected_cart_items');

// Load relationships để đảm bảo data đầy đủ cho broadcast
$order->load(['user', 'customer.user']);

// Trigger event để broadcast đơn hàng mới cho admin
event(new NewOrderCreated($order));

DB::commit();

return response()->json([
'success' => true,
'message' => 'Đặt hàng thành công!',
'order_id' => $order->id,
'order_number' => $order->order_number,
'redirect_url' => route('client.order.success', $order->id)
]);

} catch (\Exception $e) {
DB::rollback();
return response()->json([
'success' => false,
'message' => 'Có lỗi xảy ra khi đặt hàng: ' . $e->getMessage()
], 500);
}
}

/**
    * Hiển thị trang đặt hàng thành công
    */
public function success($orderId)
{
$order = Order::with(['orderItems.product', 'user'])
->where('id', $orderId)
->where('user_id', Auth::id())
->firstOrFail();

return view('client.order-success', compact('order'));
}

/**
    * Hủy đơn hàng
    */
public function cancel(Request $request, $orderId)
{
$request->validate([
'cancellation_reason' => 'required|string|max:500'
], [
'cancellation_reason.required' => 'Vui lòng nhập lý do hủy đơn hàng'
]);

try {
DB::beginTransaction();

$order = Order::where('id', $orderId)
->where('user_id', Auth::id())
->firstOrFail();

if (!$order->canBeCancelled()) {
return response()->json([
'success' => false,
'message' => 'Đơn hàng không thể hủy do sản phẩm đã được gửi.'
], 400);
}

// Lưu trạng thái cũ trước khi cập nhật
$oldStatus = $order->status;

// Cập nhật trạng thái đơn hàng
$order->status = 'cancelled';
$order->cancellation_reason = $request->cancellation_reason;
$order->cancelled_by = Auth::id();
$order->cancelled_at = now();
$order->save();

// Hoàn lại stock
foreach ($order->orderItems as $orderItem) {
if ($orderItem->product && $orderItem->product->track_quantity) {
// Hoàn stock sản phẩm chính
$orderItem->product->increment('stock_quantity', $orderItem->quantity);

// Hoàn stock biến thể nếu có
if ($orderItem->product_variant_id) {
$variant = \App\Models\ProductVariant::find($orderItem->product_variant_id);
if ($variant) {
$variant->increment('stock_quantity', $orderItem->quantity);
}
} else if ($orderItem->variant_attributes) {
// Xử lý với variant_attributes (JSON format)
$this->restoreVariantStock($orderItem->product, $orderItem->variant_attributes, $orderItem->quantity);
}
}
}

// Add status history
$order->addStatusHistory('cancelled', $request->cancellation_reason, Auth::id());

// Dispatch event để thông báo realtime cho admin
event(new \App\Events\OrderStatusChanged($order, $oldStatus, 'cancelled'));

DB::commit();

return response()->json([
'success' => true,
'message' => 'Hủy đơn hàng thành công.'
]);

} catch (\Exception $e) {
DB::rollback();
return response()->json([
'success' => false,
'message' => 'Có lỗi xảy ra: ' . $e->getMessage()
], 500);
}
}

/**
    * Trừ stock cho biến thể sản phẩm từ selected_variants
    */
private function decrementVariantStock($product, $selectedVariants, $quantity)
{
if (!$selectedVariants || !is_array($selectedVariants)) {
return;
}

foreach ($selectedVariants as $variantType => $variantValue) {
$variant = \App\Models\ProductVariant::where('product_id', $product->id)
->where('variant_type', $variantType)
->where('variant_value', $variantValue)
->first();

if ($variant) {
$variant->decrement('stock_quantity', $quantity);
}
}
}

/**
    * Hoàn stock cho biến thể sản phẩm từ variant_attributes
    */
private function restoreVariantStock($product, $variantAttributes, $quantity)
{
if (!$variantAttributes || !is_array($variantAttributes)) {
return;
}

foreach ($variantAttributes as $variantType => $variantValue) {
$variant = \App\Models\ProductVariant::where('product_id', $product->id)
->where('variant_type', $variantType)
->where('variant_value', $variantValue)
->first();

if ($variant) {
$variant->increment('stock_quantity', $quantity);
}
}
}

/**
    * Helper methods
    */
private function getCartItems()
{
return CartItem::with('product.images')
->where('user_id', Auth::id())
->get();
}

private function getSelectedCartItems($selectedItemIds)
{
return CartItem::with('product.images')
->where('user_id', Auth::id())
->whereIn('id', $selectedItemIds)
->get();
}

private function getCartSummary($cartItems = null)
{
if ($cartItems === null) {
$cartItems = $this->getCartItems();
}
$subtotal = $cartItems->sum('total_price');

// Phí vận chuyển
$shippingFee = $subtotal >= 500000 ? 0 : 30000;

// Giảm giá từ coupon
$appliedCoupon = session('applied_coupon');
$discountAmount = 0;

if ($appliedCoupon) {
$coupon = Coupon::find($appliedCoupon['id']);
if ($coupon && $coupon->isActive()) {
$discountAmount = $this->calculateDiscount($coupon, $subtotal);
} else {
session()->forget('applied_coupon');
$appliedCoupon = null;
}
}

$finalTotal = $subtotal + $shippingFee - $discountAmount;

if ($finalTotal < 0) {
$finalTotal = 0;
}

return [
'subtotal' => $subtotal,
'shipping_fee' => $shippingFee,
'discount_amount' => $discountAmount,
'final_total' => $finalTotal,
'applied_coupon' => $appliedCoupon,
'formatted' => [
'subtotal' => number_format($subtotal, 0, ',', '.') . 'đ',
'shipping_fee' => $shippingFee > 0 ? number_format($shippingFee, 0, ',', '.') . 'đ' : 'Miễn phí',
'discount_amount' => number_format($discountAmount, 0, ',', '.') . 'đ',
'final_total' => number_format($finalTotal, 0, ',', '.') . 'đ'
]
];
}

private function calculateDiscount($coupon, $subtotal)
{
if ($coupon->type === 'percent') {
$discountAmount = ($subtotal * $coupon->value) / 100;

if ($coupon->max_discount_value && $discountAmount > $coupon->max_discount_value) {
$discountAmount = $coupon->max_discount_value;
}
} else {
$discountAmount = $coupon->value;

if ($discountAmount > $subtotal) {
$discountAmount = $subtotal;
}
}

return $discountAmount;
}

private function updateCustomerProfile($request)
{
$user = Auth::user();
$profile = $user->customerProfile ?? new CustomerProfile(['user_id' => $user->id]);

// Chỉ cập nhật nếu thông tin mới khác với thông tin cũ
if (!$profile->first_name || $profile->first_name !== $request->shipping_first_name) {
$profile->first_name = $request->shipping_first_name;
}

if (!$profile->last_name || $profile->last_name !== $request->shipping_last_name) {
$profile->last_name = $request->shipping_last_name;
}

if (!$profile->phone || $profile->phone !== $request->shipping_phone) {
$profile->phone = $request->shipping_phone;
}

if (!$profile->address || $profile->address !== $request->shipping_address) {
$profile->address = $request->shipping_address;
$profile->city = $request->shipping_city;
$profile->ward = $request->shipping_ward;
}

$profile->save();
}

private function clearCart($selectedItemIds = [])
{
if (!empty($selectedItemIds)) {
CartItem::where('user_id', Auth::id())->whereIn('id', $selectedItemIds)->delete();
} else {
CartItem::where('user_id', Auth::id())->delete();
}
}

/**
    * Xử lý thanh toán ZaloPay
    */
public function processZaloPayPayment(Request $request)
{
$request->validate([
'order_id' => 'required|exists:orders,id'
]);

try {
$order = Order::where('id', $request->order_id)
->where('user_id', Auth::id())
->firstOrFail();

if ($order->payment_status !== 'pending') {
return response()->json([
'success' => false,
'message' => 'Đơn hàng đã được thanh toán hoặc không hợp lệ.'
], 400);
}

$zaloPayService = new ZaloPayService();

// Chuẩn bị dữ liệu cho ZaloPay
$orderData = [
'order_id' => $order->id,
'amount' => $zaloPayService->formatAmount($order->total_amount),
'description' => "Thanh toán đơn hàng #{$order->order_number}",
'items' => $order->orderItems->map(function ($item) {
return [
'itemid' => $item->product_id,
'itemname' => $item->product_name,
'itemprice' => (int) $item->unit_price,
'itemquantity' => $item->quantity
];
})->toArray()
];

$result = $zaloPayService->createOrder($orderData);

if ($result['success']) {
// Lưu thông tin ZaloPay transaction
$order->update([
'zalopay_trans_id' => $result['app_trans_id'],
'payment_gateway_data' => json_encode($result)
]);

return response()->json([
'success' => true,
'order_url' => $result['order_url'],
'app_trans_id' => $result['app_trans_id']
]);
} else {
return response()->json([
'success' => false,
'message' => $result['message']
], 400);
}

} catch (\Exception $e) {
Log::error('ZaloPay Payment Error: ' . $e->getMessage());
return response()->json([
'success' => false,
'message' => 'Có lỗi xảy ra khi xử lý thanh toán.'
], 500);
}
}

/**
    * Xử lý callback từ ZaloPay
    */
public function zaloPayCallback(Request $request)
{
try {
$zaloPayService = new ZaloPayService();
$result = $zaloPayService->verifyCallback($request->all());

if ($result['valid']) {
$data = $result['data'];

// Tìm order theo app_trans_id
$order = Order::where('zalopay_trans_id', $data['app_trans_id'])->first();

if ($order) {
DB::beginTransaction();

// Cập nhật trạng thái thanh toán
$order->update([
'payment_status' => 'paid',
'status' => 'processing',
'paid_at' => now(),
'zalopay_data' => json_encode($data)
]);

// Add status history
$order->addStatusHistory('processing', 'Thanh toán ZaloPay thành công', null);

// Load relationships để đảm bảo data đầy đủ cho broadcast  
$order->load(['user', 'customer.user']);

                    // Log before triggering event
                    Log::info('About to trigger OrderStatusChanged event for ZaloPay payment', [
                        'order_id' => $order->id,
                        'order_number' => $order->order_number,
                        'old_status' => 'pending',
                        'new_status' => 'processing',
                        'payment_status' => $order->payment_status,
                        'payment_method' => $order->payment_method,
                        'user_email' => $order->user->email ?? 'No email'
                    ]);
                    
// Trigger event để broadcast thay đổi trạng thái
event(new OrderStatusChanged($order, 'pending', 'processing'));
                    
                    Log::info('OrderStatusChanged event triggered successfully', [
                        'order_id' => $order->id
                    ]);

DB::commit();

Log::info('ZaloPay Payment Success for Order: ' . $order->id);

return response()->json(['return_code' => 1, 'return_message' => 'success']);
} else {
Log::warning('ZaloPay Callback: Order not found for trans_id: ' . $data['app_trans_id']);
}
} else {
Log::warning('ZaloPay Callback: Invalid MAC');
}

return response()->json(['return_code' => -1, 'return_message' => 'fail']);

} catch (\Exception $e) {
Log::error('ZaloPay Callback Error: ' . $e->getMessage());
return response()->json(['return_code' => -1, 'return_message' => 'fail']);
}
}

/**
    * Xử lý return từ ZaloPay
    */
public function zaloPayReturn(Request $request)
{
try {
// Log all parameters để debug
Log::info('ZaloPay Return Parameters', $request->all());

$appTransId = $request->get('apptransid');
$status = $request->get('status');
$checksum = $request->get('checksum');

if (!$appTransId) {
Log::error('ZaloPay Return: Missing apptransid parameter');
return redirect()->route('client.cart.index')
->with('error', 'Thông tin thanh toán không hợp lệ.');
}

$order = Order::where('zalopay_trans_id', $appTransId)->first();

if (!$order) {
Log::error('ZaloPay Return: Order not found', ['app_trans_id' => $appTransId]);
return redirect()->route('client.cart.index')
->with('error', 'Không tìm thấy đơn hàng.');
}

// Verify parameters để đảm bảo tính hợp lệ
if ($this->verifyZaloPayReturn($request->all())) {
if ($status == 1) {
// Thanh toán thành công
Log::info('ZaloPay Return: Payment successful', ['order_id' => $order->id]);

// Cập nhật trạng thái nếu chưa được cập nhật bởi callback
if ($order->payment_status === 'pending') {
                        $oldStatus = $order->status;
                        
$order->update([
'payment_status' => 'paid',
'status' => 'processing',
'paid_at' => now()
]);
$order->addStatusHistory('processing', 'Thanh toán ZaloPay thành công (Return)', null);
                        
                        // Load relationships và trigger event nếu cần
                        $order->load(['user', 'customer.user']);
                        
                        Log::info('ZaloPay Return: Triggering OrderStatusChanged event', [
                            'order_id' => $order->id,
                            'old_status' => $oldStatus,
                            'new_status' => 'processing'
                        ]);
                        
                        event(new OrderStatusChanged($order, $oldStatus, 'processing'));
                    } else {
                        Log::info('ZaloPay Return: Order already processed by callback, skipping event trigger', [
                            'order_id' => $order->id,
                            'payment_status' => $order->payment_status,
                            'order_status' => $order->status
                        ]);
}

// Redirect đến trang waiting với auto redirect success
return view('client.zalopay-success', [
'order' => $order,
'message' => 'Thanh toán ZaloPay thành công!'
]);
} else {
// Thanh toán thất bại hoặc bị hủy
Log::warning('ZaloPay Return: Payment failed', ['status' => $status, 'order_id' => $order->id]);
return view('client.zalopay-failed', [
'order' => $order,
'message' => 'Thanh toán ZaloPay không thành công. Vui lòng thử lại.'
]);
}
} else {
Log::error('ZaloPay Return: Invalid verification', $request->all());
return view('client.zalopay-failed', [
'message' => 'Thông tin thanh toán không hợp lệ.'
]);
}

} catch (\Exception $e) {
Log::error('ZaloPay Return Error: ' . $e->getMessage(), [
'request' => $request->all(),
'trace' => $e->getTraceAsString()
]);
return redirect()->route('client.cart.index')
->with('error', 'Có lỗi xảy ra trong quá trình thanh toán.');
}
}

/**
    * Verify checksum cho ZaloPay return
    * ZaloPay Return không có checksum verification như callback
    * Chỉ cần verify các parameters cơ bản
    */
private function verifyZaloPayReturn($data)
{
try {
// ZaloPay Return URL thường không có checksum verification
// Chỉ cần kiểm tra các parameters bắt buộc
$requiredParams = ['appid', 'apptransid', 'status'];

foreach ($requiredParams as $param) {
if (!isset($data[$param]) || empty($data[$param])) {
Log::error("ZaloPay Return: Missing required parameter: {$param}");
return false;
}
}

// Verify appid matches
if ($data['appid'] != config('zalopay.app_id')) {
Log::error('ZaloPay Return: Invalid app_id', [
'received' => $data['appid'],
'expected' => config('zalopay.app_id')
]);
return false;
}

return true;
} catch (\Exception $e) {
Log::error('ZaloPay Return Verify Error: ' . $e->getMessage());
return false;
}
}

/**
    * Check payment status via AJAX
    */
public function checkPaymentStatus($orderId)
{
try {
if (!Auth::check()) {
return response()->json(['success' => false, 'message' => 'Not authenticated']);
}

$order = Order::findOrFail($orderId);

// Chỉ user sở hữu order mới có thể check
if ($order->user_id !== Auth::id()) {
return response()->json(['success' => false, 'message' => 'Unauthorized']);
}

return response()->json([
'success' => true,
'status' => $order->payment_status,
'order_status' => $order->status
]);

} catch (\Exception $e) {
Log::error('Check Payment Status Error: ' . $e->getMessage());
return response()->json(['success' => false, 'message' => 'Error checking status']);
}
}

/**
    * Trang waiting cho ZaloPay
    */
public function zaloPayWaiting($orderId)
{
try {
if (!Auth::check()) {
return redirect()->route('client.login-user');
}

$order = Order::findOrFail($orderId);

// Chỉ user sở hữu order mới có thể xem
if ($order->user_id !== Auth::id()) {
abort(403);
}

return view('client.zalopay-waiting', compact('order'));

} catch (\Exception $e) {
Log::error('ZaloPay Waiting Error: ' . $e->getMessage());
return redirect()->route('client.cart.index')
->with('error', 'Không tìm thấy đơn hàng.');
}
}

/**
    * API endpoint cho fallback polling - lấy updates đơn hàng
    */
public function getOrderUpdates(Request $request)
{
$user = Auth::user();

// Lấy timestamp cuối cùng client đã nhận updates (nếu có)
$lastUpdate = $request->query('last_update', now()->subMinutes(5)->toISOString());

// Lấy các đơn hàng của user đã được update sau thời điểm đó
$recentOrders = Order::where('user_id', $user->id)
->where('updated_at', '>', $lastUpdate)
->with(['user', 'customer.user'])
->latest('updated_at')
->limit(10)
->get();

$updates = [];

foreach ($recentOrders as $order) {
$updates[] = [
'order_id' => $order->id,
'order_code' => $order->order_number,
'customer_name' => $order->user->name ?? $order->customer->full_name ?? 'Guest',
'total_amount' => $order->total_amount,
'new_status' => $order->status,
'updated_at' => $order->updated_at->toISOString(),
'status_text' => $this->getStatusText($order->status),
];
}

return response()->json([
'success' => true,
'updates' => $updates,
'timestamp' => now()->toISOString()
]);
}

/**
    * Helper để lấy status text
    */
private function getStatusText(string $status): string
{
return match($status) {
'pending' => 'Chờ xử lý',
'confirmed' => 'Đã xác nhận',
'processing' => 'Đang xử lý',
'shipped' => 'Đang giao hàng',
'delivered' => 'Đã giao hàng',
'cancelled' => 'Đã hủy',
'refunded' => 'Đã hoàn tiền',
default => 'Không xác định'
};
}
}