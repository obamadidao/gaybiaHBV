<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use App\Models\Category;
use App\Models\Coupon;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

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


        $cateRoot = Category::withAllProductsCount(
            Category::where('is_active', 1)
                ->where('parent_id', null)
                ->get(),
            true
        );
        
        return view('client.index', compact('banners', 'cateRoot'));
    }
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
   /**
     * Relationship với tất cả sản phẩm của danh mục và các danh mục con
     */
    public function allProducts()
    {
        $categoryIds = $this->getAllChildrenIds();
        return $this->hasMany(Product::class, 'category_id')->whereIn('category_id', $categoryIds);
    }

    /**
     * Lấy số lượng tất cả sản phẩm hoạt động (bao gồm danh mục con)
     */
    public function getAllProductsCountAttribute()
    {
        $categoryIds = $this->getAllChildrenIds();
        return \App\Models\Product::whereIn('category_id', $categoryIds)
                     ->where('is_active', true)
                     ->count();
    }

    /**
     * Lấy số lượng tất cả sản phẩm (bao gồm danh mục con) - không phân biệt trạng thái
     */
    public function getTotalProductsCountAttribute()
    {
        $categoryIds = $this->getAllChildrenIds();
        return \App\Models\Product::whereIn('category_id', $categoryIds)->count();
    }

    /**
     * Static method: Lấy danh mục kèm tổng số sản phẩm của nó và các danh mục con
     */
    public static function withAllProductsCount($categories = null, $activeOnly = true)
    {
        if ($categories === null) {
            $categories = static::all();
        }
        
        return $categories->map(function ($category) use ($activeOnly) {
            $categoryIds = $category->getAllChildrenIds();
            
            $productsQuery = \App\Models\Product::whereIn('category_id', $categoryIds);
            if ($activeOnly) {
                $productsQuery->where('is_active', true);
            }
            
            $category->all_products_count = $productsQuery->count();
            return $category;
        });
    }
}
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
    //  Validate dữ liệu đầu vào
    $request->validate([
        'email' => ['required', 'email'],
        'password' => ['required', 'min:6']
    ], [
        'email.required' => 'Vui lòng nhập email',
        'email.email' => 'Email không hợp lệ',
        'password.required' => 'Vui lòng nhập mật khẩu',
        'password.min' => 'Mật khẩu phải có ít nhất 6 ký tự'
    ]);

    $credentials = $request->only('email', 'password');
    $remember = $request->boolean('remember'); // tốt hơn: boolean thay vì has()

    //  Kiểm tra đăng nhập
    if (Auth::attempt($credentials, $remember)) {
        $request->session()->regenerate(); // regenerate phiên để tránh session fixation
        $user = Auth::user();

        //  Chỉ cho phép role_id = 2 (khách hàng)
        if ($user->role_id == 2) {
            return redirect()->intended(route('client.index'))
                ->with('success', 'Đăng nhập thành công! Chào mừng ' . $user->name);
        }

        //  Nếu không đúng quyền, đăng xuất ngay
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login') // về lại trang login
            ->with('error', 'Tài khoản không có quyền truy cập.');
    }

    // Sai thông tin đăng nhập
    return back()->withErrors([
        'email' => 'Email hoặc mật khẩu không đúng.'
    ])->withInput($request->only('email'));
}

public function logout(Request $request)
{
    if (Auth::check()) {
        $user = Auth::user();
        \Log::info('User logged out', ['id' => $user->id, 'email' => $user->email]);
    }

    Auth::logout();

    $request->session()->invalidate();
    $request->session()->regenerateToken();

    return redirect()->route('client.index')
        ->with('success', 'Bạn đã đăng xuất thành công!');
}

public function registerUser()
{
return view('client.register');
}

public function handleRegister(Request $request)
{
    //  Validate dữ liệu đăng ký
    $validator = \Validator::make($request->all(), [
        'name' => 'required|string|max:255',
        'email' => 'required|string|email|max:255|unique:users,email',
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

    //  Nếu lỗi thì trả lại form kèm lỗi và giữ lại dữ liệu đã nhập
    if ($validator->fails()) {
        return back()->withErrors($validator)
                     ->withInput();
    }

    //  Tạo user mới (role_id = 2: khách hàng)
    $user = User::create([
        'name' => $request->input('name'),
        'email' => $request->input('email'),
        'password' => Hash::make($request->input('password')),
        'role_id' => 2, // khách hàng
    ]);

    //  Đăng nhập tự động
    Auth::login($user);

    return redirect()->route('client.index')
        ->with('success', 'Đăng ký thành công! Chào mừng bạn đến với cửa hàng Bida!');
}

public function profile()
{
    $user = Auth::user();
    return view('client.profile', compact('user'));
}

public function updateProfile(Request $request)
{

}


// Danh sách sản phẩm theo danh mục 
    public function category($slug)
  
{
$category = Category::with('children', 'parent')->where('slug', $slug)->firstOrFail();
        // Nếu là danh mục cha, lấy sản phẩm của cả danh mục con
        
        // Lấy sort parameter từ request
        $sortBy = $request->get('sort', 'featured'); // Mặc định là mới nhất
        
        // Khởi tạo query
if ($category->children->count() > 0) {
            // Nếu là danh mục cha, lấy sản phẩm của cả danh mục con
$categoryIds = $category->getAllChildrenIds();
$categoryIds[] = $category->id;
            $products = Product::whereIn('category_id', $categoryIds)->paginate(12);
            $query = Product::with(['category', 'primaryImage', 'reviews'])
                ->whereIn('category_id', $categoryIds)
                ->where('is_active', 1);
} else {
            $products = $category->products()->paginate(12);
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
        return view('client.category', compact('category', 'products'));
        
        // Paginate kết quả
        $products = $query->paginate(12)->withQueryString(); // withQueryString để giữ sort param trong pagination
        
        return view('client.category', compact('category', 'products', 'sortBy'));
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