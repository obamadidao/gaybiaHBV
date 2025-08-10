@extends('layouts.admin.AdminLayout')

@section('content')
<div class="row">
<div class="col-md-12">
<div class="card">
<div class="card-header">
<h3 class="card-title">Tổng quan cửa hàng sản phẩm Bida ShopBida</h3>
</div>
<div class="card-body">
<div class="row">
<!-- Thống kê doanh thu -->
<div class="col-xl-3 col-md-6 mb-4">
<div class="card border-left-primary shadow h-100 py-2">
<div class="card-body">
<div class="row no-gutters align-items-center">
<div class="col mr-2">
<div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
Doanh thu (Tháng)</div>
<div class="h5 mb-0 font-weight-bold text-gray-800">{{ number_format($monthlyRevenue, 0, ',', '.') }} VNĐ</div>
<div class="text-xs {{ $revenueChange >= 0 ? 'text-success' : 'text-danger' }} mt-2">
<i class="fas fa-arrow-{{ $revenueChange >= 0 ? 'up' : 'down' }}"></i> 
{{ abs(round($revenueChange, 1)) }}% so với tháng trước
</div>
</div>
<div class="col-auto">
<i class="fas fa-calendar fa-2x text-gray-300"></i>
</div>
</div>
</div>
</div>
</div>

<!-- Thống kê doanh thu năm -->
<div class="col-xl-3 col-md-6 mb-4">
<div class="card border-left-success shadow h-100 py-2">
<div class="card-body">
<div class="row no-gutters align-items-center">
<div class="col mr-2">
<div class="text-xs font-weight-bold text-success text-uppercase mb-1">
Doanh thu (Năm)</div>
<div class="h5 mb-0 font-weight-bold text-gray-800">{{ number_format($yearlyRevenue, 0, ',', '.') }} VNĐ</div>
<div class="text-xs text-success mt-2">
<i class="fas fa-chart-line"></i> Đạt {{ round($yearTargetPercent, 1) }}% chỉ tiêu năm
</div>
</div>
<div class="col-auto">
<i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
</div>
</div>
</div>
</div>
</div>

<!-- Đơn hàng đang xử lý -->
<div class="col-xl-3 col-md-6 mb-4">
<div class="card border-left-info shadow h-100 py-2">
<div class="card-body">
<div class="row no-gutters align-items-center">
<div class="col mr-2">
<div class="text-xs font-weight-bold text-info text-uppercase mb-1">Đơn hàng đang xử lý
</div>
<div class="row no-gutters align-items-center">
<div class="col-auto">
<div class="h5 mb-0 mr-3 font-weight-bold text-gray-800">{{ $processingOrders }}</div>
</div>
<div class="col">
<div class="progress progress-sm mr-2">
<div class="progress-bar bg-info" role="progressbar" style="width: {{ $processingPercent }}%" aria-valuenow="{{ $processingPercent }}" aria-valuemin="0" aria-valuemax="100"></div>
</div>
</div>
</div>
<div class="text-xs mt-2">
<i class="fas fa-clock"></i> Cần xử lý trong 24h
</div>
</div>
<div class="col-auto">
<i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
</div>
</div>
</div>
</div>
</div>

                        <!-- Số lượng khách hàng -->
                        <!-- Số lượng đơn hàng đã giao thành công -->
<div class="col-xl-3 col-md-6 mb-4">
<div class="card border-left-warning shadow h-100 py-2">
<div class="card-body">
<div class="row no-gutters align-items-center">
<div class="col mr-2">
<div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                                Khách hàng</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalCustomers }}</div>
                                                Đơn hàng đã giao</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalDeliveredOrders }}</div>
<div class="text-xs text-success mt-2">
                                                <i class="fas fa-user-plus"></i> {{ $newCustomers }} khách hàng mới trong tháng
                                                <i class="fas fa-shipping-fast"></i> {{ $deliveredOrders }} đơn giao thành công trong tháng
</div>
</div>
<div class="col-auto">
                                            <i class="fas fa-users fa-2x text-gray-300"></i>
                                            <i class="fas fa-check-circle fa-2x text-gray-300"></i>
</div>
</div>
</div>
</div>
</div>
</div>

