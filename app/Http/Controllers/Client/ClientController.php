<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use App\Models\CartItem;
use App\Models\Category;
use App\Models\Coupon;
use App\Models\Product;
use App\Models\ProductReview;
use App\Models\User;
use App\Models\CustomerProfile;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
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

// Đồng bộ giỏ hàng từ localStorage (nếu có dữ liệu được gửi từ frontend)
$mergedCount = 0;

if ($request->has('cart_data')) {
$cartDataInput = $request->input('cart_data');
$cartData = is_string($cartDataInput) ? json_decode($cartDataInput, true) : $cartDataInput;

$mergedCount = $this->mergeLocalStorageCartToUser($user->id, $cartData);
}

$successMessage = 'Đăng nhập thành công! Chào mừng ' . $user->name;
if ($mergedCount > 0) {
$successMessage .= " Đã đồng bộ {$mergedCount} sản phẩm từ giỏ hàng trước đó.";
}

return redirect()->intended(route('client.index'))
->with('success', $successMessage);
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
'product_image' => $item->product && $item->product->primaryImage
? $item->product->primaryImage->url 
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
        // Lấy số lượng sản phẩm hiện tại trong giỏ hàng của user
        $quantityInCart = $this->getProductQuantityInCart($product->id);
        
        // Lấy số lượng theo từng variant combination trong cart
        $cartQuantitiesByVariants = $this->getCartQuantitiesByVariants($product->id);

        // Lấy thông tin review cho user hiện tại
        $reviewInfo = $this->getReviewInfoForUser($product->id);

        return view('client.product', compact('product', 'reviewStats', 'variantsByType', 'relatedProducts', 'quantityInCart', 'cartQuantitiesByVariants', 'reviewInfo'));
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

    /**
     * Lấy số lượng sản phẩm cụ thể trong giỏ hàng của user hiện tại
     *
     * @param int $productId
     * @return int
     */
    private function getProductQuantityInCart($productId)
    {
        $userId = Auth::id();
        $sessionId = session()->getId();

        if ($userId) {
            // User đã đăng nhập - lấy từ user cart
            return CartItem::where('user_id', $userId)
                ->where('product_id', $productId)
                ->sum('quantity');
        } else {
            // User chưa đăng nhập - lấy từ session cart
            return CartItem::where('session_id', $sessionId)
                ->whereNull('user_id')
                ->where('product_id', $productId)
                ->sum('quantity');
        }
    }

    /**
     * Lấy thông tin quantity trong cart theo từng variant combination
     */
    private function getCartQuantitiesByVariants($productId)
    {
        $userId = Auth::id();
        $sessionId = session()->getId();

        $cartItems = collect();
        
        if ($userId) {
            $cartItems = CartItem::where('user_id', $userId)
                ->where('product_id', $productId)
                ->get();
        } else {
            $cartItems = CartItem::where('session_id', $sessionId)
                ->whereNull('user_id')
                ->where('product_id', $productId)
                ->get();
        }

        $result = [];
        foreach ($cartItems as $item) {
            $variantKey = $this->generateVariantKey($item->selected_variants ?: []);
            $result[$variantKey] = ($result[$variantKey] ?? 0) + $item->quantity;
        }

        return $result;
    }

    /**
     * Generate unique key cho variant combination
     */
    private function generateVariantKey($variants)
    {
        if (empty($variants)) {
            return 'no_variants';
        }
        
        ksort($variants);
        return implode('|', array_map(function($k, $v) {
            return "{$k}:{$v}";
        }, array_keys($variants), array_values($variants)));
    }

    /**
     * Lấy thông tin review cho user hiện tại
     */
    private function getReviewInfoForUser($productId)
    {
        if (!Auth::check()) {
            return [
                'can_review' => false,
                'eligible_orders' => [],
                'existing_reviews' => [],
                'message' => 'Vui lòng đăng nhập để đánh giá sản phẩm'
            ];
        }

        $userId = Auth::id();

        // Lấy các đơn hàng đã giao có chứa sản phẩm này
        $eligibleOrders = Order::where('user_id', $userId)
            ->where('status', 'delivered')
            ->whereHas('orderItems', function($query) use ($productId) {
                $query->where('product_id', $productId);
            })
            ->with(['orderItems' => function($query) use ($productId) {
                $query->where('product_id', $productId);
            }])
            ->get();

        // Lấy các review đã có
        $existingReviews = ProductReview::where('user_id', $userId)
            ->where('product_id', $productId)
            ->with('order')
            ->get()
            ->keyBy('order_id');

        // Lọc các đơn hàng chưa được review
        $availableOrders = $eligibleOrders->reject(function($order) use ($existingReviews) {
            return $existingReviews->has($order->id);
        });

        return [
            'can_review' => $availableOrders->count() > 0,
            'eligible_orders' => $availableOrders,
            'existing_reviews' => $existingReviews,
            'message' => $availableOrders->count() > 0 ? '' : 'Bạn cần mua và nhận hàng để có thể đánh giá sản phẩm này'
        ];
    }

