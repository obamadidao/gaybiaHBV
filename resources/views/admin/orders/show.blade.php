@extends('layouts.admin.AdminLayout')

@section('content')
<div class="container-fluid">
<!-- Page Header -->
<div class="d-flex justify-content-between align-items-center mb-4">
<div>
<h1 class="h3 mb-0 text-gray-800">Chi tiết đơn hàng #{{ $order->order_number }}</h1>
<p class="text-muted">Đặt lúc: {{ $order->created_at->format('d/m/Y H:i') }}</p>
</div>
<div>
            <button type="button" class="btn btn-primary me-2" onclick="showEditModal()">
                <i class="fas fa-edit me-1"></i>Chỉnh sửa
            </button>
<a href="{{ route('admin.orders.index') }}" class="btn btn-outline-secondary">
<i class="fas fa-arrow-left me-2"></i>Quay lại
</a>
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

<div class="row">
<!-- Thông tin đơn hàng -->
<div class="col-md-8">
<!-- Trạng thái đơn hàng -->
<div class="card shadow mb-4">
<div class="card-header py-3">
<h6 class="m-0 font-weight-bold text-primary">Trạng thái đơn hàng</h6>
</div>
<div class="card-body">
<div class="d-flex justify-content-between align-items-center">
<div>
<span class="badge {{ $order->status_badge_class }} fs-6">
{{ $order->status_text }}
</span>
<span class="badge {{ $order->payment_status === 'paid' ? 'bg-success' : 'bg-warning' }} ms-2 fs-6">
{{ $order->payment_status_text }}
</span>
</div>
<div class="btn-group">
<button type="button" class="btn btn-outline-primary dropdown-toggle" data-bs-toggle="dropdown">
Cập nhật trạng thái
</button>
<ul class="dropdown-menu">
@if($order->status === 'pending')
<li><a class="dropdown-item" href="#" onclick="updateOrderStatus('processing')">Đang xử lý</a></li>
<li><a class="dropdown-item" href="#" onclick="showCancelModal()">Hủy đơn hàng</a></li>
@elseif($order->status === 'processing')
<li><a class="dropdown-item" href="#" onclick="updateOrderStatus('shipped')">Đã gửi</a></li>
<li><a class="dropdown-item" href="#" onclick="showCancelModal()">Hủy đơn hàng</a></li>
@elseif($order->status === 'shipped')
<li><a class="dropdown-item" href="#" onclick="updateOrderStatus('delivered')">Đã giao</a></li>
@elseif($order->status === 'delivered')
<li><a class="dropdown-item" href="#" onclick="showRefundModal()">Hoàn tiền</a></li>
@endif
</ul>
</div>
</div>
</div>
</div>

<!-- Danh sách sản phẩm -->
<div class="card shadow mb-4">
<div class="card-header py-3">
<h6 class="m-0 font-weight-bold text-primary">Sản phẩm đã đặt</h6>
</div>
<div class="card-body p-0">
<div class="table-responsive">
<table class="table table-hover mb-0">
<thead class="table-light">
<tr>
<th>Sản phẩm</th>
<th class="text-center">Số lượng</th>
<th class="text-end">Đơn giá</th>
<th class="text-end">Thành tiền</th>
</tr>
</thead>
<tbody>
@foreach($order->orderItems as $item)
<tr>
<td>
<div class="d-flex align-items-start">
@if($item->product)
<img src="{{ $item->product->primaryImage?->url }}" alt="{{ $item->product_name }}" 
class="me-3" style="width: 50px; height: 50px; object-fit: cover;">
@endif
<div>
<h6 class="mb-1">{{ $item->product_name }}</h6>
@if($item->variant_name)
<small class="text-muted">Biến thể: {{ $item->variant_name }}</small>
@endif
@if($item->product_sku)
<br><small class="text-muted">SKU: {{ $item->product_sku }}</small>
@endif
</div>
</div>
</td>
<td class="text-center">{{ $item->quantity }}</td>
<td class="text-end">{{ number_format($item->unit_price) }}đ</td>
<td class="text-end">{{ number_format($item->total_price) }}đ</td>
</tr>
@endforeach
</tbody>
<tfoot class="table-light">
<tr>
<td colspan="3" class="text-end">Tạm tính:</td>
<td class="text-end">{{ number_format($order->subtotal) }}đ</td>
</tr>
<tr>
<td colspan="3" class="text-end">Phí vận chuyển:</td>
<td class="text-end">{{ number_format($order->shipping_fee) }}đ</td>
</tr>
@if($order->discount_amount > 0)
<tr>
<td colspan="3" class="text-end">Giảm giá:</td>
<td class="text-end">-{{ number_format($order->discount_amount) }}đ</td>
</tr>
@endif
<tr>
<td colspan="3" class="text-end"><strong>Tổng cộng:</strong></td>
<td class="text-end"><strong>{{ number_format($order->total_amount) }}đ</strong></td>
</tr>
</tfoot>
</table>
</div>
</div>
</div>
</div>

