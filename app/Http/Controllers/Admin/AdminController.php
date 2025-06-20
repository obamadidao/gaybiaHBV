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
public function index()
{
        return view('admin.Dashboard');
        // Thống kê doanh thu
        $currentMonth = Carbon::now()->month;
        $currentYear = Carbon::now()->year;
        $lastMonth = Carbon::now()->subMonth();
        
        // Doanh thu tháng hiện tại
        $monthlyRevenue = Order::where('status', 'delivered')
            ->whereMonth('created_at', $currentMonth)
            ->whereYear('created_at', $currentYear)
            ->sum('total_amount');
            
        // Doanh thu tháng trước
        $lastMonthRevenue = Order::where('status', 'delivered')
            ->whereMonth('created_at', $lastMonth->month)
            ->whereYear('created_at', $lastMonth->year)
            ->sum('total_amount');
            
        // Tính phần trăm tăng/giảm
        $revenueChange = 0;
        if ($lastMonthRevenue > 0) {
            $revenueChange = (($monthlyRevenue - $lastMonthRevenue) / $lastMonthRevenue) * 100;
        }
        
        // Doanh thu năm hiện tại
        $yearlyRevenue = Order::where('status', 'delivered')
            ->whereYear('created_at', $currentYear)
            ->sum('total_amount');
            
        // Doanh thu năm so với năm trước
        $lastYearRevenue = Order::where('status', 'delivered')
            ->whereYear('created_at', $currentYear - 1)
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
        
        // Khách hàng mới trong tháng
        $newCustomers = User::whereHas('role', function($q) {
            $q->where('name', 'customer');
        })
        ->whereMonth('created_at', $currentMonth)
        ->whereYear('created_at', $currentYear)
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
            'newCustomers',
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
     * @param string $type (daily, monthly, yearly)
     * @param int $year
     * @param int|null $month
     * @return array
     */
    private function getRevenueChartData($type = 'monthly', $year = null, $month = null)
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
            case 'daily':
                // Lấy số ngày trong tháng
                $daysInMonth = Carbon::createFromDate($year, $month, 1)->daysInMonth;
                
                for ($day = 1; $day <= $daysInMonth; $day++) {
                    $date = Carbon::createFromDate($year, $month, $day);
                    $data['labels'][] = $day;
                    
                    $revenue = Order::where('status', 'delivered')
                        ->whereDate('created_at', $date)
                        ->sum('total_amount');
                        
                    $data['datasets'][0]['data'][] = $revenue;
                }
                break;
                
            case 'monthly':
                // Lấy doanh thu theo tháng trong năm
                for ($m = 1; $m <= 12; $m++) {
                    $data['labels'][] = Carbon::create($year, $m)->format('m/Y');
                    
                    $revenue = Order::where('status', 'delivered')
                        ->whereYear('created_at', $year)
                        ->whereMonth('created_at', $m)
                        ->sum('total_amount');
                        
                    $data['datasets'][0]['data'][] = $revenue;
                }
                break;
                
            case 'yearly':
                // Lấy doanh thu 5 năm gần đây
                $currentYear = Carbon::now()->year;
                $startYear = $currentYear - 4;
                
                for ($y = $startYear; $y <= $currentYear; $y++) {
                    $data['labels'][] = $y;
                    
                    $revenue = Order::where('status', 'delivered')
                        ->whereYear('created_at', $y)
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
        
        $data = $this->getRevenueChartData($type, $year, $month);
        
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
}