/**
    * Đồng bộ giỏ hàng từ localStorage sang user account
    *
    * @param int $userId
    * @param array $cartData
    * @return int Số lượng sản phẩm đã được đồng bộ
    */
private function mergeLocalStorageCartToUser($userId, $cartData)
{
try {
DB::beginTransaction();

if (empty($cartData) || !is_array($cartData)) {
DB::commit();
return 0;
}



$mergedCount = 0;

// Lấy giỏ hàng hiện tại của user
$userCartItems = CartItem::where('user_id', $userId)->get();

foreach ($cartData as $cartItemData) {
// Validate dữ liệu
if (!isset($cartItemData['product_id']) || !isset($cartItemData['quantity'])) {
continue;
}

$productId = $cartItemData['product_id'];
$quantity = (int) $cartItemData['quantity'];
$unitPrice = $cartItemData['unit_price'] ?? 0;
$selectedVariants = $cartItemData['selected_variants'] ?? [];

// Kiểm tra xem sản phẩm có cùng variant đã có trong giỏ hàng user chưa
$existingUserItem = null;
foreach ($userCartItems as $userItem) {
if ($userItem->product_id == $productId) {
// So sánh variants
$userVariants = $userItem->selected_variants ?: [];

if ($selectedVariants == $userVariants) {
$existingUserItem = $userItem;
break;
}
}
}

if ($existingUserItem) {
                    // Nếu đã có, cộng số lượng
                    // Nếu đã có, cộng số lượng nhưng kiểm tra tồn kho
$newQuantity = $existingUserItem->quantity + $quantity;
                    
                    // Kiểm tra tồn kho
                    $product = \App\Models\Product::find($productId);
                    if ($product && $product->track_quantity) {
                        $currentTotalInCart = $this->getTotalProductQuantityInUserCart($userId, $productId);
                        $totalAfterMerge = $currentTotalInCart - $existingUserItem->quantity + $newQuantity;
                        
                        if ($totalAfterMerge > $product->stock_quantity) {
                            // Nếu vượt quá tồn kho, chỉ thêm số lượng có thể
                            $availableQuantity = $product->stock_quantity - ($currentTotalInCart - $existingUserItem->quantity);
                            $newQuantity = $existingUserItem->quantity + max(0, $availableQuantity);
                        }
                    }
                    
$existingUserItem->update([
'quantity' => $newQuantity,
'total_price' => $existingUserItem->unit_price * $newQuantity
]);
} else {
                    // Nếu chưa có, tạo cart item mới cho user
                    CartItem::create([
                        'user_id' => $userId,
                        'session_id' => null,
                        'product_id' => $productId,
                        'selected_variants' => $selectedVariants,
                        'quantity' => $quantity,
                        'unit_price' => $unitPrice,
                        'total_price' => $unitPrice * $quantity
                    ]);
                    // Nếu chưa có, tạo cart item mới cho user nhưng kiểm tra tồn kho
                    $finalQuantity = $quantity;
                    
                    // Kiểm tra tồn kho
                    $product = \App\Models\Product::find($productId);
                    if ($product && $product->track_quantity) {
                        $currentTotalInCart = $this->getTotalProductQuantityInUserCart($userId, $productId);
                        $totalAfterAdd = $currentTotalInCart + $quantity;
                        
                        if ($totalAfterAdd > $product->stock_quantity) {
                            // Nếu vượt quá tồn kho, chỉ thêm số lượng có thể
                            $availableQuantity = $product->stock_quantity - $currentTotalInCart;
                            $finalQuantity = max(0, $availableQuantity);
                        }
                    }
                    
                    // Chỉ tạo nếu có số lượng hợp lệ
                    if ($finalQuantity > 0) {
                        CartItem::create([
                            'user_id' => $userId,
                            'session_id' => null,
                            'product_id' => $productId,
                            'selected_variants' => $selectedVariants,
                            'quantity' => $finalQuantity,
                            'unit_price' => $unitPrice,
                            'total_price' => $unitPrice * $finalQuantity
                        ]);
                    }
}

$mergedCount++;
}

DB::commit();

if ($mergedCount > 0) {
Log::info("Đồng bộ giỏ hàng từ localStorage thành công: {$mergedCount} sản phẩm cho user {$userId}");
}

return $mergedCount;

} catch (\Exception $e) {
DB::rollBack();
// Log error nhưng không throw exception để không ảnh hưởng đến quá trình đăng nhập
Log::error('Lỗi khi đồng bộ giỏ hàng từ localStorage: ' . $e->getMessage(), [
'user_id' => $userId,
'cart_data_count' => count($cartData ?? [])
]);
return 0;
}
}

