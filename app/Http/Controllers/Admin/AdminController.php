<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Product;
use App\Models\Category;
use App\Models\User;
use App\Models\ProductVariant;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
/**
    * Display a listing of the resource.
    */
public function index(Request $request)
{
// Lấy thông tin bộ lọc
$type = $request->input('type', 'monthly');
$year = $request->input('year', Carbon::now()->year);
$month = $request->input('month', Carbon::now()->month);
$startDate = $request->input('start_date');
$endDate = $request->input('end_date');

// Tính toán khoảng thời gian dựa trên bộ lọc
$dateRange = $this->getDateRangeByType($type, $year, $month, $startDate, $endDate);

// Nếu là AJAX request và có bộ lọc, xử lý dữ liệu theo bộ lọc
if ($request->ajax() && $request->has('type')) {
return $this->getFilteredDashboardData($type, $year, $month, $startDate, $endDate);
}
// Thống kê doanh thu
$currentMonth = Carbon::now()->month;
$currentYear = Carbon::now()->year;
$lastMonth = Carbon::now()->subMonth();

// Doanh thu tháng hiện tại
$monthlyRevenue = Order::where('status', 'delivered')
->where('payment_status', 'paid')
->whereNotNull('delivered_at')
->whereMonth('delivered_at', $currentMonth)
->whereYear('delivered_at', $currentYear)
->sum('total_amount');

// Doanh thu tháng trước
$lastMonthRevenue = Order::where('status', 'delivered')
->where('payment_status', 'paid')
->whereNotNull('delivered_at')
->whereMonth('delivered_at', $lastMonth->month)
->whereYear('delivered_at', $lastMonth->year)
->sum('total_amount');

// Tính phần trăm tăng/giảm
$revenueChange = 0;
if ($lastMonthRevenue > 0) {
$revenueChange = (($monthlyRevenue - $lastMonthRevenue) / $lastMonthRevenue) * 100;
}

// Doanh thu năm hiện tại
$yearlyRevenue = Order::where('status', 'delivered')
->where('payment_status', 'paid')
->whereNotNull('delivered_at')
->whereYear('delivered_at', $currentYear)
->sum('total_amount');

// Doanh thu năm so với năm trước
$lastYearRevenue = Order::where('status', 'delivered')
->where('payment_status', 'paid')
->whereNotNull('delivered_at')
->whereYear('delivered_at', $currentYear - 1)
->sum('total_amount');
if($lastYearRevenue <= 0 ){
$yearTargetPercent = ($yearlyRevenue / 1000) * 100;
}else{
$yearTargetPercent = ($yearlyRevenue / $lastYearRevenue) * 100;
}

// Dữ liệu cho biểu đồ doanh thu
$chartData = $this->getRevenueChartData('monthly', $currentYear, $currentMonth);

// Đơn hàng đang xử lý
$processingOrders = Order::whereIn('status', ['pending', 'processing'])
->count();

// Tổng số đơn hàng
$totalOrders = Order::count();
$processingPercent = ($processingOrders / ($totalOrders ?: 1)) * 100;

// Số lượng khách hàng
$totalCustomers = User::whereHas('role', function($q) {
$q->where('name', 'customer');
})->count();

// Đơn hàng đã giao thành công trong tháng (thay vì khách hàng mới)
$deliveredOrders = Order::where('status', 'delivered')
->whereNotNull('delivered_at')
->whereMonth('delivered_at', $currentMonth)
->whereYear('delivered_at', $currentYear)
->count();

// Tổng đơn hàng đã giao thành công
$totalDeliveredOrders = Order::where('status', 'delivered')
->whereNotNull('delivered_at')
->count();

// Đơn hàng mới nhất
$latestOrders = Order::with('user')
->orderBy('created_at', 'desc')
->take(5)
->get();

// Thống kê theo danh mục
$categoryStats = Category::withCount(['products' => function($query) {
$query->where('is_active', true);
}])
->whereHas('products', function($query) {
$query->where('is_active', true);
})
->orderBy('products_count', 'desc')
->take(5)
->get();

// Tính doanh thu theo danh mục
$categoryRevenue = [];
foreach ($categoryStats as $category) {
$revenue = DB::table('orders')
->join('order_items', 'orders.id', '=', 'order_items.order_id')
->join('products', 'order_items.product_id', '=', 'products.id')
->where('products.category_id', $category->id)
->where('orders.status', 'delivered')
->where('orders.payment_status', 'paid')
->whereNotNull('orders.delivered_at')
->sum(DB::raw('order_items.unit_price * order_items.quantity'));

$categoryRevenue[$category->id] = $revenue;
}

// Tổng doanh thu từ tất cả danh mục
$totalCategoryRevenue = array_sum($categoryRevenue);

// Sản phẩm tồn kho thấp
$lowStockProducts = Product::where('is_active', true)
->where(function($query) {
$query->where('stock_quantity', '<=', DB::raw('min_stock'))
->where('stock_quantity', '>', 0)
->where('track_quantity', true);
})
->orderBy('stock_quantity')
->take(5)
->get();

return view('admin.Dashboard', compact(
'monthlyRevenue',
'revenueChange',
'yearlyRevenue',
'yearTargetPercent',
'processingOrders',
'processingPercent',
'totalCustomers',
'deliveredOrders',
'totalDeliveredOrders',
'latestOrders',
'categoryStats',
'categoryRevenue',
'totalCategoryRevenue',
'lowStockProducts',
'currentMonth',
'currentYear',
'lastMonth',
'lastMonthRevenue',
'chartData'
));
}