<!-- Thông tin khách hàng và thanh toán -->
<div class="col-md-4">
<!-- Thông tin người đặt -->
<div class="card shadow mb-4">
<div class="card-header py-3">
<h6 class="m-0 font-weight-bold text-primary">Thông tin người đặt</h6>
</div>
<div class="card-body">
<div class="mb-3">
<div class="d-flex align-items-center mb-2">
<i class="fas fa-user me-2 text-primary"></i>
<h6 class="mb-0">{{ $order->user->name }}</h6>
</div>
<div class="d-flex align-items-center mb-2">
<i class="fas fa-envelope me-2 text-primary"></i>
<span>{{ $order->user->email }}</span>
</div>
@if($order->user->customerProfile)
<div class="d-flex align-items-center mb-2">
<i class="fas fa-phone me-2 text-primary"></i>
<span>{{ $order->user->customerProfile->phone }}</span>
</div>
@endif
</div>
</div>
</div>

<!-- Thông tin người nhận -->
<div class="card shadow mb-4">
<div class="card-header py-3">
<h6 class="m-0 font-weight-bold text-primary">Thông tin người nhận</h6>
</div>
<div class="card-body">
<div class="mb-3">
<div class="d-flex align-items-center mb-2">
<i class="fas fa-user me-2 text-primary"></i>
<h6 class="mb-0">{{ $order->shipping_address['name'] }}</h6>
</div>
<div class="d-flex align-items-center mb-2">
<i class="fas fa-phone me-2 text-primary"></i>
<span>{{ $order->shipping_address['phone'] }}</span>
</div>
<div class="d-flex align-items-start mb-2">
<i class="fas fa-map-marker-alt me-2 text-primary mt-1"></i>
<div>
                                <p class="mb-1">{{ $order->shipping_address['address'] ?? 'Không có địa chỉ' }}</p>
                                <p class="mb-1">{{ $order->shipping_address['address'] }}</p>
<p class="mb-1">
                                    {{ $order->shipping_address['ward'] ?? 'Không có phường/xã' }}, 
                                    {{ $order->shipping_address['district'] ?? 'Không có quận/huyện' }}, 
                                    {{ $order->shipping_address['city'] ?? 'Không có thành phố' }}
                                    {{ $order->shipping_address['ward'] }}, 
                                    {{ $order->shipping_address['district'] }}, 
                                    {{ $order->shipping_address['city'] }}
</p>
</div>
</div>
</div>
</div>
</div>

<!-- Thông tin thanh toán -->
<div class="card shadow mb-4">
<div class="card-header py-3">
<h6 class="m-0 font-weight-bold text-primary">Thông tin thanh toán</h6>
</div>
<div class="card-body">
<div class="mb-3">
<div class="d-flex align-items-center mb-2">
<i class="fas fa-credit-card me-2 text-primary"></i>
<span>Phương thức: {{ $order->payment_method }}</span>
</div>
<div class="d-flex align-items-center mb-2">
<i class="fas fa-info-circle me-2 text-primary"></i>
<span>Trạng thái: 
<span class="badge {{ $order->payment_status === 'paid' ? 'bg-success' : 'bg-warning' }}">
{{ $order->payment_status_text }}
</span>
</span>
</div>
</div>

@if($order->status === 'cancelled')
<hr>
<div class="mb-3">
<h6 class="mb-2"><strong>Thông tin hủy đơn hàng:</strong></h6>
<div class="d-flex align-items-center mb-2">
<i class="fas fa-calendar-times me-2 text-danger"></i>
<span>Thời gian hủy: {{ $order->cancelled_at->format('d/m/Y H:i') }}</span>
</div>
<div class="d-flex align-items-center mb-2">
<i class="fas fa-user me-2 text-danger"></i>
<span>Người hủy: {{ $order->cancelledBy->name ?? 'N/A' }}</span>
</div>
<div class="d-flex align-items-start mb-2">
<i class="fas fa-comment-alt me-2 text-danger mt-1"></i>
<div>
<p class="mb-1"><strong>Lý do hủy:</strong></p>
<p class="mb-1">{{ $order->cancellation_reason }}</p>
</div>
</div>
@if($order->cancellation_evidence)
<div class="d-flex align-items-start mb-2">
<i class="fas fa-image me-2 text-danger mt-1"></i>
<div>
<p class="mb-1"><strong>Ảnh minh chứng:</strong></p>
<img src="{{ Storage::url($order->cancellation_evidence) }}" 
alt="Ảnh minh chứng" class="img-thumbnail" style="max-width: 200px;">
</div>
</div>
@endif
</div>
@endif

