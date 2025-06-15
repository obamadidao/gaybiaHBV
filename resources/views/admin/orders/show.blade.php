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
                                <p class="mb-1">
                                    {{ $order->shipping_address['ward'] ?? 'Không có phường/xã' }}, 
                                    {{ $order->shipping_address['district'] ?? 'Không có quận/huyện' }}, 
                                    {{ $order->shipping_address['city'] ?? 'Không có thành phố' }}
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

@endsection

@push('scripts')
<script>
function updateOrderStatus(status) {
    if (confirm('Bạn có chắc chắn muốn cập nhật trạng thái đơn hàng này?')) {
        document.getElementById('newStatus').value = status;
        document.getElementById('updateStatusForm').action = "{{ route('admin.orders.update-status', $order) }}";
        document.getElementById('updateStatusForm').submit();
    }
}
</script>
@endpush 