/**
    * Lấy dữ liệu doanh thu cho biểu đồ
    * @param string $type (daily, monthly, yearly, date_range)
    * @param int $year
    * @param int|null $month
    * @param string|null $startDate
    * @param string|null $endDate
    * @return array
    */
private function getRevenueChartData($type = 'monthly', $year = null, $month = null, $startDate = null, $endDate = null)
{
if (!$year) {
$year = Carbon::now()->year;
}

if (!$month) {
$month = Carbon::now()->month;
}

$data = [
'labels' => [],
'datasets' => [
[
'label' => 'Doanh thu',
'data' => [],
'backgroundColor' => 'rgba(78, 115, 223, 0.2)',
'borderColor' => 'rgba(78, 115, 223, 1)',
'borderWidth' => 1
]
]
];

switch ($type) {
case 'date_range':
if (!$startDate || !$endDate) {
// Mặc định lấy 30 ngày gần nhất
$endDate = Carbon::now();
$startDate = Carbon::now()->subDays(29);
} else {
$startDate = Carbon::parse($startDate);
$endDate = Carbon::parse($endDate);
}

$currentDate = $startDate->copy();
while ($currentDate <= $endDate) {
$data['labels'][] = $currentDate->format('d/m');

$revenue = Order::where('status', 'delivered')
->where('payment_status', 'paid')
->whereNotNull('delivered_at')
->whereDate('delivered_at', $currentDate)
->sum('total_amount');

$data['datasets'][0]['data'][] = $revenue;
$currentDate->addDay();
}
break;

case 'daily':
// Lấy số ngày trong tháng
$daysInMonth = Carbon::createFromDate($year, $month, 1)->daysInMonth;

for ($day = 1; $day <= $daysInMonth; $day++) {
$date = Carbon::createFromDate($year, $month, $day);
$data['labels'][] = $day;

$revenue = Order::where('status', 'delivered')
->where('payment_status', 'paid')
->whereNotNull('delivered_at')
->whereDate('delivered_at', $date)
->sum('total_amount');

$data['datasets'][0]['data'][] = $revenue;
}
break;

case 'monthly':
// Lấy doanh thu theo tháng trong năm
for ($m = 1; $m <= 12; $m++) {
$data['labels'][] = Carbon::create($year, $m)->format('m/Y');

$revenue = Order::where('status', 'delivered')
->where('payment_status', 'paid')
->whereNotNull('delivered_at')
->whereYear('delivered_at', $year)
->whereMonth('delivered_at', $m)
->sum('total_amount');

$data['datasets'][0]['data'][] = $revenue;
}
break;

case 'yearly':

$currentYear = Carbon::now()->year;
$startYear = $currentYear - 4;

for ($y = $startYear; $y <= $currentYear; $y++) {
$data['labels'][] = $y;

$revenue = Order::where('status', 'delivered')
->where('payment_status', 'paid')
->whereNotNull('delivered_at')
->whereYear('delivered_at', $y)
->sum('total_amount');

$data['datasets'][0]['data'][] = $revenue;
}
break;
}

return $data;
}

/**
    * API để lấy dữ liệu biểu đồ doanh thu
    */
