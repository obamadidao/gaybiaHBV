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

        // Lấy sản phẩm mới nhất
        $newProducts = Product::with(['category', 'reviews', 'approvedReviews', 'primaryImage'])
            ->where('is_active', 1)
            ->orderBy('created_at', 'desc')
            ->limit(8)
            ->get()
            ->map(function ($product) {
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
            ->map(function ($product) {
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
            ->map(function ($product) {
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
        return view('client.profile', compact('user'));
    }

    public function updateProfile(Request $request)
    {
    
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
        return view('client.profile', compact('user'));
    }

    public function updateProfile(Request $request) {}


    // Danh sách sản phẩm theo danh mục 
    public function category($slug)
    {
        $category = Category::with('children')->where('slug', $slug)->firstOrFail();
        $products = $category->products()->paginate(12);
        $category = Category::with('children', 'parent')->where('slug', $slug)->firstOrFail();
        // Nếu là danh mục cha, lấy sản phẩm của cả danh mục con
        if ($category->children->count() > 0) {
            $categoryIds = $category->getAllChildrenIds();
            $categoryIds[] = $category->id;
            $products = Product::whereIn('category_id', $categoryIds)->paginate(12);
        } else {
            $products = $category->products()->paginate(12);
        }
        return view('client.category', compact('category', 'products'));
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
