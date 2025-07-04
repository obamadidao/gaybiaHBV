<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Coupon;
use Illuminate\Http\Request;
use Carbon\Carbon;

class CouponController extends Controller
{
    public function index()
    public function index(Request $request)
{
        $coupons = Coupon::orderByDesc('id')->get();
        $query = Coupon::query();
        
        // Lọc theo từ khóa tìm kiếm
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where('code', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
        }
        
        // Lọc theo loại mã giảm giá
        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }
        
        // Lọc theo trạng thái
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        
        // Lọc theo thời hạn
        if ($request->filled('validity')) {
            $today = Carbon::now();
            
            if ($request->validity === 'active') {
                $query->where(function($q) use ($today) {
                    $q->where(function($q) use ($today) {
                        $q->whereNull('start_date')
                          ->whereNull('end_date');
                    })->orWhere(function($q) use ($today) {
                        $q->whereNull('start_date')
                          ->whereDate('end_date', '>=', $today);
                    })->orWhere(function($q) use ($today) {
                        $q->whereDate('start_date', '<=', $today)
                          ->whereNull('end_date');
                    })->orWhere(function($q) use ($today) {
                        $q->whereDate('start_date', '<=', $today)
                          ->whereDate('end_date', '>=', $today);
                    });
                });
            } elseif ($request->validity === 'expired') {
                $query->where(function($q) use ($today) {
                    $q->whereDate('end_date', '<', $today)
                      ->orWhere(function($q) use ($today) {
                          $q->whereDate('start_date', '>', $today);
                      });
                });
            }
        }
        
        $coupons = $query->orderByDesc('id')->get();
return view('admin.coupons.index', compact('coupons'));
}

public function store(Request $request)
{
try {
// Validate cơ bản
$request->validate([
'code' => 'required|string|max:50|unique:coupons,code',
'type' => 'required|in:percent,fixed',
]);

// Validate value dựa vào type
if ($request->type === 'percent') {
$request->validate([
'value' => 'required|numeric|min:1|max:99',
]);
} else {
$request->validate([
'value' => 'required|numeric|min:1',
]);
}

// Validate các trường khác
$validated = $request->validate([
'max_discount_value' => 'nullable|numeric|min:0',
'min_order_value' => 'nullable|numeric|min:0',
'max_uses' => 'nullable|integer|min:1',
'start_date' => 'nullable|date',
'end_date' => 'nullable|date|after_or_equal:start_date',
'description' => 'nullable|string',
'status' => 'nullable|boolean',
]);

// Gộp các trường đã validate
$validated['code'] = $request->code;
$validated['type'] = $request->type;
$validated['value'] = $request->value;

// Xử lý trường status từ checkbox
$validated['status'] = $request->has('status') ? 1 : 0;

// Xử lý ngày tháng
if ($request->filled('start_date')) {
$validated['start_date'] = \Carbon\Carbon::parse($request->start_date)->startOfDay();
}

if ($request->filled('end_date')) {
$validated['end_date'] = \Carbon\Carbon::parse($request->end_date)->endOfDay();
}

// Khởi tạo used = 0
$validated['used'] = 0;

$coupon = \App\Models\Coupon::create($validated);

return response()->json([
'success' => true, 
'message' => 'Thêm mã giảm giá thành công!',
'coupon' => $coupon
]);

} catch (\Illuminate\Validation\ValidationException $e) {
return response()->json([
'success' => false,
'message' => 'Dữ liệu không hợp lệ!',
'errors' => $e->errors()
], 422);
} catch (\Exception $e) {
return response()->json([
'success' => false,
'message' => 'Có lỗi xảy ra: ' . $e->getMessage()
], 500);
}
}

public function show($id)
{
try {
$coupon = Coupon::findOrFail($id);
return response()->json([
'success' => true,
'coupon' => $coupon
]);
} catch (\Exception $e) {
return response()->json([
'success' => false,
'message' => 'Không tìm thấy mã giảm giá!'
], 404);
}
}

public function update(Request $request, $id)
{
try {
$coupon = Coupon::findOrFail($id);

// Validate cơ bản
$request->validate([
'code' => 'required|string|max:50|unique:coupons,code,' . $id,
'type' => 'required|in:percent,fixed',
]);

// Validate value dựa vào type
if ($request->type === 'percent') {
$request->validate([
'value' => 'required|numeric|min:1|max:99',
]);
} else {
$request->validate([
'value' => 'required|numeric|min:1',
]);
}

// Validate các trường khác
$validated = $request->validate([
'max_discount_value' => 'nullable|numeric|min:0',
'min_order_value' => 'nullable|numeric|min:0',
'max_uses' => 'nullable|integer|min:1',
'start_date' => 'nullable|date',
'end_date' => 'nullable|date|after_or_equal:start_date',
'description' => 'nullable|string',
'status' => 'nullable|boolean',
]);

// Gộp các trường đã validate
$validated['code'] = $request->code;
$validated['type'] = $request->type;
$validated['value'] = $request->value;

// Xử lý trường status từ checkbox
$validated['status'] = $request->has('status') ? 1 : 0;

// Xử lý ngày tháng
if ($request->filled('start_date')) {
$validated['start_date'] = \Carbon\Carbon::parse($request->start_date)->startOfDay();
} else {
$validated['start_date'] = null;
}

if ($request->filled('end_date')) {
$validated['end_date'] = \Carbon\Carbon::parse($request->end_date)->endOfDay();
} else {
$validated['end_date'] = null;
}

$coupon->update($validated);

return response()->json([
'success' => true, 
'message' => 'Cập nhật mã giảm giá thành công!',
'coupon' => $coupon
]);

} catch (\Illuminate\Validation\ValidationException $e) {
return response()->json([
'success' => false,
'message' => 'Dữ liệu không hợp lệ!',
'errors' => $e->errors()
], 422);
} catch (\Exception $e) {
return response()->json([
'success' => false,
'message' => 'Có lỗi xảy ra: ' . $e->getMessage()
], 500);
}
}