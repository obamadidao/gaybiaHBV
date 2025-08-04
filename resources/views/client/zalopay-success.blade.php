@extends('layouts.client.ClientLayout')

@section('title', 'Thanh toán thành công')

@section('content')
<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card text-center">
                <div class="card-body">
                    <div class="mb-4">
                        <i class="fas fa-check-circle fa-5x text-success mb-3"></i>
                        <h3 class="text-success">Thanh toán thành công!</h3>
                        <p class="text-muted">{{ $message }}</p>
                    </div>
                    
                    @if(isset($order))
                    <div class="alert alert-success">
                        <strong>Đơn hàng #{{ $order->order_number }}</strong><br>
                        <small>Tổng tiền: {{ number_format($order->total_amount) }}₫</small>
                    </div>
                    @endif
                    
                    <div class="mb-3">
                        <div class="spinner-border spinner-border-sm text-primary me-2" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                        <span id="countdown-text">Đang chuyển hướng sau <span id="seconds">3</span> giây...</span>
                    </div>
                    
                    <div class="d-grid gap-2">
                        @if(isset($order))
                        <a href="{{ route('client.order.success', $order->id) }}" class="btn btn-success">
                            <i class="fas fa-eye"></i> Xem chi tiết đơn hàng
                        </a>
                        @endif
                        <a href="{{ route('client.index') }}" class="btn btn-outline-primary">
                            <i class="fas fa-home"></i> Về trang chủ
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Clear localStorage
    localStorage.removeItem('zalopay_order_id');
    
    // Auto redirect countdown
    let seconds = 3;
    const countdownElement = document.getElementById('seconds');
    
    const countdownInterval = setInterval(() => {
        seconds--;
        countdownElement.textContent = seconds;
        
        if (seconds <= 0) {
            clearInterval(countdownInterval);
            @if(isset($order))
                window.location.href = '{{ route("client.order.success", $order->id) }}';
            @else
                window.location.href = '{{ route("client.index") }}';
            @endif
        }
    }, 1000);
});
</script>
@endsection 