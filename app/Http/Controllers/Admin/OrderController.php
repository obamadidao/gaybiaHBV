<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Exports\OrdersExport;
use Maatwebsite\Excel\Facades\Excel;

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
$order->load(['user.customerProfile', 'orderItems.product.primaryImage', 'transactions']);
return view('admin.orders.show', compact('order'));
}

/**
    * Cập nhật trạng thái đơn hàng
    */
public function updateStatus(Request $request, Order $order)
{
$request->validate([
'status' => 'required|in:processing,shipped,delivered,cancelled,refunded',
'admin_notes' => 'required_if:status,cancelled,refunded',
'evidence_image' => 'required_if:status,refunded|nullable|image|max:2048'
]);

try {
DB::beginTransaction();

$oldStatus = $order->status;
$newStatus = $request->status;

// Kiểm tra quy trình chuyển trạng thái
if (!$this->isValidStatusTransition($oldStatus, $newStatus)) {
throw new \Exception('Không thể chuyển từ trạng thái ' . $oldStatus . ' sang ' . $newStatus);
}

// Xử lý hủy đơn hàng
if ($newStatus === 'cancelled') {
$order->cancellation_reason = $request->admin_notes;
$order->cancelled_by = auth()->id();
$order->cancelled_at = now();

if ($request->hasFile('evidence_image')) {
$path = $request->file('evidence_image')->store('order-evidence', 'public');
$order->cancellation_evidence = $path;
}
}

// Xử lý hoàn tiền
if ($newStatus === 'refunded') {
$order->refund_reason = $request->admin_notes;
$order->refunded_by = auth()->user()->id;
$order->refunded_at = now();
$order->refund_amount = $order->total_amount;

if ($request->hasFile('evidence_image')) {
$path = $request->file('evidence_image')->store('order-evidence', 'public');
$order->refund_evidence = $path;
}
}

$order->status = $newStatus;
$order->admin_notes = $request->admin_notes;
$order->save();

// Thêm vào lịch sử trạng thái
$order->addStatusHistory($newStatus, $request->admin_notes, auth()->id());

DB::commit();
return redirect()->back()->with('success', 'Cập nhật trạng thái đơn hàng thành công');
} catch (\Exception $e) {
DB::rollBack();
return redirect()->back()->with('error', 'Có lỗi xảy ra: ' . $e->getMessage());
}
}

private function isValidStatusTransition($oldStatus, $newStatus)
{
$validTransitions = [
'pending' => ['processing', 'cancelled'],
'processing' => ['shipped', 'cancelled'],
'shipped' => ['delivered'],
'delivered' => ['refunded'],
'cancelled' => [],
'refunded' => []
];

return in_array($newStatus, $validTransitions[$oldStatus] ?? []);
}

/**
    * Cập nhật trạng thái thanh toán
    */
public function updatePaymentStatus(Request $request, Order $order)
{
// TODO: Implement update payment status
}

public function update(Request $request, Order $order)
{
$request->validate([
'shipping_address.name' => 'required|string|max:255',
'shipping_address.phone' => 'required|string|max:20',
'shipping_address.address' => 'required|string|max:255',
'shipping_address.ward' => 'required|string|max:255',
'shipping_address.district' => 'required|string|max:255',
'shipping_address.city' => 'required|string|max:255',
'admin_notes' => 'nullable|string|max:1000',
]);

try {
DB::beginTransaction();

// Cập nhật thông tin người nhận
$shippingAddress = $order->shipping_address;
$shippingAddress['name'] = $request->shipping_address['name'];
$shippingAddress['phone'] = $request->shipping_address['phone'];
$shippingAddress['address'] = $request->shipping_address['address'];
$shippingAddress['ward'] = $request->shipping_address['ward'];
$shippingAddress['district'] = $request->shipping_address['district'];
$shippingAddress['city'] = $request->shipping_address['city'];

$order->shipping_address = $shippingAddress;
$order->admin_notes = $request->admin_notes;
$order->save();

// Thêm vào lịch sử trạng thái
$order->addStatusHistory(
$order->status,
'Cập nhật thông tin đơn hàng: ' . ($request->admin_notes ?? 'Không có ghi chú'),
auth()->id()
);

DB::commit();
return redirect()->back()->with('success', 'Cập nhật thông tin đơn hàng thành công');
} catch (\Exception $e) {
DB::rollBack();
return redirect()->back()->with('error', 'Có lỗi xảy ra: ' . $e->getMessage());
}
}

public function edit(Order $order)
{
return response()->json([
'shipping_address' => $order->shipping_address,
'admin_notes' => $order->admin_notes
]);
}

    public function export(Request $request)
    {
        $query = Order::with(['user', 'orderItems.product'])
            ->latest();

        // Áp dụng các bộ lọc
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('payment_status')) {
            $query->where('payment_status', $request->payment_status);
        }

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

        if ($request->filled(['start_date', 'end_date'])) {
            $query->whereBetween('created_at', [
                $request->start_date . ' 00:00:00',
                $request->end_date . ' 23:59:59'
            ]);
        }

        $orders = $query->get();

        return Excel::download(new OrdersExport($orders), 'danh-sach-don-hang.xlsx');
    }
} 