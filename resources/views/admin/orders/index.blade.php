@extends('layouts.admin.AdminLayout')

@section('content')
<div class="container-fluid">
<!-- Filter Card -->
<div class="card shadow mb-4">
<div class="card-header py-3">
<div class="d-flex justify-content-between align-items-center mb-2">
<div>
<h1 class="h3 mb-0 text-gray-800">Quản lý đơn hàng</h1>
</div>
</div>
</div>
<div class="card-body">
<form method="GET" action="{{ route('admin.orders.index') }}" class="row g-3">
<div class="col-md-3">
<label for="search" class="form-label">Tìm kiếm</label>
<input type="text" class="form-control" id="search" name="search" 
value="{{ request('search') }}" placeholder="Số đơn hoặc tên khách hàng">
</div>
<div class="col-md-2">
<label for="status" class="form-label">Trạng thái đơn hàng</label>
<select class="form-select" id="status" name="status">
<option value="">Tất cả</option>
<option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Chờ xử lý</option>
<option value="processing" {{ request('status') == 'processing' ? 'selected' : '' }}>Đang xử lý</option>
<option value="shipped" {{ request('status') == 'shipped' ? 'selected' : '' }}>Đã gửi</option>
<option value="delivered" {{ request('status') == 'delivered' ? 'selected' : '' }}>Đã giao</option>
<option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Đã hủy</option>
</select>
</div>
<div class="col-md-2">
<label for="payment_status" class="form-label">Trạng thái thanh toán</label>
<select class="form-select" id="payment_status" name="payment_status">
<option value="">Tất cả</option>
<option value="pending" {{ request('payment_status') == 'pending' ? 'selected' : '' }}>Chờ thanh toán</option>
<option value="paid" {{ request('payment_status') == 'paid' ? 'selected' : '' }}>Đã thanh toán</option>
<option value="failed" {{ request('payment_status') == 'failed' ? 'selected' : '' }}>Thanh toán thất bại</option>
<option value="refunded" {{ request('payment_status') == 'refunded' ? 'selected' : '' }}>Đã hoàn tiền</option>
</select>
</div>
<div class="col-md-2">
<label for="date_from" class="form-label">Từ ngày</label>
<input type="date" class="form-control" id="date_from" name="date_from" value="{{ request('date_from') }}">
</div>
<div class="col-md-2">
<label for="date_to" class="form-label">Đến ngày</label>
<input type="date" class="form-control" id="date_to" name="date_to" value="{{ request('date_to') }}">
</div>
<div class="col-md-1 d-flex align-items-end">
<button type="submit" class="btn btn-outline-primary me-2">
<i class="fas fa-search"></i>
</button>
<a href="{{ route('admin.orders.index') }}" class="btn btn-outline-secondary">
<i class="fas fa-undo"></i>
</a>
</div>
</form>
</div>
</div>

<!-- Alert Messages -->
@if(session('success'))
<div class="alert alert-success alert-dismissible fade show" role="alert">
<i class="fas fa-check-circle me-2"></i>{{ session('success') }}
<button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
@endif

@if(session('error'))
<div class="alert alert-danger alert-dismissible fade show" role="alert">
<i class="fas fa-exclamation-triangle me-2"></i>{{ session('error') }}
<button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
@endif

<!-- Orders Table -->
<div class="card shadow mb-4">
<div class="card-header py-3 d-flex justify-content-between align-items-center">
<h6 class="m-0 font-weight-bold text-primary">
Danh sách đơn hàng ({{ $orders->total() }} đơn hàng)
</h6>
            <div class="card-tools">
            <div class="card-tools ms-auto">
<a href="{{ route('admin.orders.export', request()->query()) }}" class="btn btn-success">
<i class="fas fa-file-excel"></i> Xuất Excel
</a>
</div>
</div>
<div class="card-body p-0">
@if($orders->count() > 0)
<div class="table-responsive">
<table class="table table-hover mb-0">
<thead class="table-light">
<tr>
<th>Mã đơn hàng</th>
<th>Khách hàng</th>
<th>Tổng tiền</th>
<th>Trạng thái</th>
<th>Thanh toán</th>
<th>Ngày đặt</th>
<th class="text-center">Thao tác</th>
</tr>
</thead>
<tbody>
@foreach($orders as $order)
<tr>
<td>{{ $order->order_number }}</td>
<td>
<div class="d-flex align-items-start">
<div>
<h6 class="mb-1">{{ $order->customer->full_name ?? 'Không có tên' }}</h6>
<small class="text-muted">{{ $order->user->email ?? 'Không có email' }}<br></small>
<small class="text-muted">{{ $order->customer->phone ?? 'Không có số điện thoại' }}</small>
</div>
</div>
</td>
<td>
<strong>{{ number_format($order->total_amount) }}đ</strong>
</td>
<td>
<span class="badge {{ $order->status_badge_class }}">
{{ $order->status_text }}
</span>
</td>
<td>
<span class="badge {{ $order->payment_status === 'paid' ? 'bg-success' : 'bg-warning' }}">
{{ $order->payment_status_text }}
</span>
</td>
<td>{{ $order->created_at->format('d/m/Y H:i') }}</td>
<td class="text-center">
<div class="btn-group">
<a href="{{ route('admin.orders.show', $order) }}" 
class="btn btn-sm btn-info" title="Xem chi tiết">
<i class="fas fa-eye"></i>
</a>
<button type="button" 
class="btn btn-sm btn-primary" 
title="Chỉnh sửa"
onclick="showEditModal({{ $order->id }})">
<i class="fas fa-edit"></i>
</button>
</div>
</td>
</tr>
@endforeach
</tbody>
</table>
</div>

