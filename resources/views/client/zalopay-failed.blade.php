@extends('layouts.client.ClientLayout')

@section('title', 'Thanh toán thất bại')

@section('content')
<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card text-center">
                <div class="card-body">
                    <div class="mb-4">
                        <i class="fas fa-times-circle fa-5x text-danger mb-3"></i>
                        <h3 class="text-danger">Thanh toán thất bại!</h3>
                        <p class="text-muted">{{ $message ?? 'Đã có lỗi xảy ra trong quá trình thanh toán.' }}</p>
                    </div>
                    
                    @if(isset($order))
                    <div class="alert alert-warning">
                        <strong>Đơn hàng #{{ $order->order_number }}</strong><br>
                        <small>Tổng tiền: {{ number_format($order->total_amount) }}₫</small><br>
                        <small class="text-muted">Đơn hàng vẫn được lưu, bạn có thể thanh toán lại sau.</small>
                    </div>
                    @endif
                    
                    <div class="mb-3">
                        <div class="spinner-border spinner-border-sm text-primary me-2" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                        <span id="countdown-text">Đang chuyển hướng sau <span id="seconds">5</span> giây...</span>
                    </div>
                    
                    <div class="d-grid gap-2">
                        @if(isset($order))
                        <a href="{{ route('client.order.checkout') }}" class="btn btn-primary">
                            <i class="fas fa-redo"></i> Thử thanh toán lại
                        </a>
                        @endif
                        <a href="{{ route('client.cart.index') }}" class="btn btn-warning">
                            <i class="fas fa-shopping-cart"></i> Về giỏ hàng
                        </a>
                        <a href="{{ route('client.index') }}" class="btn btn-outline-secondary">
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
    let seconds = 5;
    const countdownElement = document.getElementById('seconds');
    
    const countdownInterval = setInterval(() => {
        seconds--;
        countdownElement.textContent = seconds;
        
        if (seconds <= 0) {
            clearInterval(countdownInterval);
            // Redirect về giỏ hàng
            window.location.href = '{{ route("client.cart.index") }}';
        }
    }, 1000);
});
</script>
@endsection 