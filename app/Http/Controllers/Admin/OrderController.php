<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
/**
    * Hiển thị danh sách đơn hàng
    */
public function index(Request $request)
{
$query = Order::with(['user', 'orderItems', 'customer'])
->latest();

// Lọc theo trạng thái
if ($request->filled('status')) {
$query->where('status', $request->status);
}

// Lọc theo trạng thái thanh toán
if ($request->filled('payment_status')) {
$query->where('payment_status', $request->payment_status);
}

// Tìm kiếm theo số đơn hàng hoặc tên khách hàng
if ($request->filled('search')) {
$search = $request->search;
$query->where(function($q) use ($search) {
$q->where('order_number', 'like', "%{$search}%")
->orWhereHas('user', function($q) use ($search) {
$q->where('name', 'like', "%{$search}%")
->orWhere('email', 'like', "%{$search}%");
});
});
}

// Lọc theo khoảng thời gian
if ($request->filled('date_from')) {
$query->whereDate('created_at', '>=', $request->date_from);
}
if ($request->filled('date_to')) {
$query->whereDate('created_at', '<=', $request->date_to);
}

$orders = $query->paginate(10);

// Thống kê
$stats = [
'total' => Order::count(),
'pending' => Order::where('status', 'pending')->count(),
'processing' => Order::where('status', 'processing')->count(),
'shipped' => Order::where('status', 'shipped')->count(),
'delivered' => Order::where('status', 'delivered')->count(),
'cancelled' => Order::where('status', 'cancelled')->count(),
'total_revenue' => Order::where('status', '!=', 'cancelled')->sum('total_amount'),
];

return view('admin.orders.index', compact('orders', 'stats'));
}

/**
    * Hiển thị chi tiết đơn hàng
    */
public function show(Order $order)
{
        // TODO: Implement show order details
        $order->load(['user.customerProfile', 'orderItems.product.primaryImage', 'transactions']);
return view('admin.orders.show', compact('order'));
}

@@ -76,7 +76,22 @@
    */
public function updateStatus(Request $request, Order $order)
{
        // TODO: Implement update order status
        $request->validate([
            'status' => 'required|in:processing,shipped,delivered,cancelled'
        ]);

        try {
            $order->update([
                'status' => $request->status,
                'shipped_at' => $request->status === 'shipped' ? now() : $order->shipped_at,
                'delivered_at' => $request->status === 'delivered' ? now() : $order->delivered_at,
                'cancelled_at' => $request->status === 'cancelled' ? now() : $order->cancelled_at,
            ]);

            return redirect()->back()->with('success', 'Cập nhật trạng thái đơn hàng thành công');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Có lỗi xảy ra khi cập nhật trạng thái đơn hàng');
        }
}

/**