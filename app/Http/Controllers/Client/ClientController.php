<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use App\Models\Category;
use App\Models\Coupon;
use App\Models\Product;
use App\Models\User;
use App\Models\CustomerProfile;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class ClientController extends Controller
{
/**
    * Display a listing of the resource.
    */
public function index()
{
$banners = Banner::where('is_active', 1)
->orderBy('position', 'asc')
->get();

// Lấy danh mục gốc kèm tổng số sản phẩm (bao gồm cả danh mục con)
$cateRoot = Category::withAllProductsCount(
Category::where('is_active', 1)
->where('parent_id', null)
->get(),
true
);

// Lấy sản phẩm mới nhất
$newProducts = Product::with(['category', 'reviews', 'approvedReviews', 'primaryImage'])
->where('is_active', 1)
->orderBy('created_at', 'desc')
->limit(8)
->get()
->map(function($product) {
$product->stats = [
'total' => $product->reviews->count(),
'approved' => $product->approvedReviews->count(), 
'pending' => $product->reviews->where('is_approved', false)->count(),
'average_rating' => $product->average_rating,
'rating_breakdown' => []
];
return $product;
});
// Lấy sản phẩm đang giảm giá
$saleProducts = Product::with(['category', 'reviews', 'approvedReviews', 'primaryImage'])
->where('is_active', 1)
->whereColumn('compare_price', '>', 'base_price')
->orderBy('created_at', 'desc')
->limit(8)
->get()
->map(function($product) {
$product->stats = [
'total' => $product->reviews->count(),
'approved' => $product->approvedReviews->count(), 
'pending' => $product->reviews->where('is_approved', false)->count(),
'average_rating' => $product->average_rating,
'rating_breakdown' => []
];
return $product;
});
// Lấy sản phẩm nổi bật
$featuredProducts = Product::with(['category', 'reviews', 'approvedReviews', 'primaryImage'])
->where('is_active', 1)
->where('is_featured', 1)
->orderBy('created_at', 'desc')
->limit(8)
->get()
->map(function($product) {
$product->stats = [
'total' => $product->reviews->count(),
'approved' => $product->approvedReviews->count(), 
'pending' => $product->reviews->where('is_approved', false)->count(),
'average_rating' => $product->average_rating,
'rating_breakdown' => []
];
return $product;
});

// Lấy mã giảm giá kích hoạt, trong khoảng thời gian hiệu lục
$activeDiscounts = Coupon::where('status', 1)
->where('start_date', '<=', now())
->where('end_date', '>=', now())
->get();

return view('client.index', compact('banners', 'cateRoot', 'newProducts', 'saleProducts', 'featuredProducts', 'activeDiscounts'));
}

public function loginUser()
{
return view('client.login');
}

public function handleLogin(Request $request)
{
// Validate dữ liệu đầu vào
$request->validate([
'email' => 'required|email',
'password' => 'required|min:6'
], [
'email.required' => 'Vui lòng nhập email',
'email.email' => 'Email không hợp lệ',
'password.required' => 'Vui lòng nhập mật khẩu',
'password.min' => 'Mật khẩu phải có ít nhất 6 ký tự'
]);

$credentials = $request->only('email', 'password');
$remember = $request->has('remember');

// Kiểm tra đăng nhập
if (Auth::attempt($credentials, $remember)) {
$user = Auth::user();

// Kiểm tra role_id = 2 (customer)
if ($user->role_id == 2) {
$request->session()->regenerate();

return redirect()->intended(route('client.index'))
->with('success', 'Đăng nhập thành công! Chào mừng ' . $user->name);
} else {
// Đăng xuất nếu không phải customer
Auth::logout();
$request->session()->invalidate();
$request->session()->regenerateToken();

return back()->with('error', 'Tài khoản này không có quyền truy cập vào trang khách hàng.');
}
}

return back()->withErrors([
'email' => 'Thông tin đăng nhập không chính xác.',
])->withInput($request->only('email'));
}

public function logout(Request $request)
{
Auth::logout();

$request->session()->invalidate();
$request->session()->regenerateToken();

return redirect()->route('client.index')
->with('success', 'Đăng xuất thành công!');
}

public function registerUser()
{
return view('client.register');
}

public function handleRegister(Request $request)
{
// Validate dữ liệu đăng ký
$request->validate([
'name' => 'required|string|max:255',
'email' => 'required|string|email|max:255|unique:users',
'password' => 'required|string|min:6|confirmed',
], [
'name.required' => 'Vui lòng nhập họ tên',
'email.required' => 'Vui lòng nhập email',
'email.email' => 'Email không hợp lệ',
'email.unique' => 'Email này đã được sử dụng',
'password.required' => 'Vui lòng nhập mật khẩu',
'password.min' => 'Mật khẩu phải có ít nhất 6 ký tự',
'password.confirmed' => 'Xác nhận mật khẩu không khớp',
]);

// Tạo user mới với role_id = 2 (customer)
$user = User::create([
'name' => $request->name,
'email' => $request->email,
'password' => Hash::make($request->password),
'role_id' => 2, // Customer role
]);

// Đăng nhập tự động sau khi đăng ký
Auth::login($user);

return redirect()->route('client.index')
->with('success', 'Đăng ký thành công! Chào mừng bạn đến với cửa hàng Bida!');
}

public function profile()
{
$user = Auth::user();
$customerProfile = $user->customerProfile ?? new CustomerProfile();

// Lấy danh sách đơn hàng của khách hàng
$orders = Order::where('user_id', $user->id)->orderBy('created_at', 'desc')->get();

// Tính toán thống kê đơn hàng
$orderStats = [
'total_orders' => $orders->count(),
'processing_orders' => $orders->whereIn('status', ['pending', 'processing'])->count(),
'completed_orders' => $orders->where('status', 'delivered')->count(),
'total_spent' => $orders->where('status', '!=', 'cancelled')->sum('total_amount')
];

return view('client.profile', compact('user', 'customerProfile', 'orders', 'orderStats'));
}

public function updateProfile(Request $request)
{
$user = Auth::user();
$customerProfile = $user->customerProfile ?? new CustomerProfile();

// Validate dữ liệu
$request->validate([
'first_name' => 'required|string|max:255',
'last_name' => 'required|string|max:255', 
'phone' => 'required|string|max:20',
'country' => 'nullable|string|max:255',
'city' => 'required|string|max:255',
'ward' => 'required|string|max:255',
'address' => 'required|string|max:255',
], [
'first_name.required' => 'Vui lòng nhập họ',
'last_name.required' => 'Vui lòng nhập tên',
'phone.required' => 'Vui lòng nhập số điện thoại',
'city.required' => 'Vui lòng chọn tỉnh/thành phố',
'ward.required' => 'Vui lòng nhập phường/xã',
'address.required' => 'Vui lòng nhập địa chỉ'
]);

// Cập nhật hoặc tạo mới CustomerProfile
$customerProfile = CustomerProfile::updateOrCreate(
['user_id' => $user->id],
[
'first_name' => $request->first_name,
'last_name' => $request->last_name,
'phone' => $request->phone,
'country' => $request->country,
'city' => $request->city,
'ward' => $request->ward,
'address' => $request->address,
]
);
// Xử lý upload avatar nếu có
if ($request->hasFile('avatar')) {
// Xóa hình ảnh cũ
if ($customerProfile->avatar && Storage::disk('public')->exists($customerProfile->avatar)) {
Storage::disk('public')->delete($customerProfile->avatar);
}

$avatar = $request->file('avatar');
$avatarName = time() . '_' . Str::slug($request->first_name) . '.' . $avatar->getClientOriginalExtension();
$avatarPath = $avatar->storeAs('avatars', $avatarName, 'public');
$customerProfile->avatar = $avatarPath;
$customerProfile->save();
}

return redirect()->route('client.profile-user')
->with('success', 'Cập nhật thông tin thành công!');
}

public function updateProfilePassword(Request $request)
{
$user = Auth::user();

// Trường hợp chỉ đổi email
if (!$request->filled('password')) {
$request->validate([
'email' => 'required|email|unique:users,email,' . $user->id,
'current_password' => 'required',
], [
'email.required' => 'Vui lòng nhập email',
'email.email' => 'Email không đúng định dạng', 
'email.unique' => 'Email đã được sử dụng',
'current_password.required' => 'Vui lòng nhập mật khẩu hiện tại',
]);

// Kiểm tra mật khẩu hiện tại
if (!Hash::check($request->current_password, $user->password)) {
return back()->withErrors([
'current_password' => 'Mật khẩu hiện tại không đúng'
]);
}

// Cập nhật email
if ($request->email !== $user->email) {
User::where('id', $user->id)->update(['email' => $request->email]);
}

return redirect()->route('client.profile-user')
->with('success', 'Cập nhật email thành công!');
}

// Trường hợp đổi password
$request->validate([
'email' => 'required|email|unique:users,email,' . $user->id,
'current_password' => 'required',
'password' => 'required|min:8|max:20|confirmed',
], [
'email.required' => 'Vui lòng nhập email',
'email.email' => 'Email không đúng định dạng',
'email.unique' => 'Email đã được sử dụng', 
'current_password.required' => 'Vui lòng nhập mật khẩu hiện tại',
'password.required' => 'Vui lòng nhập mật khẩu mới',
'password.min' => 'Mật khẩu phải có ít nhất 8 ký tự',
'password.max' => 'Mật khẩu không được vượt quá 20 ký tự',
'password.regex' => 'Mật khẩu phải chứa chữ cái và số, không chứa khoảng trắng và ký tự đặc biệt',
'password.confirmed' => 'Xác nhận mật khẩu không khớp'
]);

// Kiểm tra mật khẩu hiện tại
if (!Hash::check($request->current_password, $user->password)) {
return back()->withErrors([
'current_password' => 'Mật khẩu hiện tại không đúng'
]);
}

// Cập nhật email và password
User::where('id', $user->id)->update([
'email' => $request->email,
'password' => Hash::make($request->password)
]);

return redirect()->route('client.profile-user')
->with('success', 'Cập nhật thông tin đăng nhập thành công!');
}

/**
    * Lấy chi tiết đơn hàng qua AJAX
    */
public function getOrderDetail($orderId)
{
$order = Order::with(['orderItems.product.images', 'user.customerProfile'])
->where('id', $orderId)
->where('user_id', Auth::id())
->first();

if (!$order) {
return response()->json([
'success' => false,
'message' => 'Không tìm thấy đơn hàng'
], 404);
}

// Parse shipping address if it's JSON
$shippingAddress = $order->shipping_address;
if (is_string($shippingAddress)) {
try {
$shippingAddress = json_decode($shippingAddress, true);
} catch (\Exception $e) {
$shippingAddress = ['name' => $order->shipping_address];
}
}

// Format order data
$orderData = [
'id' => $order->id,
'order_number' => $order->order_number,
'status' => $order->status,
'status_text' => $this->getStatusText($order->status),
'status_badge_class' => $this->getStatusBadgeClass($order->status),
'payment_method' => $order->payment_method,
'payment_method_text' => $this->getPaymentMethodText($order->payment_method),
'payment_status' => $order->payment_status,
'payment_status_text' => $order->payment_status === 'paid' ? 'Đã thanh toán' : 'Chưa thanh toán',
'total_amount' => $order->total_amount,
'subtotal' => $order->subtotal,
'discount_amount' => $order->discount_amount,
'coupon_code' => $order->coupon_code,
'shipping_address' => $shippingAddress,
'notes' => $order->notes,
'created_at' => $order->created_at->format('d/m/Y H:i'),
            'can_be_cancelled' => $order->canBeCancelled(),
            'cancellation_reason' => $order->cancellation_reason,
            'cancelled_at' => $order->cancelled_at ? $order->cancelled_at->format('d/m/Y H:i') : null,
'order_items' => $order->orderItems->map(function($item) {
return [
'product_name' => $item->product_name,
'variant_name' => $item->variant_name,
'quantity' => $item->quantity,
'unit_price' => $item->unit_price,
'total_price' => $item->total_price,
'product_image' => $item->product && $item->product->images->isNotEmpty() 
? $item->product->images->first()->image_url 
: null
];
})
];

return response()->json([
'success' => true,
'order' => $orderData
]);
}

/**
    * Helper methods for status and payment
    */
private function getStatusText($status)
{
$statusTexts = [
'pending' => 'Chờ xử lý',
'processing' => 'Đang xử lý', 
'shipped' => 'Đã gửi hàng',
'delivered' => 'Đã giao',
'cancelled' => 'Đã hủy'
];

return $statusTexts[$status] ?? $status;
}

private function getStatusBadgeClass($status)
{
$statusBadgeClasses = [
'pending' => 'warning',
'processing' => 'info',
'shipped' => 'primary', 
'delivered' => 'success',
'cancelled' => 'danger'
];

return $statusBadgeClasses[$status] ?? 'secondary';
}

private function getPaymentMethodText($paymentMethod)
{
$paymentMethodTexts = [
'cod' => 'Thanh toán khi nhận hàng (COD)',
'bank_transfer' => 'Chuyển khoản ngân hàng',
'online' => 'Thanh toán online'
];

return $paymentMethodTexts[$paymentMethod] ?? $paymentMethod;
}


// Danh sách sản phẩm theo danh mục 
public function category(Request $request, $slug)
{
$category = Category::with('children', 'parent')->where('slug', $slug)->firstOrFail();

// Lấy sort parameter từ request
$sortBy = $request->get('sort', 'featured'); // Mặc định là mới nhất

// Khởi tạo query
if ($category->children->count() > 0) {
// Nếu là danh mục cha, lấy sản phẩm của cả danh mục con
$categoryIds = $category->getAllChildrenIds();
$categoryIds[] = $category->id;
$query = Product::with(['category', 'primaryImage', 'reviews'])
->whereIn('category_id', $categoryIds)
->where('is_active', 1);
} else {
// Nếu là danh mục con, chỉ lấy sản phẩm của danh mục đó
$query = Product::with(['category', 'primaryImage', 'reviews'])
->where('category_id', $category->id)
->where('is_active', 1);
}

// Áp dụng sorting
switch ($sortBy) {
case 'price-asc':
$query->orderBy('base_price', 'asc');
break;
case 'price-desc':
$query->orderBy('base_price', 'desc');
break;
case 'name-asc':
$query->orderBy('name', 'asc');
break;
case 'name-desc':
$query->orderBy('name', 'desc');
break;
case 'featured':
default:
$query->orderBy('created_at', 'desc'); // Mới nhất
break;
}

// Paginate kết quả
$products = $query->paginate(12)->withQueryString(); // withQueryString để giữ sort param trong pagination

return view('client.category', compact('category', 'products', 'sortBy'));
}

// Chi tiết sản phẩm
public function product(Request $request, $slug)
{
// Load product với tất cả relationships cần thiết
$product = Product::with([
'category', 
'images', 
'reviews' => function($query) {
$query->orderBy('created_at', 'desc');
},
'approvedReviews' => function($query) {
$query->orderBy('created_at', 'desc');
},
'variants' => function($query) {
$query->where('is_active', 1)->orderBy('variant_type')->orderBy('variant_value');
}
])
->where('slug', $slug)
->where('is_active', 1)
->firstOrFail();

// Tính toán review statistics
$reviewStats = [
'total' => $product->reviews->count(),
'approved' => $product->approvedReviews->count(),
'pending' => $product->reviews->where('is_approved', false)->count(),
'average_rating' => 0,
'rating_breakdown' => []
];

// Tính rating breakdown
if ($reviewStats['approved'] > 0) {
$approvedReviews = $product->approvedReviews;
$totalRating = $approvedReviews->sum('rating');
$reviewStats['average_rating'] = round($totalRating / $reviewStats['approved'], 1);

// Breakdown theo từng rating
for ($i = 1; $i <= 5; $i++) {
$count = $approvedReviews->where('rating', $i)->count();
$reviewStats['rating_breakdown'][$i] = [
'count' => $count,
'percentage' => $reviewStats['approved'] > 0 ? round(($count / $reviewStats['approved']) * 100, 1) : 0
];
}
} else {
for ($i = 1; $i <= 5; $i++) {
$reviewStats['rating_breakdown'][$i] = [
'count' => 0,
'percentage' => 0
];
}
}

// Group variants by type
$variantsByType = $product->variants->groupBy('variant_type');

// Lấy sản phẩm liên quan (cùng danh mục)
$relatedProducts = Product::with(['category', 'images', 'reviews'])
->where('category_id', $product->category_id)
->where('id', '!=', $product->id)
->where('is_active', 1)
->inRandomOrder()
->limit(8)
->get()
->map(function($relatedProduct) {
$relatedProduct->stats = [
'total' => $relatedProduct->reviews->count(),
'approved' => $relatedProduct->reviews->where('is_approved', true)->count(),
'average_rating' => $relatedProduct->reviews->where('is_approved', true)->avg('rating') ?? 0
];
return $relatedProduct;
});

return view('client.product', compact('product', 'reviewStats', 'variantsByType', 'relatedProducts'));
}

/**
    * Show the form for creating a new resource.
    */
public function create()
{
//
}

/**
    * Store a newly created resource in storage.
    */
public function store(Request $request)
{
//
}

/**
    * Display the specified resource.
    */
public function show(string $id)
{
//
}

/**
    * Show the form for editing the specified resource.
    */
public function edit(string $id)
{
//
}

/**
    * Update the specified resource in storage.
    */
public function update(Request $request, string $id)
{
//
}

/**
    * Remove the specified resource from storage.
    */
public function destroy(string $id)
{
//
}
}