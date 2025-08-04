@extends('layouts.client.ClientLayout')

@section('title', 'Đang xử lý thanh toán ZaloPay')

@section('content')
<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body text-center">
                    <div class="mb-4">
                        <i class="fas fa-credit-card fa-4x text-primary mb-3"></i>
                        <h4>Đang xử lý thanh toán ZaloPay</h4>
                        <p class="text-muted">Vui lòng chờ trong giây lát...</p>
                    </div>
                    
                    <div class="progress mb-3">
                        <div class="progress-bar progress-bar-striped progress-bar-animated" 
                             role="progressbar" style="width: 0%" id="progressBar">
                        </div>
                    </div>
                    
                    <div id="status-message" class="mb-3">
                        <p>Đang kiểm tra trạng thái thanh toán...</p>
                    </div>
                    
                    <div id="countdown" style="display: none;">
                        <p>Sẽ tự động chuyển hướng sau <span id="seconds">5</span> giây...</p>
                    </div>
                    
                    <button type="button" class="btn btn-outline-secondary" onclick="checkStatus()">
                        <i class="fas fa-sync-alt"></i> Kiểm tra lại
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
let orderId = {{ $order->id }};
let checkInterval;
let progressWidth = 0;
let maxChecks = 30; // Check tối đa 30 lần (5 phút)
let currentCheck = 0;

// Bắt đầu check status khi trang load
document.addEventListener('DOMContentLoaded', function() {
    startStatusCheck();
});

function startStatusCheck() {
    checkInterval = setInterval(checkStatus, 10000); // Check mỗi 10 giây
    updateProgress();
}

function updateProgress() {
    currentCheck++;
    progressWidth = (currentCheck / maxChecks) * 100;
    document.getElementById('progressBar').style.width = progressWidth + '%';
    
    if (currentCheck >= maxChecks) {
        clearInterval(checkInterval);
        document.getElementById('status-message').innerHTML = 
            '<p class="text-warning">Không thể xác nhận trạng thái thanh toán. Vui lòng liên hệ hỗ trợ.</p>';
    }
}

function checkStatus() {
    fetch(`/client/order/check-payment-status/${orderId}`, {
        method: 'GET',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'Accept': 'application/json'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            if (data.status === 'paid') {
                // Thanh toán thành công
                clearInterval(checkInterval);
                document.getElementById('status-message').innerHTML = 
                    '<p class="text-success"><i class="fas fa-check-circle"></i> Thanh toán thành công!</p>';
                startCountdown();
            } else if (data.status === 'failed') {
                // Thanh toán thất bại
                clearInterval(checkInterval);
                document.getElementById('status-message').innerHTML = 
                    '<p class="text-danger"><i class="fas fa-times-circle"></i> Thanh toán thất bại!</p>';
                setTimeout(() => {
                    window.location.href = '/client/cart';
                }, 3000);
            }
            // Nếu vẫn pending thì tiếp tục check
        }
    })
    .catch(error => {
        console.error('Error checking payment status:', error);
    });
}

function startCountdown() {
    document.getElementById('countdown').style.display = 'block';
    let seconds = 5;
    
    let countdownInterval = setInterval(() => {
        seconds--;
        document.getElementById('seconds').textContent = seconds;
        
        if (seconds <= 0) {
            clearInterval(countdownInterval);
            window.location.href = `/client/order/success/${orderId}`;
        }
    }, 1000);
}
</script>
@endsection 