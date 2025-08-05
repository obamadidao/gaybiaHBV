@extends('layouts.admin.AdminLayout')

@section('content')
    <!-- Bộ lọc Dashboard -->
    <div class="row mb-4">
        <div class="col-md-12">
            <div class="card shadow">
                <div class="card-header bg-primary text-white">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-filter mr-2"></i>Bộ lọc Dashboard
                    </h5>
                </div>
                <div class="card-body">
                    <form class="row align-items-end">
                        <div class="col-md-2">
                            <label class="form-label">Loại biểu đồ:</label>
                            <select class="form-control" id="dashboardChartType">
                                <option value="daily">Theo ngày</option>
                                <option value="monthly" selected>Theo tháng</option>
                                <option value="yearly">Theo năm</option>
                                <option value="date_range">Theo khoảng ngày</option>
                            </select>
                        </div>
                        <div class="col-md-2" id="dashboardYearFilter">
                            <label class="form-label">Năm:</label>
                            <select class="form-control" id="dashboardYear">
                                @for ($y = date('Y'); $y >= date('Y') - 4; $y--)
                                    <option value="{{ $y }}" {{ $y == $currentYear ? 'selected' : '' }}>{{ $y }}</option>
                                @endfor
                            </select>
                        </div>
                        <div class="col-md-2" id="dashboardMonthFilter" style="display: none;">
                            <label class="form-label">Tháng:</label>
                            <select class="form-control" id="dashboardMonth">
                                @for ($m = 1; $m <= 12; $m++)
                                    <option value="{{ $m }}" {{ $m == $currentMonth ? 'selected' : '' }}>{{ str_pad($m, 2, '0', STR_PAD_LEFT) }}</option>
                                @endfor
                            </select>
                        </div>
                        <div class="col-md-2" id="dashboardStartDateFilter" style="display: none;">
                            <label class="form-label">Từ ngày:</label>
                            <input type="date" class="form-control" id="dashboardStartDate" value="{{ date('Y-m-d', strtotime('-30 days')) }}">
                        </div>
                        <div class="col-md-2" id="dashboardEndDateFilter" style="display: none;">
                            <label class="form-label">Đến ngày:</label>
                            <input type="date" class="form-control" id="dashboardEndDate" value="{{ date('Y-m-d') }}">
                        </div>
                        <div class="col-md-2">
                            <button type="button" id="applyDashboardFilter" class="btn btn-primary">
                                <i class="fas fa-search mr-2"></i>Áp dụng bộ lọc
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

<div class="row">
<div class="col-md-12">
<div class="card">
<div class="card-header">
<h3 class="card-title">Tổng quan cửa hàng sản phẩm Bida ShopBida</h3>
                    <div class="card-tools">
                        <span class="badge badge-info" id="currentFilterDisplay">Theo tháng - {{ $currentYear }}</span>
                    </div>
</div>
                <div class="card-body">
                <div class="card-body" id="dashboardContent">
<div class="row">
                        <!-- Thống kê doanh thu -->
                        <!-- Doanh thu -->
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
                                                Doanh thu</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800" id="totalRevenue">{{ number_format($monthlyRevenue, 0, ',', '.') }} VNĐ</div>
                                            <div class="text-xs text-muted mt-2">
                                                <i class="fas fa-chart-line"></i> Theo bộ lọc được chọn
</div>
</div>
<div class="col-auto">
                                            <i class="fas fa-calendar fa-2x text-gray-300"></i>
                                            <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
</div>
</div>
</div>
</div>
</div>

                        <!-- Thống kê doanh thu năm -->
                        <!-- Số sản phẩm bán được -->
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
                                                Số sản phẩm bán được</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800" id="totalProductsSold">{{ $totalCustomers ?? 0 }} sản phẩm</div>
                                            <div class="text-xs text-muted mt-2">
                                                <i class="fas fa-box"></i> Theo bộ lọc được chọn
</div>
</div>
<div class="col-auto">
                                            <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                                            <i class="fas fa-shopping-cart fa-2x text-gray-300"></i>
</div>
</div>
</div>
@@ -58,20 +115,11 @@
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
                                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                                Đơn hàng đang xử lý</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800" id="processingOrdersCount">{{ $processingOrders }} đơn hàng</div>
                                            <div class="text-xs text-muted mt-2">
                                                <i class="fas fa-clock"></i> Theo bộ lọc được chọn
