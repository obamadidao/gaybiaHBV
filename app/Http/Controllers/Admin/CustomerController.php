<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\CustomerProfile;
use App\Models\Order;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CustomerController extends Controller
{
    /**
     * Hiển thị danh sách khách hàng
     */
    public function index(Request $request)
    {
        $query = User::with(['role', 'customerProfile'])
            ->whereHas('role', function($q) {
                $q->where('name', 'user');
            });

        // Lọc theo tên/email
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhereHas('customerProfile', function($subQ) use ($search) {
                      $subQ->where('first_name', 'like', "%{$search}%")
                           ->orWhere('last_name', 'like', "%{$search}%")
                           ->orWhere('phone', 'like', "%{$search}%");
                  });
            });
        }

        // Lọc theo trạng thái xác thực
        if ($request->filled('is_verified')) {
            $query->whereHas('customerProfile', function($q) use ($request) {
                $q->where('is_verified', $request->is_verified);
            });
        }

        // Lọc theo thành phố
        if ($request->filled('city')) {
            $query->whereHas('customerProfile', function($q) use ($request) {
                $q->where('city', $request->city);
            });
        }

        $customers = $query->withCount(['orders', 'transactions'])
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        // Lấy danh sách thành phố để filter
        $cities = CustomerProfile::distinct('city')
            ->whereNotNull('city')
            ->pluck('city')
            ->sort();

        return view('admin.customers.index', compact('customers', 'cities'));
    }

    /**
     * Hiển thị chi tiết khách hàng
     */
    public function show($id)
    {
        $customer = User::with(['role', 'customerProfile', 'orders.orderItems.product', 'transactions'])
            ->findOrFail($id);

        // Thống kê tổng quan
        $stats = [
            'total_orders' => $customer->orders->count(),
            'total_spent' => $customer->orders->where('payment_status', 'paid')->sum('total_amount'),
            'total_transactions' => $customer->transactions->count(),
            'avg_order_value' => $customer->orders->count() > 0 
                ? $customer->orders->where('payment_status', 'paid')->avg('total_amount') 
                : 0,
        ];

        // Đơn hàng gần đây
        $recentOrders = $customer->orders()
            ->with(['orderItems.product'])
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        // Giao dịch gần đây
        $recentTransactions = $customer->transactions()
            ->with('order')
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();

        return view('admin.customers.show', compact(
            'customer', 
            'stats', 
            'recentOrders', 
            'recentTransactions'
        ));
    }

    /**
     * Cập nhật thông tin khách hàng
     */
    public function update(Request $request, $id)
    {
        $customer = User::findOrFail($id);
        
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $id,
            'first_name' => 'nullable|string|max:255',
            'last_name' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:20',
            'date_of_birth' => 'nullable|date',
            'gender' => 'nullable|in:male,female,other',
            'address' => 'nullable|string',
            'city' => 'nullable|string|max:255',
            'district' => 'nullable|string|max:255',
            'ward' => 'nullable|string|max:255',
            'postal_code' => 'nullable|string|max:10',
            'notes' => 'nullable|string',
        ]);

        DB::beginTransaction();
        try {
            // Cập nhật thông tin user
            $customer->update([
                'name' => $request->name,
                'email' => $request->email,
            ]);

            // Cập nhật hoặc tạo profile
            $profileData = $request->only([
                'first_name', 'last_name', 'phone', 'date_of_birth',
                'gender', 'address', 'city', 'district', 'ward',
                'postal_code', 'notes'
            ]);

            $customer->customerProfile()->updateOrCreate(
                ['user_id' => $customer->id],
                $profileData
            );

            DB::commit();
            
            return redirect()
                ->route('admin.customers.show', $customer)
                ->with('success', 'Thông tin khách hàng đã được cập nhật.');
                
        } catch (\Exception $e) {
            DB::rollback();
            return back()
                ->withInput()
                ->with('error', 'Có lỗi xảy ra khi cập nhật thông tin.');
        }
    }

    /**
     * Xác thực khách hàng
     */
    public function verify($id)
    {
        $customer = User::with('customerProfile')->findOrFail($id);
        
        if ($customer->customerProfile) {
            $customer->customerProfile->update([
                'is_verified' => true,
                'verified_at' => now(),
            ]);
        }

        return redirect()
            ->route('admin.customers.show', $customer)
            ->with('success', 'Khách hàng đã được xác thực.');
    }

    /**
     * Hủy xác thực khách hàng
     */
    public function unverify($id)
    {
        $customer = User::with('customerProfile')->findOrFail($id);
        
        if ($customer->customerProfile) {
            $customer->customerProfile->update([
                'is_verified' => false,
                'verified_at' => null,
            ]);
        }

        return redirect()
            ->route('admin.customers.show', $customer)
            ->with('success', 'Xác thực khách hàng đã được hủy.');
    }

    /**
     * Xóa khách hàng
     */
    public function destroy($id)
    {
        $customer = User::findOrFail($id);
        
        // Kiểm tra xem khách hàng có đơn hàng không
        if ($customer->orders()->count() > 0) {
            return redirect()
                ->route('admin.customers.index')
                ->with('error', 'Không thể xóa khách hàng đã có đơn hàng.');
        }

        $customer->delete();

        return redirect()
            ->route('admin.customers.index')
            ->with('success', 'Khách hàng đã được xóa.');
    }
}