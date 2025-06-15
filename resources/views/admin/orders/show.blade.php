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
                                <li><a class="dropdown-item" href="#" onclick="updateOrderStatus('processing')">Đang xử lý</a></li>
                                <li><a class="dropdown-item" href="#" onclick="updateOrderStatus('shipped')">Đã gửi</a></li>
                                <li><a class="dropdown-item" href="#" onclick="updateOrderStatus('delivered')">Đã giao</a></li>
                                <li><a class="dropdown-item" href="#" onclick="updateOrderStatus('cancelled')">Đã hủy</a></li>
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
@@ -208,6 +215,75 @@
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
@@ -228,47 +304,183 @@
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

@endsection

@push('scripts')
<script>
function updateOrderStatus(status) {
   if (confirm('Bạn có chắc chắn muốn cập nhật trạng thái đơn hàng này?')) {
        document.getElementById('newStatus').value = status;
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
@endpush 