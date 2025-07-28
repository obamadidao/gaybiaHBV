@extends('layouts.client.ClientLayout')

@section('content')
<!--Page Header-->
<div class="page-header text-center">
<div class="container">
<div class="row">
<div class="col-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-content-between align-items-center">
<div class="page-title"><h1>Thanh toán</h1></div>
<!--Breadcrumbs-->
<div class="breadcrumbs">
<a href="{{ route('client.index') }}" title="Back to the home page">Trang chủ</a>
<span class="main-title"><i class="icon anm anm-angle-right-l"></i>Thanh toán</span>
</div>
<!--End Breadcrumbs-->
</div>
</div>
</div>
</div>
<!--End Page Header-->

<!--Main Content-->
<div class="container">
<div class="row justify-content-center">
<div class="col-12 col-md-12 col-lg-12">
<div class="order-success-content text-center">
<div class="row">
<!-- Success Message -->
<h1 class="text-success mb-3">Đặt hàng thành công!</h1>
<p class="lead mb-4">Cảm ơn bạn đã đặt hàng. Chúng tôi đã nhận được đơn hàng của bạn và sẽ xử lý trong thời gian sớm nhất.</p>
</div>
<div class="row">
<!-- Order Info -->
<div class="col-6">
<div class="order-info-card">
<div class="card">
<div class="card-body">
<h5 class="card-title">Thông tin đơn hàng</h5>
<div class="order-details">
<div class="detail-row">
<span class="detail-label">Mã đơn hàng:</span>
<span class="detail-value"><strong>{{ $order->order_number }}</strong></span>
</div>
<div class="detail-row">
<span class="detail-label">Ngày đặt:</span>
<span class="detail-value">{{ $order->created_at->format('d/m/Y H:i') }}</span>
</div>
<div class="detail-row">
<span class="detail-label">Tổng tiền:</span>
<span class="detail-value text-danger"><strong>{{ number_format($order->total_amount, 0, ',', '.') }}đ</strong></span>
</div>
<div class="detail-row">
<span class="detail-label">Trạng thái:</span>
<span class="detail-value">
<span class="badge bg-warning">{{ $order->status_text }}</span>
</span>
</div>
<div class="detail-row">
<span class="detail-label">Phương thức thanh toán:</span>
<span class="detail-value">
@switch($order->payment_method)
@case('cod')
<i class="fas fa-truck me-1"></i>Thanh toán khi nhận hàng
@break
@case('bank_transfer')
<i class="fas fa-university me-1"></i>Chuyển khoản ngân hàng
@break
@case('online')
<i class="fas fa-credit-card me-1"></i>Thanh toán online
@break
@endswitch
</span>
</div>
</div>
</div>
</div>
</div>
</div>
<div class="col-6">
<div class="order-info-card">
<div class="card">
<div class="card-body">
<h5 class="card-title">Địa chỉ giao hàng</h5>
<div class="order-details">
<div class="detail-row">
<span class="detail-label">Tên người nhận:</span>
<span class="detail-value"><strong>{{ $order->shipping_address['name'] }}</strong></span>
</div>
<div class="detail-row">
<span class="detail-label">Số điện thoại:</span>
<span class="detail-value">{{ $order->shipping_address['phone'] }}</span>
</div>
<div class="detail-row">
<span class="detail-label">Email:</span>
<span class="detail-value">{{ $order->shipping_address['email'] }}</span>
</div>
<div class="detail-row">
<span class="detail-label">Địa chỉ:</span>
<span class="detail-value">
{{ $order->shipping_address['full_address'] }}
</span>
</div>
<div class="detail-row">
<span class="detail-label">Ghi chú:</span>
<span class="detail-value">
{{ $order->notes ? $order->notes : 'Không có ghi chú' }}
</span>
</div>
</div>
</div>
</div>
</div>
</div>
</div>



<!-- Order Items -->
<div class="order-items-card mt-4">
<div class="card">
<div class="card-body">
<h5 class="card-title">Sản phẩm đã đặt</h5>
<div class="order-items">
<table class="table table-hover">
<thead>
<tr>
<th>Hình ảnh</th>
<th>Sản phẩm</th>
<th>Số lượng</th>
<th>Đơn giá</th>
<th class="text-end">Thành tiền</th>
</tr>
</thead>
<tbody>
@foreach($order->orderItems as $item)
@php $primaryImage = $item->product->images->where('is_primary', 1)->first() ?? $item->product->images->first() @endphp
<tr>
<td width="100">
@if($item->product && $item->product->images->isNotEmpty())
<img src="{{$primaryImage->url}}" 
alt="{{ $item->product_name }}" class="rounded" width="60" height="60">
@else
<img src="{{ asset('assets/images/empty-img.gif') }}" 
alt="No Image" class="rounded" width="60" height="60">
@endif
</td>
<td>
<h6 class="mb-1">{{ $item->product_name }}</h6>