<!-- Pagination -->
<div class="card-footer">
{{ $orders->appends(request()->query())->links() }}
</div>
@else
<div class="text-center py-5">
<i class="fas fa-shopping-cart fa-3x text-muted mb-3"></i>
<h5 class="text-muted">Không có đơn hàng nào</h5>
<p class="text-muted">Chưa có đơn hàng nào được tạo</p>
</div>
@endif
</div>
</div>
</div>

<!-- Modal Chỉnh sửa thông tin -->
<div class="modal fade" id="editModal" tabindex="-1">
<div class="modal-dialog modal-lg">
<div class="modal-content">
<div class="modal-header">
<h5 class="modal-title">Chỉnh sửa thông tin đơn hàng</h5>
<button type="button" class="btn-close" data-bs-dismiss="modal"></button>
</div>
<form id="editForm" method="POST">
@csrf
@method('PUT')
<div class="modal-body">
<div class="row mb-3">
<div class="col-md-6">
<label class="form-label">Tên người nhận <span class="text-danger">*</span></label>
<input type="text" name="shipping_address[name]" class="form-control" required>
</div>
<div class="col-md-6">
<label class="form-label">Số điện thoại <span class="text-danger">*</span></label>
<input type="text" name="shipping_address[phone]" class="form-control" required>
</div>
</div>
<div class="mb-3">
<label class="form-label">Địa chỉ <span class="text-danger">*</span></label>
<input type="text" name="shipping_address[address]" class="form-control" required>
</div>
<div class="row mb-3">
<div class="col-md-4">
<label class="form-label">Phường/Xã <span class="text-danger">*</span></label>
<input type="text" name="shipping_address[ward]" class="form-control" required>
</div>
<div class="col-md-4">
<label class="form-label">Quận/Huyện <span class="text-danger">*</span></label>
<input type="text" name="shipping_address[district]" class="form-control" required>
</div>
<div class="col-md-4">
<label class="form-label">Tỉnh/Thành phố <span class="text-danger">*</span></label>
<input type="text" name="shipping_address[city]" class="form-control" required>
</div>
</div>
<div class="mb-3">
<label class="form-label">Ghi chú admin</label>
<textarea name="admin_notes" class="form-control" rows="3"></textarea>
</div>
</div>
<div class="modal-footer">
<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
<button type="submit" class="btn btn-primary">Lưu thay đổi</button>
</div>
</form>
</div>
</div>
</div>

@push('scripts')
<script>
function showEditModal(orderId) {
   // Lấy thông tin đơn hàng qua API
   fetch(`/admin/orders/${orderId}/edit`)
       .then(response => response.json())
       .then(data => {
           // Cập nhật form
           const form = document.getElementById('editForm');
           form.action = `/admin/orders/${orderId}`;
           
           // Điền thông tin vào form
           form.querySelector('[name="shipping_address[name]"]').value = data.shipping_address.name;
           form.querySelector('[name="shipping_address[phone]"]').value = data.shipping_address.phone;
           form.querySelector('[name="shipping_address[address]"]').value = data.shipping_address.address;
           form.querySelector('[name="shipping_address[ward]"]').value = data.shipping_address.ward;
           form.querySelector('[name="shipping_address[district]"]').value = data.shipping_address.district;
           form.querySelector('[name="shipping_address[city]"]').value = data.shipping_address.city;
           form.querySelector('[name="admin_notes"]').value = data.admin_notes;

           // Hiển thị modal
           new bootstrap.Modal(document.getElementById('editModal')).show();
       })
       .catch(error => {
           console.error('Error:', error);
           alert('Có lỗi xảy ra khi tải thông tin đơn hàng');
       });
}
</script>
@endpush
@endsection

@push('styles')