</div>
</div>
<div class="col-auto">
@@ -82,21 +130,21 @@
</div>
</div>

                        <!-- Số lượng đơn hàng đã giao thành công -->
                        <!-- Đơn hàng đã giao thành công -->
<div class="col-xl-3 col-md-6 mb-4">
<div class="card border-left-warning shadow h-100 py-2">
<div class="card-body">
<div class="row no-gutters align-items-center">
<div class="col mr-2">
<div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                                Đơn hàng đã giao</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalDeliveredOrders }}</div>
                                            <div class="text-xs text-success mt-2">
                                                <i class="fas fa-shipping-fast"></i> {{ $deliveredOrders }} đơn giao thành công trong tháng
                                                Đơn hàng đã giao thành công</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800" id="deliveredOrdersCount">{{ $deliveredOrders }} đơn hàng</div>
                                            <div class="text-xs text-muted mt-2">
                                                <i class="fas fa-check-circle"></i> Theo bộ lọc được chọn
</div>
</div>
<div class="col-auto">
                                            <i class="fas fa-check-circle fa-2x text-gray-300"></i>
                                            <i class="fas fa-shipping-fast fa-2x text-gray-300"></i>
</div>
</div>
</div>
@@ -108,46 +156,8 @@
<div class="row">
<div class="col-12">
<div class="card shadow mb-4">
                                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                <div class="card-header py-3">
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
@@ -332,172 +342,341 @@
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
   document.addEventListener('DOMContentLoaded', function() {
        // Ngăn dropdown đóng khi click vào các phần tử bên trong
        document.querySelector('.dropdown-menu').addEventListener('click', function(e) {
            if (e.target.classList.contains('chart-type') || 
                e.target.classList.contains('form-control') || 
                e.target.id === 'applyChartFilter') {
                e.stopPropagation();
        // Biến lưu trạng thái biểu đồ
        let revenueChart = null;
        
        // Khởi tạo Dashboard với dữ liệu mặc định
        initializeChart(@json($chartData));
        
        // Xử lý thay đổi loại bộ lọc
        document.getElementById('dashboardChartType').addEventListener('change', function() {
            const chartType = this.value;
            const monthFilter = document.getElementById('dashboardMonthFilter');
            const yearFilter = document.getElementById('dashboardYearFilter');
            const startDateFilter = document.getElementById('dashboardStartDateFilter');
            const endDateFilter = document.getElementById('dashboardEndDateFilter');
            
            // Ẩn tất cả filter trước
            monthFilter.style.display = 'none';
            yearFilter.style.display = 'none';
            startDateFilter.style.display = 'none';
            endDateFilter.style.display = 'none';
            
            // Hiển thị filter phù hợp
            switch(chartType) {
                case 'daily':
                    monthFilter.style.display = 'block';
                    yearFilter.style.display = 'block';
                    break;
                case 'monthly':
                    yearFilter.style.display = 'block';
                    break;
                case 'yearly':
                    // Không cần filter thêm
                    break;
                case 'date_range':
                    startDateFilter.style.display = 'block';
                    endDateFilter.style.display = 'block';
                    break;
           }
       });
    
        
        // Xử lý khi áp dụng bộ lọc Dashboard
        document.getElementById('applyDashboardFilter').addEventListener('click', function() {
            const chartType = document.getElementById('dashboardChartType').value;
            const year = document.getElementById('dashboardYear').value;
            const month = document.getElementById('dashboardMonth').value;
            const startDate = document.getElementById('dashboardStartDate').value;
            const endDate = document.getElementById('dashboardEndDate').value;
            
            // Hiển thị loading
            showLoading();
            
            // Tạo URL API cho dữ liệu dashboard
            let url = `{{ route('admin.dashboard') }}?type=${chartType}&year=${year}&month=${month}`;
            if (chartType === 'date_range') {
                url += `&start_date=${startDate}&end_date=${endDate}`;
            }
            
            // Gọi API để lấy dữ liệu mới
            fetch(url, {
                method: 'GET',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json',
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Cập nhật các card thống kê
                    updateStatsCards(data);
                    
                    // Cập nhật biểu đồ
                    updateChart(data.chartData);
                    
                    // Cập nhật hiển thị bộ lọc hiện tại
                    updateFilterDisplay(chartType, year, month, startDate, endDate);
                    
                    // Cập nhật bảng đơn hàng và các thông tin khác
                    updateTables(data);
                } else {
                    alert('Có lỗi xảy ra khi tải dữ liệu!');
                }
            })
            .catch(error => {
                console.error('Lỗi khi tải dữ liệu Dashboard:', error);
                alert('Có lỗi xảy ra khi tải dữ liệu!');
            })
            .finally(() => {
                hideLoading();
            });
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
        function initializeChart(chartData) {
            const canvas = document.getElementById('revenueChart');
            if (!canvas) return;
            
            // Hủy biểu đồ cũ nếu có
            if (revenueChart) {
                revenueChart.destroy();
            }
            
            const ctx = canvas.getContext('2d');
            revenueChart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: chartData.labels,
                    datasets: [{
                        label: 'Doanh thu',
                        data: chartData.datasets[0].data,
                        backgroundColor: 'rgba(78, 115, 223, 0.2)',
                        borderColor: 'rgba(78, 115, 223, 1)',
                        borderWidth: 2,
                        pointBackgroundColor: 'rgba(78, 115, 223, 1)',
                        pointBorderColor: '#fff',
                        pointHoverBackgroundColor: '#fff',
                        pointHoverBorderColor: 'rgba(78, 115, 223, 1)',
                        pointRadius: 6,
                        pointHoverRadius: 8,
                        fill: true,
                        tension: 0.3
                    }]
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
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    layout: {
                        padding: {
                            left: 10,
                            right: 25,
                            top: 50, // Tăng padding top để có chỗ cho labels
                            bottom: 0
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
                        grid: {
                            color: "rgb(234, 236, 244)",
                            drawBorder: false,
                            borderDash: [2],
                            zeroLineBorderDash: [2]
                        y: {
                            beginAtZero: true,
                            ticks: {
                                maxTicksLimit: 5,
                                padding: 10,
                                callback: function(value) {
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
                    plugins: {
                        legend: {
                            display: true,
                            position: 'top'
                        },
                        tooltip: {
                            enabled: true,
                            backgroundColor: "rgba(255,255,255,0.95)",
                            titleColor: '#6e707e',
                            bodyColor: '#6e707e',
                            borderColor: '#dddfeb',
                            borderWidth: 1,
                            displayColors: false,
                            intersect: false,
                            mode: 'index',
                            caretPadding: 10,
                            cornerRadius: 6,
                            titleFont: {
                                size: 13,
                                weight: 'bold'
                           },
                            label: function(context) {
                                let value = context.parsed.y;
                                return 'Doanh thu: ' + value.toLocaleString('vi-VN', { style: 'currency', currency: 'VND' });
                            bodyFont: {
                                size: 12
                            },
                            padding: 12,
                            callbacks: {
                                title: function(tooltipItems) {
                                    return tooltipItems[0].label;
                                },
                                label: function(context) {
                                    let value = context.parsed.y;
                                    if (value === 0) return 'Doanh thu: 0 VNĐ';
                                    return 'Doanh thu: ' + value.toLocaleString('vi-VN', { style: 'currency', currency: 'VND', maximumFractionDigits: 0 });
                                }
                           }
                       }
                    },
                    // Xử lý hover
                    onHover: (event, activeElements) => {
                        if (event.native && event.native.target) {
                            event.native.target.style.cursor = activeElements.length > 0 ? 'pointer' : 'default';
                        }
                    },
                    // Đảm bảo interaction hoạt động
                    interaction: {
                        intersect: false,
                        mode: 'index'
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
                    (type === 'daily' ? 'Theo ngày' : (type === 'monthly' ? 'Theo tháng' : (type === 'yearly' ? 'Theo năm' : 'Theo khoảng ngày')));
                },
                plugins: [{
                    id: 'datalabels',
                    afterDatasetsDraw: function(chart) {
                        const ctx = chart.ctx;
                        chart.data.datasets.forEach((dataset, datasetIndex) => {
                            const meta = chart.getDatasetMeta(datasetIndex);
                            if (!meta.hidden) {
                                meta.data.forEach((element, index) => {
                                    // Lấy giá trị dữ liệu
                                    const value = dataset.data[index];
                                    
                                    // Chỉ hiển thị nếu giá trị > 0
                                    if (value > 0) {
                                        // Định dạng số tiền
                                        const formattedValue = formatCurrency(value);
                                        
                                        // Vị trí hiển thị text
                                        const x = element.x;
                                        const y = element.y - 15; // Hiển thị phía trên điểm
                                        
                                        // Thiết lập style cho text
                                        ctx.fillStyle = '#333';
                                        ctx.font = 'bold 11px Arial';
                                        ctx.textAlign = 'center';
                                        ctx.textBaseline = 'bottom';
                                        
                                        // Tạo background cho text
                                        const textWidth = ctx.measureText(formattedValue).width;
                                        const textHeight = 16;
                                        
                                        // Vẽ background
                                        ctx.fillStyle = 'rgba(255, 255, 255, 0.9)';
                                        ctx.fillRect(x - textWidth/2 - 4, y - textHeight - 2, textWidth + 8, textHeight + 4);
                                        
                                        // Vẽ border cho background
                                        ctx.strokeStyle = 'rgba(78, 115, 223, 0.3)';
                                        ctx.lineWidth = 1;
                                        ctx.strokeRect(x - textWidth/2 - 4, y - textHeight - 2, textWidth + 8, textHeight + 4);
                                        
                                        // Vẽ text
                                        ctx.fillStyle = '#333';
                                        ctx.fillText(formattedValue, x, y);
                                    }
                                });
                            }
                        });
                    }
                }]
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
            let url = `{{ route('admin.revenue-chart') }}?type=${currentChartType}&year=${currentYear}&month=${currentMonth}`;
            if (currentChartType === 'date_range') {
                url += `&start_date=${startDate}&end_date=${endDate}`;
        }
        
        // Hàm định dạng tiền tệ
        function formatCurrency(value) {
            if (value >= 1000000000) {
                return (value / 1000000000).toFixed(1) + 'T';
            } else if (value >= 1000000) {
                return (value / 1000000).toFixed(1) + 'Tr';
            } else if (value >= 1000) {
                return (value / 1000).toFixed(0) + 'K';
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
            return value.toLocaleString('vi-VN');
        }
        
        // Cập nhật biểu đồ
        function updateChart(chartData) {
            if (revenueChart) {
                revenueChart.data.labels = chartData.labels;
                revenueChart.data.datasets[0].data = chartData.datasets[0].data;
                revenueChart.update();
            }
        }
        
        // Cập nhật các card thống kê
        function updateStatsCards(data) {
            document.getElementById('totalRevenue').textContent = new Intl.NumberFormat('vi-VN').format(data.totalRevenue) + ' VNĐ';
            document.getElementById('totalProductsSold').textContent = data.totalProductsSold + ' sản phẩm';
            document.getElementById('processingOrdersCount').textContent = data.processingOrders + ' đơn hàng';
            document.getElementById('deliveredOrdersCount').textContent = data.deliveredOrders + ' đơn hàng';
        }
        
        // Cập nhật hiển thị bộ lọc hiện tại
        function updateFilterDisplay(chartType, year, month, startDate, endDate) {
            const filterDisplayElement = document.getElementById('currentFilterDisplay');
            let displayText = '';
            
            switch(chartType) {
                case 'daily':
                    displayText = `Theo ngày - ${month}/${year}`;
                    break;
                case 'monthly':
                    displayText = `Theo tháng - ${year}`;
                    break;
                case 'yearly':
                    displayText = 'Theo năm';
                    break;
                case 'date_range':
                    displayText = `${startDate} đến ${endDate}`;
                    break;
                default:
                    displayText = `Theo tháng - ${year}`;
            }
            
            filterDisplayElement.textContent = displayText;
        }
        
        // Cập nhật bảng dữ liệu
        function updateTables(data) {
            // Có thể cập nhật bảng đơn hàng, danh mục, v.v. ở đây nếu cần
            // Hiện tại chỉ cập nhật card thống kê
        }
        
        // Hiển thị loading
        function showLoading() {
            const dashboardContent = document.getElementById('dashboardContent');
            dashboardContent.style.opacity = '0.5';
            dashboardContent.style.pointerEvents = 'none';
        }
        
        // Ẩn loading
        function hideLoading() {
            const dashboardContent = document.getElementById('dashboardContent');
            dashboardContent.style.opacity = '1';
            dashboardContent.style.pointerEvents = 'auto';
        }
   });
    </script>
</script>

@endpush