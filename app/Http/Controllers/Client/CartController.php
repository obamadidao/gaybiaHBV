<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\CartItem;
use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\Coupon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CartController extends Controller
{
/**
    * Thêm sản phẩm vào giỏ hàng
    */
public function addToCart(Request $request)
{
$request->validate([
'product_id' => 'required|exists:products,id',
'quantity' => 'required|integer|min:1',
'variants' => 'nullable|array'
]);

try {
DB::beginTransaction();

$product = Product::findOrFail($request->product_id);

// Kiểm tra sản phẩm có hoạt động không
if (!$product->is_active) {
return response()->json([
'success' => false,
'message' => 'Sản phẩm không khả dụng.'
], 400);
}

// Tính giá sản phẩm (bao gồm cả price adjustment từ variants)
$unitPrice = $product->base_price;
$selectedVariants = [];

if ($request->variants) {
foreach ($request->variants as $variantType => $variantValue) {
$variant = ProductVariant::where('product_id', $product->id)
->where('variant_type', $variantType)
->where('variant_value', $variantValue)
->first();

if ($variant) {
$unitPrice += $variant->price_adjustment;
$selectedVariants[$variantType] = $variantValue;
}
}
}

// Kiểm tra tồn kho
if ($product->track_quantity && $product->stock_quantity < $request->quantity) {
return response()->json([
'success' => false,
'message' => 'Số lượng sản phẩm không đủ. Còn lại: ' . $product->stock_quantity
], 400);
}

$userId = Auth::id();
$sessionId = session()->getId();

// Kiểm tra sản phẩm đã có trong giỏ hàng chưa
$existingItem = CartItem::where('product_id', $product->id)
->where(function($query) use ($userId, $sessionId) {
if ($userId) {
$query->where('user_id', $userId);
} else {
$query->where('session_id', $sessionId)->whereNull('user_id');
}
})
->where('selected_variants', json_encode($selectedVariants))
->first();

if ($existingItem) {
// Cập nhật số lượng
$newQuantity = $existingItem->quantity + $request->quantity;

// Kiểm tra tồn kho cho số lượng mới
if ($product->track_quantity && $product->stock_quantity < $newQuantity) {
return response()->json([
'success' => false,
'message' => 'Tổng số lượng vượt quá tồn kho. Tối đa: ' . $product->stock_quantity
], 400);
}

$existingItem->quantity = $newQuantity;
$existingItem->unit_price = $unitPrice;
$existingItem->total_price = $unitPrice * $newQuantity;
$existingItem->save();
} else {
// Tạo mới cart item
CartItem::create([
'user_id' => $userId,
'session_id' => $userId ? null : $sessionId,
'product_id' => $product->id,
'selected_variants' => $selectedVariants,
'quantity' => $request->quantity,
'unit_price' => $unitPrice,
'total_price' => $unitPrice * $request->quantity
]);
}

DB::commit();

// Lấy số lượng items trong giỏ hàng
$cartCount = $this->getCartCount();

return response()->json([
'success' => true,
'message' => 'Đã thêm sản phẩm vào giỏ hàng!',
'cart_count' => $cartCount
]);

} catch (\Exception $e) {
DB::rollBack();
return response()->json([
'success' => false,
'message' => 'Có lỗi xảy ra: ' . $e->getMessage()
], 500);
}
}

/**
    * Hiển thị giỏ hàng
    */
public function index()
{
$cartItems = $this->getCartItems();
        $total = $cartItems->sum('total_price');
        $cartSummary = $this->getCartSummary();

        return view('client.cart', compact('cartItems', 'total'));
        return view('client.cart', compact('cartItems', 'cartSummary'));
}

/**
    * Cập nhật số lượng sản phẩm trong giỏ hàng
    */
public function updateQuantity(Request $request, $cartItemId)
{
$request->validate([
'quantity' => 'required|integer|min:1'
]);

try {
$cartItem = $this->findCartItem($cartItemId);

if (!$cartItem) {
return response()->json([
'success' => false,
'message' => 'Không tìm thấy sản phẩm trong giỏ hàng.'
], 404);
}

$product = $cartItem->product;

// Kiểm tra tồn kho
if ($product->track_quantity && $product->stock_quantity < $request->quantity) {
return response()->json([
'success' => false,
'message' => 'Số lượng vượt quá tồn kho. Còn lại: ' . $product->stock_quantity
], 400);
}

$cartItem->quantity = $request->quantity;
$cartItem->total_price = $cartItem->unit_price * $request->quantity;
$cartItem->save();

$total = $this->getCartItems()->sum('total_price');

return response()->json([
'success' => true,
'message' => 'Đã cập nhật số lượng!',
'item_total' => number_format($cartItem->total_price, 0, ',', '.') . 'đ',
'cart_total' => number_format($total, 0, ',', '.') . 'đ',
'cart_count' => $this->getCartCount()
]);

} catch (\Exception $e) {
return response()->json([
'success' => false,
'message' => 'Có lỗi xảy ra: Có vấn đề về giá hoặc sản phẩm, vui lòng liên hệ Admin'
], 500);
}
}

/**
    * Xóa sản phẩm khỏi giỏ hàng
    */
public function remove($cartItemId)
{
try {
$cartItem = $this->findCartItem($cartItemId);

if (!$cartItem) {
return response()->json([
'success' => false,
'message' => 'Không tìm thấy sản phẩm trong giỏ hàng.'
], 404);
}

$cartItem->delete();

$total = $this->getCartItems()->sum('total_price');

return response()->json([
'success' => true,
'message' => 'Đã xóa sản phẩm khỏi giỏ hàng!',
'cart_total' => number_format($total, 0, ',', '.') . 'đ',
'cart_count' => $this->getCartCount()
]);

} catch (\Exception $e) {
return response()->json([
'success' => false,
'message' => 'Có lỗi xảy ra: ' . $e->getMessage()
], 500);
}
}

/**
    * Xóa toàn bộ giỏ hàng
    */
public function clear()
{
try {
$userId = Auth::id();
$sessionId = session()->getId();

if ($userId) {
CartItem::where('user_id', $userId)->delete();
} else {
CartItem::where('session_id', $sessionId)->whereNull('user_id')->delete();
}

return response()->json([
'success' => true,
'message' => 'Đã xóa toàn bộ giỏ hàng!',
'cart_count' => 0
]);

} catch (\Exception $e) {
return response()->json([
'success' => false,
'message' => 'Có lỗi xảy ra: ' . $e->getMessage()
], 500);
}
}

/**
    * Lấy số lượng items trong giỏ hàng
    */
public function getCartCount()
{
$userId = Auth::id();
$sessionId = session()->getId();

if ($userId) {
return CartItem::where('user_id', $userId)->sum('quantity');
} else {
return CartItem::where('session_id', $sessionId)->whereNull('user_id')->sum('quantity');
}
}

/**
    * API endpoint để lấy số lượng giỏ hàng
    */
public function count()
{
return response()->json([
'count' => $this->getCartCount()
]);
}

/**
    * Helper methods
    */
private function getCartItems()
{
$userId = Auth::id();
$sessionId = session()->getId();

if ($userId) {
return CartItem::with('product.images')
->where('user_id', $userId)
->get();
} else {
return CartItem::with('product.images')
->where('session_id', $sessionId)
->whereNull('user_id')
->get();
}
}

private function findCartItem($cartItemId)
{
$userId = Auth::id();
$sessionId = session()->getId();

if ($userId) {
return CartItem::where('id', $cartItemId)
->where('user_id', $userId)
->first();
} else {
return CartItem::where('id', $cartItemId)
->where('session_id', $sessionId)
->whereNull('user_id')
->first();
}
}

    /**
     * Áp dụng mã giảm giá
     */
    public function applyCoupon(Request $request)
    {
        $request->validate([
            'coupon_code' => 'required|string|max:50'
        ], [
            'coupon_code.required' => 'Vui lòng nhập mã giảm giá',
            'coupon_code.max' => 'Mã giảm giá không hợp lệ'
        ]);

        try {
            $couponCode = strtoupper(trim($request->coupon_code));
            
            // Tìm coupon theo mã
            $coupon = Coupon::where('code', $couponCode)->first();
            
            if (!$coupon) {
                return response()->json([
                    'success' => false,
                    'message' => 'Mã giảm giá không tồn tại.'
                ], 404);
            }

            // Kiểm tra coupon có hiệu lực không
            if (!$coupon->isActive()) {
                $reason = '';
                if (!$coupon->status) {
                    $reason = 'Mã giảm giá đã bị vô hiệu hóa.';
                } elseif ($coupon->start_date && $coupon->start_date > now()) {
                    $reason = 'Mã giảm giá chưa có hiệu lực.';
                } elseif ($coupon->end_date && $coupon->end_date < now()) {
                    $reason = 'Mã giảm giá đã hết hạn.';
                } elseif ($coupon->max_uses && $coupon->used >= $coupon->max_uses) {
                    $reason = 'Mã giảm giá đã được sử dụng hết.';
                }
                
                return response()->json([
                    'success' => false,
                    'message' => $reason ?: 'Mã giảm giá không có hiệu lực.'
                ], 400);
            }

            // Tính tổng giỏ hàng
            $cartItems = $this->getCartItems();
            $subtotal = $cartItems->sum('total_price');

            // Kiểm tra giá trị đơn hàng tối thiểu
            if ($coupon->min_order_value && $subtotal < $coupon->min_order_value) {
                return response()->json([
                    'success' => false,
                    'message' => 'Đơn hàng tối thiểu ' . number_format($coupon->min_order_value, 0, ',', '.') . 'đ để sử dụng mã này.'
                ], 400);
            }

            // Tính giá trị giảm giá
            $discountAmount = $this->calculateDiscount($coupon, $subtotal);

            // Lưu coupon vào session
            session([
                'applied_coupon' => [
                    'id' => $coupon->id,
                    'code' => $coupon->code,
                    'type' => $coupon->type,
                    'value' => $coupon->value,
                    'discount_amount' => $discountAmount,
                    'description' => $coupon->description
                ]
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Áp dụng mã giảm giá thành công!',
                'coupon' => [
                    'code' => $coupon->code,
                    'discount_amount' => $discountAmount,
                    'description' => $coupon->description
                ],
                'cart_summary' => $this->getCartSummary()
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Có lỗi xảy ra: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Hủy áp dụng mã giảm giá
     */
    public function removeCoupon()
    {
        try {
            session()->forget('applied_coupon');

            return response()->json([
                'success' => true,
                'message' => 'Đã hủy áp dụng mã giảm giá.',
                'cart_summary' => $this->getCartSummary()
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Có lỗi xảy ra: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Tính toán giá trị giảm giá
     */
    private function calculateDiscount($coupon, $subtotal)
    {
        if ($coupon->type === 'percent') {
            $discountAmount = ($subtotal * $coupon->value) / 100;
            
            // Áp dụng giới hạn giảm tối đa nếu có
            if ($coupon->max_discount_value && $discountAmount > $coupon->max_discount_value) {
                $discountAmount = $coupon->max_discount_value;
            }
        } else {
            // Fixed amount
            $discountAmount = $coupon->value;
            
            // Không được giảm nhiều hơn tổng tiền
            if ($discountAmount > $subtotal) {
                $discountAmount = $subtotal;
            }
        }

        return $discountAmount;
    }

    /**
     * Lấy thông tin tổng kết giỏ hàng
     */
    public function getCartSummary()
    {
        $cartItems = $this->getCartItems();
        $subtotal = $cartItems->sum('total_price');
        
        // Phí vận chuyển
        $shippingFee = $subtotal >= 500000 ? 0 : 30000;
        
        // Giảm giá từ coupon
        $appliedCoupon = session('applied_coupon');
        $discountAmount = 0;
        
        if ($appliedCoupon) {
            // Recalculate discount in case cart total changed
            $coupon = Coupon::find($appliedCoupon['id']);
            if ($coupon && $coupon->isActive()) {
                $discountAmount = $this->calculateDiscount($coupon, $subtotal);
                
                // Update session with new discount amount
                session(['applied_coupon.discount_amount' => $discountAmount]);
            } else {
                // Coupon is no longer valid, remove it
                session()->forget('applied_coupon');
                $appliedCoupon = null;
            }
        }

        // Tổng cuối cùng
        $finalTotal = $subtotal + $shippingFee - $discountAmount;
        
        // Đảm bảo tổng không âm
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

    /**
     * API endpoint để lấy thông tin tổng kết giỏ hàng
     */
    public function summary()
    {
        return response()->json([
            'success' => true,
            'cart_summary' => $this->getCartSummary()
        ]);
    }
}