<!-- Biểu đồ doanh thu -->
<div class="row">
<div class="col-12">
<div class="card shadow mb-4">
<div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
<h6 class="m-0 font-weight-bold text-primary">Biểu đồ doanh thu</h6>
<div class="dropdown ms-auto">
<button class="btn btn-sm btn-primary dropdown-toggle" type="button" id="chartFilterDropdown" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
<i class="fas fa-filter fa-sm"></i> Bộ lọc
</button>
<div class="dropdown-menu dropdown-menu-right shadow animated--fade-in" aria-labelledby="chartFilterDropdown" data-bs-auto-close="outside">
<h6 class="dropdown-header">Loại biểu đồ:</h6>
<a class="dropdown-item chart-type" href="#" data-type="daily">Theo ngày</a>
<a class="dropdown-item chart-type" href="#" data-type="monthly">Theo tháng</a>
<a class="dropdown-item chart-type" href="#" data-type="yearly">Theo năm</a>
                                            <a class="dropdown-item chart-type" href="#" data-type="date_range">Theo khoảng ngày</a>
<div class="dropdown-divider"></div>
<div class="px-3 py-2">
<div class="form-group" id="yearFilter">
<label for="chartYear">Năm:</label>
<select class="form-control form-control-sm" id="chartYear">
@for ($y = date('Y'); $y >= date('Y') - 4; $y--)
<option value="{{ $y }}" {{ $y == $currentYear ? 'selected' : '' }}>{{ $y }}</option>
@endfor
</select>
</div>
<div class="form-group" id="monthFilter" style="display: none;">
<label for="chartMonth">Tháng:</label>
<select class="form-control form-control-sm" id="chartMonth">
@for ($m = 1; $m <= 12; $m++)
<option value="{{ $m }}" {{ $m == $currentMonth ? 'selected' : '' }}>{{ str_pad($m, 2, '0', STR_PAD_LEFT) }}</option>
@endfor
</select>
</div>
                                                <div class="form-group" id="dateRangeFilter" style="display: none;">
                                                    <label for="startDate">Từ ngày:</label>
                                                    <input type="date" class="form-control form-control-sm" id="startDate" value="{{ date('Y-m-d', strtotime('-30 days')) }}">
                                                    <label for="endDate" class="mt-2">Đến ngày:</label>
                                                    <input type="date" class="form-control form-control-sm" id="endDate" value="{{ date('Y-m-d') }}">
                                                </div>
<button id="applyChartFilter" class="btn btn-primary btn-sm btn-block">Áp dụng</button>
</div>
</div>
</div>
</div>
<div class="card-body">
<div class="chart-area" style="height: 400px;">
<canvas id="revenueChart"></canvas>
</div>
</div>
</div>
</div>
</div>

<!-- Bảng đơn hàng mới nhất -->
<div class="row">
<div class="col-12">
<div class="card shadow mb-4">
<div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
<h6 class="m-0 font-weight-bold text-primary">Đơn hàng mới nhất</h6>
<a href="{{ route('admin.orders.index') }}" class="btn btn-sm btn-primary shadow-sm ms-auto">
<i class="fas fa-list fa-sm text-white-50"></i> Xem tất cả
</a>
</div>
<div class="card-body">
<div class="table-responsive">
<table class="table table-bordered" width="100%" cellspacing="0">
<thead>
<tr>
<th>Mã đơn hàng</th>
<th>Khách hàng</th>
<th>Tổng tiền</th>
<th>Ngày đặt</th>
<th>Trạng thái</th>
<th>Thao tác</th>
</tr>
</thead>
<tbody>
@forelse($latestOrders as $order)
<tr>
<td>{{ $order->order_number }}</td>
<td>{{ $order->user->name ?? 'Khách vãng lai' }}</td>
<td>{{ number_format($order->total_amount, 0, ',', '.') }} VNĐ</td>
<td>{{ $order->created_at->format('d/m/Y') }}</td>
<td>
@php
                                                           $badgeClass = match($order->status) {
                                                               'pending' => 'badge-warning',
                                                               'processing' => 'badge-info',
                                                               'shipped' => 'badge-primary',
                                                               'delivered' => 'badge-success',
                                                               'cancelled' => 'badge-danger',
                                                               default => 'badge-secondary'
                                                           };
                                                           $statusText = match($order->status) {
                                                               'pending' => 'Chờ xử lý',
                                                               'processing' => 'Đang xử lý',
                                                               'shipped' => 'Đã gửi hàng',
                                                               'delivered' => 'Đã giao hàng',
                                                               'cancelled' => 'Đã hủy',
                                                               default => 'Không xác định'
                                                           };
                                                       @endphp
<span class="badge {{ $badgeClass }}">{{ $statusText }}</span>
</td>
<td>
<a href="{{ route('admin.orders.show', $order->id) }}" class="btn btn-info btn-sm">
<i class="fas fa-eye"></i>
</a>
</td>
</tr>
@empty
<tr>
<td colspan="6" class="text-center">Không có đơn hàng nào</td>
</tr>
@endforelse
</tbody>
</table>
</div>
</div>
</div>
</div>
</div>