public function getRevenueChart(Request $request)
{
$type = $request->input('type', 'monthly');
$year = $request->input('year', Carbon::now()->year);
$month = $request->input('month', Carbon::now()->month);
$startDate = $request->input('start_date');
$endDate = $request->input('end_date');

$data = $this->getRevenueChartData($type, $year, $month, $startDate, $endDate);

return response()->json($data);
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
     * API endpoint cho fallback polling - lấy notifications cho admin
     */
    public function getNotifications(Request $request)
    {
        $lastUpdate = $request->query('last_update', now()->subMinutes(5)->toISOString());
        
        // Lấy đơn hàng mới sau thời điểm cuối cùng
        $newOrders = Order::where('created_at', '>', $lastUpdate)
            ->with(['user', 'customer.user'])
            ->latest('created_at')
            ->limit(5)
            ->get();
        
        // Lấy đơn hàng có thay đổi trạng thái sau thời điểm cuối cùng
        $updatedOrders = Order::where('updated_at', '>', $lastUpdate)
            ->where('created_at', '<=', $lastUpdate) // Loại trừ đơn hàng mới
            ->with(['user', 'customer.user'])
            ->latest('updated_at')
            ->limit(10)
            ->get();
        
        $notifications = [];
        
        // Thêm thông báo đơn hàng mới
        foreach ($newOrders as $order) {
            $notifications[] = [
                'type' => 'new_order',
                'order_id' => $order->id,
                'order_code' => $order->order_number,
                'customer_name' => $order->user->name ?? $order->customer->full_name ?? 'Guest',
                'customer_email' => $order->user->email ?? '',
                'total_amount' => $order->total_amount,
                'payment_method' => $order->payment_method,
                'created_at' => $order->created_at->toISOString(),
                'message' => "Đơn hàng mới #{$order->order_number}"
            ];
        }
        
        // Thêm thông báo thay đổi trạng thái
        foreach ($updatedOrders as $order) {
            $notifications[] = [
                'type' => 'status_changed',
                'order_id' => $order->id,
                'order_code' => $order->order_number,
                'customer_name' => $order->user->name ?? $order->customer->full_name ?? 'Guest',
                'total_amount' => $order->total_amount,
                'new_status' => $order->status,
                'updated_at' => $order->updated_at->toISOString(),
                'status_text' => $this->getStatusText($order->status),
                'message' => "Đơn hàng #{$order->order_number} đã cập nhật"
            ];
        }
        
        // Sắp xếp theo thời gian
        usort($notifications, function($a, $b) {
            $timeA = $a['created_at'] ?? $a['updated_at'];
            $timeB = $b['created_at'] ?? $b['updated_at'];
            return strtotime($timeB) - strtotime($timeA);
        });
        
        return response()->json([
            'success' => true,
            'notifications' => array_slice($notifications, 0, 10),
            'timestamp' => now()->toISOString()
        ]);
    }

    /**
     * Helper để lấy status text
     */
    private function getStatusText(string $status): string
    {
        return match($status) {
            'pending' => 'Chờ xử lý',
            'confirmed' => 'Đã xác nhận',
            'processing' => 'Đang xử lý',
            'shipped' => 'Đang giao hàng',
            'delivered' => 'Đã giao hàng',
            'cancelled' => 'Đã hủy',
            'refunded' => 'Đã hoàn tiền',
            default => 'Không xác định'
        };
    }

/**
    * Tính toán khoảng thời gian dựa trên loại bộ lọc
    */
private function getDateRangeByType($type, $year, $month, $startDate = null, $endDate = null)
{
switch ($type) {
case 'daily':
// Lấy tháng được chọn
$start = Carbon::createFromDate($year, $month, 1)->startOfMonth();
$end = Carbon::createFromDate($year, $month, 1)->endOfMonth();
break;

case 'monthly':
// Lấy năm được chọn
$start = Carbon::createFromDate($year, 1, 1)->startOfYear();
$end = Carbon::createFromDate($year, 12, 31)->endOfYear();
break;

case 'yearly':
// Lấy 5 năm gần nhất
$start = Carbon::createFromDate($year - 4, 1, 1)->startOfYear();
$end = Carbon::createFromDate($year, 12, 31)->endOfYear();
break;

case 'date_range':
if ($startDate && $endDate) {
$start = Carbon::parse($startDate)->startOfDay();
$end = Carbon::parse($endDate)->endOfDay();
} else {
// Mặc định 30 ngày gần nhất
$start = Carbon::now()->subDays(30)->startOfDay();
$end = Carbon::now()->endOfDay();
}
break;

default:
$start = Carbon::createFromDate($year, 1, 1)->startOfYear();
$end = Carbon::createFromDate($year, 12, 31)->endOfYear();
}

return ['start' => $start, 'end' => $end];
}

/**
    * Lấy dữ liệu Dashboard theo bộ lọc (AJAX)
    */
private function getFilteredDashboardData($type, $year, $month, $startDate = null, $endDate = null)
{
$dateRange = $this->getDateRangeByType($type, $year, $month, $startDate, $endDate);

// Doanh thu theo bộ lọc
$totalRevenue = Order::where('status', 'delivered')
->where('payment_status', 'paid')
->whereNotNull('delivered_at')
->whereBetween('delivered_at', [$dateRange['start'], $dateRange['end']])
->sum('total_amount');

// Số sản phẩm bán được
$totalProductsSold = DB::table('orders')
->join('order_items', 'orders.id', '=', 'order_items.order_id')
->where('orders.status', 'delivered')
->where('orders.payment_status', 'paid')
->whereNotNull('orders.delivered_at')
->whereBetween('orders.delivered_at', [$dateRange['start'], $dateRange['end']])
->sum('order_items.quantity');

// Đơn hàng đang xử lý
$processingOrders = Order::whereIn('status', ['pending', 'processing'])
->whereBetween('created_at', [$dateRange['start'], $dateRange['end']])
->count();

// Đơn hàng đã giao thành công
$deliveredOrders = Order::where('status', 'delivered')
->whereNotNull('delivered_at')
->whereBetween('delivered_at', [$dateRange['start'], $dateRange['end']])
->count();

// Lấy dữ liệu biểu đồ
$chartData = $this->getRevenueChartData($type, $year, $month, $startDate, $endDate);

return response()->json([
'success' => true,
'totalRevenue' => $totalRevenue,
'totalProductsSold' => $totalProductsSold,
'processingOrders' => $processingOrders,
'deliveredOrders' => $deliveredOrders,
'chartData' => $chartData
]);
}
}