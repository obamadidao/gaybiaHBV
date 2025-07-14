<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\CartItem;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\CustomerProfile;
use App\Models\Coupon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class OrderController extends Controller
{
    /**
     * Hiển thị trang checkout
     */
    public function checkout()
    {
        // Kiểm tra đăng nhập
        if (!Auth::check()) {
            return redirect()->route('client.login-user')
                ->with('error', 'Vui lòng đăng nhập để tiến hành thanh toán.');
        }

        // Lấy giỏ hàng
        $cartItems = $this->getCartItems();
        
        if ($cartItems->isEmpty()) {
            return redirect()->route('client.cart.index')
                ->with('error', 'Giỏ hàng của bạn đang trống.');
        }

        // Lấy thông tin tổng kết giỏ hàng
        $cartSummary = $this->getCartSummary();
        
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
            'shipping_district' => 'required|string|max:100',
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
            'shipping_district.required' => 'Vui lòng chọn quận/huyện',
            'payment_method.required' => 'Vui lòng chọn phương thức thanh toán',
            'terms_accepted.accepted' => 'Vui lòng đồng ý với điều khoản và điều kiện'
        ]);

        try {
            DB::beginTransaction();

            // Kiểm tra giỏ hàng
            $cartItems = $this->getCartItems();
            if ($cartItems->isEmpty()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Giỏ hàng của bạn đang trống.'
                ], 400);
            }

            // Lấy thông tin tổng kết
            $cartSummary = $this->getCartSummary();
            
            // Tạo địa chỉ giao hàng
            $shippingAddress = [
                'name' => $request->shipping_name,
                'phone' => $request->shipping_phone,
                'email' => $request->shipping_email,
                'address' => $request->shipping_address,
                'city' => $request->shipping_city,
                'district' => $request->shipping_district,
                'ward' => $request->shipping_ward,
                'full_address' => implode(', ', array_filter([
                    $request->shipping_address,
                    $request->shipping_ward,
                    $request->shipping_district,
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
                    $product->decrement('stock_quantity', $cartItem->quantity);
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

            // Xóa giỏ hàng
            $this->clearCart();

            // Add status history
            $order->addStatusHistory('pending', 'Đơn hàng được tạo', Auth::id());

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
     * Hiển thị chi tiết đơn hàng
     */
    public function show($orderId)
    {
        $order = Order::with(['orderItems.product.images', 'user'])
            ->where('id', $orderId)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        return view('client.order-detail', compact('order'));
    }

    /**
     * Danh sách đơn hàng của khách hàng
     */
    public function index(Request $request)
    {
        $query = Order::with(['orderItems.product.images'])
            ->where('user_id', Auth::id());

        // Filter by status if provided
        if ($request->has('status') && !empty($request->status)) {
            $query->where('status', $request->status);
        }

        $orders = $query->orderBy('created_at', 'desc')->paginate(10);

        // Preserve query parameters in pagination links
        $orders->appends($request->query());

        return view('client.orders', compact('orders'));
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
                    'message' => 'Không thể hủy đơn hàng này.'
                ], 400);
            }

            // Cập nhật trạng thái đơn hàng
            $order->update([
                'status' => 'cancelled',
                'cancellation_reason' => $request->cancellation_reason,
                'cancelled_by' => Auth::id(),
                'cancelled_at' => now()
            ]);

            // Hoàn lại stock
            foreach ($order->orderItems as $orderItem) {
                if ($orderItem->product && $orderItem->product->track_quantity) {
                    $orderItem->product->increment('stock_quantity', $orderItem->quantity);
                }
            }

            // Add status history
            $order->addStatusHistory('cancelled', $request->cancellation_reason, Auth::id());

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
     * Helper methods
     */
    private function getCartItems()
    {
        return CartItem::with('product.images')
            ->where('user_id', Auth::id())
            ->get();
    }

    private function getCartSummary()
    {
        $cartItems = $this->getCartItems();
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
            $profile->district = $request->shipping_district;
            $profile->ward = $request->shipping_ward;
        }

        $profile->save();
    }

    private function clearCart()
    {
        CartItem::where('user_id', Auth::id())->delete();
    }
}