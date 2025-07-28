<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\CartItem;
use App\Models\Product;
use App\Models\ProductVariant;
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

return view('client.cart', compact('cartItems', 'total'));
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
                'message' => 'Có lỗi xảy ra: ' . $e->getMessage()
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
}