@if($item->variant_name)
<small class="text-muted">
{{ str_replace(['handle_material:', 'tip_material:'], ['', ''], $item->variant_name) }}
</small>
@endif
</td>
<td>{{ $item->quantity }}</td>
<td>{{ number_format($item->unit_price, 0, ',', '.') }}đ</td>
<td class="text-end"><strong>{{ number_format($item->total_price, 0, ',', '.') }}đ</strong></td>
</tr>
@endforeach
</tbody>
</table>
</div>
</div>
</div>
</div>

<!-- Next Steps -->
<div class="next-steps mt-4">
<div class="alert alert-info">
<h6><i class="fas fa-info-circle me-2"></i>Những việc tiếp theo:</h6>
<ul class="mb-0 text-start">
<li>Chúng tôi sẽ gọi điện xác nhận đơn hàng trong vòng 24h</li>
<li>Đơn hàng sẽ được giao trong vòng 2-5 ngày làm việc</li>
<li>Bạn có thể theo dõi đơn hàng trong mục "Đơn hàng của tôi"</li>
@if($order->payment_method == 'bank_transfer')
<li class="text-warning"><strong>Vui lòng chuyển khoản theo thông tin đã gửi qua email</strong></li>
@endif
</ul>
</div>
</div>

<!-- Action Buttons -->
<div class="action-buttons mt-4">
<div class="row">
                        <div class="col-md-6 mb-2">
                            <a href="{{ route('client.order.show', $order->id) }}" class="btn btn-success w-100">
                                <i class="fas fa-eye me-2"></i>Xem chi tiết đơn hàng
                            </a>
                        </div>
                        <div class="col-md-6 mb-2">
                        <div class="col-md-12 mb-2">
<a href="{{ route('client.index') }}" class="btn btn-outline-primary w-100">
<i class="fas fa-shopping-cart me-2"></i>Tiếp tục mua sắm
</a>
</div>
</div>
</div>

<!-- Contact Info -->
<div class="contact-info mt-4">
<p class="mb-0">
<small class="text-muted">
Có thắc mắc? Liên hệ với chúng tôi qua hotline: 
<a href="tel:0123456789" class="text-decoration-none">0123 456 789</a>
hoặc email: <a href="mailto:support@example.com" class="text-decoration-none">support@example.com</a>
</small>
</p>
</div>
</div>
</div>
</div>
</div>
<!--End Main Content-->

<style>

.order-info-card,
.shipping-info-card,
.order-items-card {
   animation: fadeInUp 0.6s ease-out;
}

@keyframes fadeInUp {
   from {
       opacity: 0;
       transform: translateY(30px);
   }
   to {
       opacity: 1;
       transform: translateY(0);
   }
}

.card {
   border: 1px solid #e9ecef;
   border-radius: 8px;
   box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}

.card-title {
   color: #333;
   font-weight: 600;
   margin-bottom: 20px;
}

.detail-row {
   display: flex;
   justify-content: space-between;
   align-items: center;
   padding: 8px 0;
   border-bottom: 1px solid #f8f9fa;
}

.detail-row:last-child {
   border-bottom: none;
}

.detail-label {
   font-weight: 500;
   color: #666;
}

.detail-value {
   text-align: right;
}

.order-item {
   margin-bottom: 15px;
}

.order-item:last-child {
   margin-bottom: 0;
}

.item-image img {
   object-fit: cover;
}

.item-details h6 {
   font-size: 14px;
   font-weight: 500;
   margin-bottom: 5px;
}

.item-price {
   font-size: 13px;
}

.item-price .total {
   color: #007bff;
   font-weight: 600;
}

.next-steps .alert {
   text-align: left;
}

.next-steps ul {
   padding-left: 20px;
}

.next-steps li {
   margin-bottom: 5px;
}

.action-buttons .btn {
   padding: 12px 20px;
   font-weight: 500;
}

.contact-info {
   border-top: 1px solid #e9ecef;
   padding-top: 20px;
}

@media (max-width: 768px) {
   .order-success-content {
       padding: 20px 0;
   }
   
   .success-icon i {
       font-size: 60px !important;
   }
   
   .detail-row {
       flex-direction: column;
       align-items: flex-start;
       text-align: left;
   }
   
   .detail-value {
       text-align: left !important;
   }
}
</style>