@if($order->status === 'refunded')
<hr>
<div class="mb-3">
<h6 class="mb-2"><strong>Thông tin hoàn tiền:</strong></h6>
<div class="d-flex align-items-center mb-2">
<i class="fas fa-calendar-times me-2 text-warning"></i>
<span>Thời gian hoàn tiền: {{ $order->refunded_at ? $order->refunded_at->format('d/m/Y H:i') : 'N/A' }}</span>
</div>
<div class="d-flex align-items-center mb-2">
<i class="fas fa-user me-2 text-warning"></i>
<span>Người xử lý: {{ $order->refundedBy->name }}</span>
</div>
<div class="d-flex align-items-center mb-2">
<i class="fas fa-money-bill-wave me-2 text-warning"></i>
<span>Số tiền hoàn: {{ number_format($order->refund_amount) }}đ</span>
</div>
<div class="d-flex align-items-start mb-2">
<i class="fas fa-comment-alt me-2 text-warning mt-1"></i>
<div>
<p class="mb-1"><strong>Lý do hoàn tiền:</strong></p>
<p class="mb-1">{{ $order->refund_reason }}</p>
</div>
</div>
@if($order->refund_evidence)
<div class="d-flex align-items-start mb-2">
<i class="fas fa-image me-2 text-warning mt-1"></i>
<div>
<p class="mb-1"><strong>Ảnh minh chứng:</strong></p>
<img src="{{ Storage::url($order->refund_evidence) }}" 
alt="Ảnh minh chứng" class="img-thumbnail" style="max-width: 200px;">
</div>
</div>
@endif
</div>
@endif

@if($order->transactions->isNotEmpty())
<hr>
<h6 class="mb-2">Lịch sử giao dịch:</h6>
@foreach($order->transactions as $transaction)
<div class="mb-2">
<div class="d-flex align-items-center mb-1">
<i class="fas fa-exchange-alt me-2 text-primary"></i>
<strong>{{ $transaction->type_text }}:</strong>
<span class="ms-2">{{ number_format($transaction->amount) }}đ</span>
</div>
<small class="text-muted ms-4">
{{ $transaction->created_at->format('d/m/Y H:i') }} - 
{{ $transaction->status_text }}
</small>
</div>
@endforeach
@endif
</div>
</div>

<!-- Lịch sử trạng thái -->
@if($order->status_history)
<div class="card shadow mb-4">
<div class="card-header py-3">
<h6 class="m-0 font-weight-bold text-primary">Lịch sử trạng thái</h6>
</div>
<div class="card-body">
<div class="timeline">
@foreach($order->status_history_text as $history)
<div class="timeline-item">
<div class="timeline-marker"></div>
<div class="timeline-content">
<h6 class="mb-1">{{ $history['status'] }}</h6>
<p class="mb-1">{{ $history['note'] }}</p>
<small class="text-muted">
{{ \Carbon\Carbon::parse($history['timestamp'])->format('d/m/Y H:i') }}
</small>
</div>
</div>
@endforeach
</div>
</div>
</div>
@endif

<!-- Ghi chú -->
<div class="card shadow mb-4">
<div class="card-header py-3">
<h6 class="m-0 font-weight-bold text-primary">Ghi chú</h6>
</div>
<div class="card-body">
@if($order->notes)
<div class="mb-3">
<h6 class="mb-2"><strong>Ghi chú từ khách hàng:</strong></h6>
<p class="mb-0">{{ $order->notes }}</p>
</div>
@endif
@if($order->admin_notes)
<div class="mb-3">
<h6 class="mb-2"><strong>Ghi chú admin:</strong></h6>
<p class="mb-0">{{ $order->admin_notes }}</p>
</div>
@endif
</div>
</div>
</div>
</div>
</div>

<!-- Form ẩn để cập nhật trạng thái -->
<form id="updateStatusForm" method="POST" style="display: none;">
@csrf
@method('PATCH')
<input type="hidden" name="status" id="newStatus">
</form>