<!-- Thống kê danh mục sản phẩm và hàng tồn kho -->
<div class="row">
<!-- Thống kê danh mục sản phẩm -->
<div class="col-xl-6 col-lg-6">
<div class="card shadow mb-4">
<div class="card-header py-3">
<h6 class="m-0 font-weight-bold text-primary">Thống kê theo danh mục sản phẩm bida</h6>
</div>
<div class="card-body">
<div class="table-responsive">
<table class="table">
<thead>
<tr>
<th>Danh mục</th>
<th>Số lượng sản phẩm</th>
<th>Tổng doanh thu</th>
<th>Tỷ lệ</th>
</tr>
</thead>
<tbody>
@foreach($categoryStats as $category)
@php
                                                   $revenue = $categoryRevenue[$category->id] ?? 0;
                                                   $percentage = $totalCategoryRevenue > 0 ? ($revenue / $totalCategoryRevenue) * 100 : 0;
                                                   
                                                   // Màu sắc cho progress bar
                                                   $colors = ['bg-success', 'bg-info', 'bg-primary', 'bg-warning', 'bg-danger'];
                                                   $colorIndex = $loop->index % count($colors);
                                               @endphp
<tr>
<td>{{ $category->name }}</td>
<td>{{ $category->products_count }}</td>
<td>{{ number_format($revenue, 0, ',', '.') }} VNĐ</td>
<td>
<div class="progress">
<div class="progress-bar {{ $colors[$colorIndex] }}" role="progressbar" style="width: {{ $percentage }}%"></div>
</div>
</td>
</tr>
@endforeach
</tbody>
</table>
</div>
</div>
</div>
</div>