/**
    * Debug method để kiểm tra session cart
    */
public function debugSessionCart(Request $request)
{
$sessionId = $request->session()->getId();
$userId = Auth::id();
$checkSessionId = $request->get('old_session_id', $sessionId);

// Kiểm tra session cart
$sessionCartItems = CartItem::where('session_id', $checkSessionId)
->whereNull('user_id')
->get();

// Kiểm tra user cart nếu đã đăng nhập
$userCartItems = [];
if ($userId) {
$userCartItems = CartItem::where('user_id', $userId)->get();
}

// Kiểm tra tất cả session cart items (để debug)
$allSessionCartItems = CartItem::whereNull('user_id')
->whereNotNull('session_id')
->get();

return response()->json([
'current_session_id' => $sessionId,
'checking_session_id' => $checkSessionId,
'user_id' => $userId,
'session_cart_count' => $sessionCartItems->count(),
'session_cart_items' => $sessionCartItems->toArray(),
'user_cart_count' => count($userCartItems),
'user_cart_items' => $userCartItems,
'all_session_carts' => $allSessionCartItems->toArray()
]);
}

/**
    * Test method để thêm sản phẩm vào session cart
    */
public function testAddToSessionCart(Request $request)
{
$sessionId = $request->session()->getId();

// Thêm một sản phẩm test vào session cart
$cartItem = CartItem::create([
'user_id' => null,
'session_id' => $sessionId,
'product_id' => 1, // Giả sử có product với ID 1
'selected_variants' => [],
'quantity' => 1,
'unit_price' => 100000,
'total_price' => 100000
]);

return response()->json([
'message' => 'Đã thêm sản phẩm test vào session cart',
'session_id' => $sessionId,
'cart_item_id' => $cartItem->id,
'debug_url' => route('client.cart.debug')
]);
}

/**
    * API để lấy session cart hiện tại (để lưu vào localStorage)
    */
public function getCurrentSessionCart(Request $request)
{
$sessionId = $request->session()->getId();

// Lấy giỏ hàng từ session hiện tại
$sessionCartItems = CartItem::with('product')
->where('session_id', $sessionId)
->whereNull('user_id')
->get();

// Chuyển đổi thành format đơn giản cho localStorage
$cartData = $sessionCartItems->map(function ($item) {
return [
'product_id' => $item->product_id,
'quantity' => $item->quantity,
'unit_price' => $item->unit_price,
'total_price' => $item->total_price,
'selected_variants' => $item->selected_variants,
'product_name' => $item->product->name ?? 'Unknown Product'
];
});

return response()->json([
'success' => true,
'cart_data' => $cartData,
'count' => $cartData->count()
]);
}

    /**
     * Tính tổng số lượng của một sản phẩm (tất cả biến thể) trong giỏ hàng của user
     */
    private function getTotalProductQuantityInUserCart($userId, $productId)
    {
        return CartItem::where('user_id', $userId)
            ->where('product_id', $productId)
            ->sum('quantity');
    }
}