<!-- Modal Hủy đơn hàng -->
<div class="modal fade" id="cancelModal" tabindex="-1">
<div class="modal-dialog">
<div class="modal-content">
<div class="modal-header">
<h5 class="modal-title">Xác nhận hủy đơn hàng</h5>
<button type="button" class="btn-close" data-bs-dismiss="modal"></button>
</div>
<form action="{{ route('admin.orders.update-status', $order) }}" method="POST" enctype="multipart/form-data">
@csrf
@method('PATCH')
<input type="hidden" name="status" value="cancelled">
<div class="modal-body">
<div class="mb-3">
<label class="form-label">Lý do hủy đơn hàng <span class="text-danger">*</span></label>
<textarea name="admin_notes" class="form-control" rows="3" required></textarea>
</div>
<div class="mb-3">
<label class="form-label">Ảnh minh chứng (nếu có)</label>
<input type="file" name="evidence_image" class="form-control" accept="image/*">
</div>
</div>
<div class="modal-footer">
<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
<button type="submit" class="btn btn-danger">Xác nhận hủy</button>
</div>
</form>
</div>
</div>
</div>

<!-- Modal Hoàn tiền -->
<div class="modal fade" id="refundModal" tabindex="-1">
<div class="modal-dialog">
<div class="modal-content">
<div class="modal-header">
<h5 class="modal-title">Xác nhận hoàn tiền</h5>
<button type="button" class="btn-close" data-bs-dismiss="modal"></button>
</div>
<form action="{{ route('admin.orders.update-status', $order) }}" method="POST" enctype="multipart/form-data">
@csrf
@method('PATCH')
<input type="hidden" name="status" value="refunded">
<div class="modal-body">
<div class="mb-3">
<label class="form-label">Lý do hoàn tiền <span class="text-danger">*</span></label>
<textarea name="admin_notes" class="form-control" rows="3" required></textarea>
</div>
<div class="mb-3">
<label class="form-label">Ảnh minh chứng <span class="text-danger">*</span></label>
<input type="file" name="evidence_image" class="form-control" accept="image/*" required>
</div>
</div>
<div class="modal-footer">
<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
<button type="submit" class="btn btn-warning">Xác nhận hoàn tiền</button>
</div>
</form>
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
            <form action="{{ route('admin.orders.update', $order) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label">Tên người nhận <span class="text-danger">*</span></label>
                            <input type="text" name="shipping_address[name]" class="form-control" 
                                   value="{{ $order->shipping_address['name'] }}" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Số điện thoại <span class="text-danger">*</span></label>
                            <input type="text" name="shipping_address[phone]" class="form-control" 
                                   value="{{ $order->shipping_address['phone'] }}" required>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Địa chỉ <span class="text-danger">*</span></label>
                        <input type="text" name="shipping_address[address]" class="form-control" 
                               value="{{ $order->shipping_address['address'] }}" required>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label class="form-label">Phường/Xã <span class="text-danger">*</span></label>
                            <input type="text" name="shipping_address[ward]" class="form-control" 
                                   value="{{ $order->shipping_address['ward'] }}" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Quận/Huyện <span class="text-danger">*</span></label>
                            <input type="text" name="shipping_address[district]" class="form-control" 
                                   value="{{ $order->shipping_address['district'] }}" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Tỉnh/Thành phố <span class="text-danger">*</span></label>
                            <input type="text" name="shipping_address[city]" class="form-control" 
                                   value="{{ $order->shipping_address['city'] }}" required>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Ghi chú admin</label>
                        <textarea name="admin_notes" class="form-control" rows="3">{{ $order->admin_notes }}</textarea>
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

@endsection

@push('scripts')
<script>
function updateOrderStatus(status) {
   if (confirm('Bạn có chắc chắn muốn cập nhật trạng thái đơn hàng này?')) {
       document.getElementById('updateStatusForm').action = "{{ route('admin.orders.update-status', $order) }}";
       document.getElementById('newStatus').value = status;
       document.getElementById('updateStatusForm').submit();
   }
}

function showCancelModal() {
   new bootstrap.Modal(document.getElementById('cancelModal')).show();
}

function showRefundModal() {
   new bootstrap.Modal(document.getElementById('refundModal')).show();
}

function showEditModal() {
    new bootstrap.Modal(document.getElementById('editModal')).show();
}
</script>
@endpush

@push('styles')
<style>
.timeline {
   position: relative;
   padding: 20px 0;
}

.timeline-item {
   position: relative;
   padding-left: 40px;
   margin-bottom: 20px;
}

.timeline-marker {
   position: absolute;
   left: 0;
   top: 0;
   width: 15px;
   height: 15px;
   border-radius: 50%;
   background: #4e73df;
   border: 3px solid #fff;
   box-shadow: 0 0 0 3px #4e73df;
}

.timeline-item:before {
   content: '';
   position: absolute;
   left: 7px;
   top: 15px;
   height: calc(100% + 5px);
   width: 2px;
   background: #e3e6f0;
}

.timeline-item:last-child:before {
   display: none;
}
</style>