<!-- Thống kê hàng tồn kho -->
<div class="col-xl-6 col-lg-6">
<div class="card shadow mb-4">
<div class="card-header py-3">
<h6 class="m-0 font-weight-bold text-primary">Tình trạng tồn kho sản phẩm bida</h6>
</div>
<div class="card-body">
<div class="table-responsive">
<table class="table">
<thead>
<tr>
<th>Sản phẩm bida</th>
<th>Số lượng tồn</th>
<th>Trạng thái</th>
<th>Thao tác</th>
</tr>
</thead>
<tbody>
@forelse($lowStockProducts as $product)
<tr>
<td>{{ $product->name }}</td>
<td>{{ $product->stock_quantity }}</td>
<td>
@if($product->stock_quantity <= 0)
<span class="badge badge-danger">Hết hàng</span>
@elseif($product->stock_quantity <= $product->min_stock)
<span class="badge badge-warning">Sắp hết</span>
@else
<span class="badge badge-success">Đủ hàng</span>
@endif
</td>
<td>
<a href="{{ route('admin.products.edit', $product->id) }}" class="btn btn-sm btn-info">Chi tiết</a>
</td>
</tr>
@empty
<tr>
<td colspan="4" class="text-center">Không có sản phẩm nào cần nhập thêm</td>
</tr>
@endforelse
</tbody>
</table>
</div>
</div>
</div>
</div>
</div>
</div>
</div>
</div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
   document.addEventListener('DOMContentLoaded', function() {
       // Ngăn dropdown đóng khi click vào các phần tử bên trong
       document.querySelector('.dropdown-menu').addEventListener('click', function(e) {
           if (e.target.classList.contains('chart-type') || 
               e.target.classList.contains('form-control') || 
               e.target.id === 'applyChartFilter') {
               e.stopPropagation();
           }
       });
   
       // Khởi tạo biểu đồ
       var ctx = document.getElementById('revenueChart').getContext('2d');
       var revenueChart = new Chart(ctx, {
           type: 'line',
           data: {
               labels: @json($chartData['labels']),
               datasets: [{
                   label: 'Doanh thu',
                   data: @json($chartData['datasets'][0]['data']),
                   backgroundColor: 'rgba(78, 115, 223, 0.2)',
                   borderColor: 'rgba(78, 115, 223, 1)',
                   borderWidth: 2,
                   pointBackgroundColor: 'rgba(78, 115, 223, 1)',
                   pointBorderColor: '#fff',
                   pointHoverBackgroundColor: '#fff',
                   pointHoverBorderColor: 'rgba(78, 115, 223, 1)',
                   pointRadius: 4,
                   pointHoverRadius: 6,
                   fill: true,
                   tension: 0.3
               }]
           },
           options: {
               responsive: true,
               maintainAspectRatio: false,
               layout: {
                   padding: {
                       left: 10,
                       right: 25,
                       top: 25,
                       bottom: 0
                   }
               },
               scales: {
                   x: {
                       grid: {
                           display: true,
                           drawBorder: false
                       },
                       ticks: {
                           maxTicksLimit: 12,
                           padding: 10
                       }
                   },
                   y: {
                       beginAtZero: true,
                       ticks: {
                           maxTicksLimit: 5,
                           padding: 10,
                           callback: function(value) {
                               // Hiển thị số tiền chuẩn VNĐ, không phần thập phân
                               return value.toLocaleString('vi-VN', { style: 'currency', currency: 'VND', maximumFractionDigits: 0 });
                           }
                       },
                       grid: {
                           color: "rgb(234, 236, 244)",
                           drawBorder: false,
                           borderDash: [2],
                           zeroLineBorderDash: [2]
                       }
                   }
               },
               plugins: {
                   legend: {
                       display: true,
                       position: 'top'
                   },
                   tooltipItem: {
                       backgroundColor: "rgb(255,255,255)",
                       titleColor: '#6e707e',
                       borderColor: '#dddfeb',
                       borderWidth: 1,
                       displayColors: false,
                       intersect: false,
                       mode: 'index',
                       caretPadding: 10,
                       callbacks: {
                           title: function(tooltipItems) {
                               return tooltipItems[0].label;
                           },
                           label: function(context) {
                               let value = context.parsed.y;
                               return 'Doanh thu: ' + value.toLocaleString('vi-VN', { style: 'currency', currency: 'VND' });
                           }
                       }
                   }

               }
           }
       });
   
       // Biến lưu trạng thái hiện tại
       let currentChartType = 'monthly';
       let currentYear = {{ $currentYear }};
       let currentMonth = {{ $currentMonth }};
   
       // Xử lý khi thay đổi loại biểu đồ
       document.querySelectorAll('.chart-type').forEach(function(item) {
           item.addEventListener('click', function(e) {
               e.preventDefault();
               e.stopPropagation(); // Ngăn sự kiện click lan truyền lên dropdown
               const type = this.getAttribute('data-type');
               currentChartType = type;
   
               // Hiển thị/ẩn bộ lọc tháng
               if (type === 'daily') {
                   document.getElementById('monthFilter').style.display = 'block';
                    document.getElementById('yearFilter').style.display = 'block';
                    document.getElementById('dateRangeFilter').style.display = 'none';
                } else if (type === 'date_range') {
                    document.getElementById('monthFilter').style.display = 'none';
                    document.getElementById('yearFilter').style.display = 'none';
                    document.getElementById('dateRangeFilter').style.display = 'block';
                } else if (type === 'monthly') {
                    document.getElementById('monthFilter').style.display = 'none';
                    document.getElementById('yearFilter').style.display = 'block';
                    document.getElementById('dateRangeFilter').style.display = 'none';
               } else {
                   document.getElementById('monthFilter').style.display = 'none';
                    document.getElementById('yearFilter').style.display = 'none';
                    document.getElementById('dateRangeFilter').style.display = 'none';
               }
   
               // Cập nhật tiêu đề dropdown
               document.getElementById('chartFilterDropdown').innerHTML = '<i class="fas fa-filter fa-sm"></i> ' + 
                    (type === 'daily' ? 'Theo ngày' : (type === 'monthly' ? 'Theo tháng' : 'Theo năm'));
                    (type === 'daily' ? 'Theo ngày' : (type === 'monthly' ? 'Theo tháng' : (type === 'yearly' ? 'Theo năm' : 'Theo khoảng ngày')));
           });
       });
   
       // Xử lý khi áp dụng bộ lọc
       document.getElementById('applyChartFilter').addEventListener('click', function() {
           const year = document.getElementById('chartYear').value;
           const month = document.getElementById('chartMonth').value;
            const startDate = document.getElementById('startDate').value;
            const endDate = document.getElementById('endDate').value;
   
           // Cập nhật biến trạng thái
           currentYear = year;
           currentMonth = month;
   
           // Gọi API để lấy dữ liệu mới
            fetch(`{{ route('admin.revenue-chart') }}?type=${currentChartType}&year=${currentYear}&month=${currentMonth}`)
            let url = `{{ route('admin.revenue-chart') }}?type=${currentChartType}&year=${currentYear}&month=${currentMonth}`;
            if (currentChartType === 'date_range') {
                url += `&start_date=${startDate}&end_date=${endDate}`;
            }

            fetch(url)
               .then(response => response.json())
               .then(data => {
                   // Cập nhật dữ liệu biểu đồ
                   revenueChart.data.labels = data.labels;
                   revenueChart.data.datasets[0].data = data.datasets[0].data;
                   revenueChart.update();
               })
               .catch(error => console.error('Lỗi khi lấy dữ liệu biểu đồ:', error));
       });
   });
   </script>

@endpush