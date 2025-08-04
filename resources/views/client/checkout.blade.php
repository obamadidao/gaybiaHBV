@extends('layouts.client.ClientLayout')

@section('content')
<!--Page Header-->
<div class="page-header text-center">
    <div class="container">
        <div class="row">
            <div class="col-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-content-between align-items-center">
                <div class="page-title">
                    <h1>Thanh toán</h1>
                </div>
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
    <!--Checkout Form-->
    <div class="row checkout-form">
        <div class="col-12 col-sm-12 col-md-12 col-lg-8">
            <div class="checkout-section-left">
                <form id="checkout-form" method="POST" action="{{ route('client.order.store') }}">
                    @csrf
                    <!-- Thông tin giao hàng -->
                    <div class="checkout-box">
                        <h4 class="checkout-step-title">Thông tin giao hàng</h4>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="shipping_name">Họ và tên <span class="required">*</span></label>
                                    <input type="text" name="shipping_name" id="shipping_name"
                                        class="form-control" value="{{ old('shipping_name', $customerProfile->first_name . ' ' . $customerProfile->last_name) }}" required>
                                    <div class="invalid-feedback"></div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="shipping_phone">Số điện thoại <span class="required">*</span></label>
                                    <input type="tel" name="shipping_phone" id="shipping_phone"
                                        class="form-control" value="{{ old('shipping_phone', $customerProfile->phone) }}" required>
                                    <div class="invalid-feedback"></div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="shipping_email">Email <span class="required">*</span></label>
                                    <input type="email" name="shipping_email" id="shipping_email"
                                        class="form-control" value="{{ old('shipping_email', $user->email) }}" required>
                                    <div class="invalid-feedback"></div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="shipping_address">Địa chỉ cụ thể <span class="required">*</span></label>
                            <input type="text" name="shipping_address" id="shipping_address"
                                class="form-control" value="{{ old('shipping_address', $customerProfile->address) }}"
                                placeholder="Số nhà, tên đường" required>
                            <div class="invalid-feedback"></div>
                        </div>


                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="shipping_city">Tỉnh/Thành phố <span class="required">*</span></label>
                                    <select name="shipping_city" id="shipping_city" class="form-control" required>
                                        <option value="">Chọn tỉnh/thành phố</option>
                                        <option value="Tuyên Quang" {{ old('shipping_city', $customerProfile->city) == 'Tuyên Quang' ? 'selected' : '' }}>Tuyên Quang</option>
                                        <option value="Lào Cai" {{ old('shipping_city', $customerProfile->city) == 'Lào Cai' ? 'selected' : '' }}>Lào Cai</option>
                                        <option value="Thái Nguyên" {{ old('shipping_city', $customerProfile->city) == 'Thái Nguyên' ? 'selected' : '' }}>Thái Nguyên</option>
                                        <option value="Phú Thọ" {{ old('shipping_city', $customerProfile->city) == 'Phú Thọ' ? 'selected' : '' }}>Phú Thọ</option>
                                        <option value="Bắc Ninh" {{ old('shipping_city', $customerProfile->city) == 'Bắc Ninh' ? 'selected' : '' }}>Bắc Ninh</option>
                                        <option value="Hưng Yên" {{ old('shipping_city', $customerProfile->city) == 'Hưng Yên' ? 'selected' : '' }}>Hưng Yên</option>
                                        <option value="Thành phố Hải Phòng" {{ old('shipping_city', $customerProfile->city) == 'Thành phố Hải Phòng' ? 'selected' : '' }}>Thành phố Hải Phòng</option>
                                        <option value="Ninh Bình" {{ old('shipping_city', $customerProfile->city) == 'Ninh Bình' ? 'selected' : '' }}>Ninh Bình</option>
                                        <option value="Quảng Trị" {{ old('shipping_city', $customerProfile->city) == 'Quảng Trị' ? 'selected' : '' }}>Quảng Trị</option>
                                        <option value="Thành phố Đà Nẵng" {{ old('shipping_city', $customerProfile->city) == 'Thành phố Đà Nẵng' ? 'selected' : '' }}>Thành phố Đà Nẵng</option>
                                        <option value="Quảng Ngãi" {{ old('shipping_city', $customerProfile->city) == 'Quảng Ngãi' ? 'selected' : '' }}>Quảng Ngãi</option>
                                        <option value="Gia Lai" {{ old('shipping_city', $customerProfile->city) == 'Gia Lai' ? 'selected' : '' }}>Gia Lai</option>
                                        <option value="Khánh Hoà" {{ old('shipping_city', $customerProfile->city) == 'Khánh Hoà' ? 'selected' : '' }}>Khánh Hoà</option>
                                        <option value="Lâm Đồng" {{ old('shipping_city', $customerProfile->city) == 'Lâm Đồng' ? 'selected' : '' }}>Lâm Đồng</option>
                                        <option value="Đắk Lắk" {{ old('shipping_city', $customerProfile->city) == 'Đắk Lắk' ? 'selected' : '' }}>Đắk Lắk</option>
                                        <option value="Thành phố Hồ Chí Minh" {{ old('shipping_city', $customerProfile->city) == 'Thành phố Hồ Chí Minh' ? 'selected' : '' }}>Thành phố Hồ Chí Minh</option>
                                        <option value="Đồng Nai" {{ old('shipping_city', $customerProfile->city) == 'Đồng Nai' ? 'selected' : '' }}>Đồng Nai</option>
                                        <option value="Tây Ninh" {{ old('shipping_city', $customerProfile->city) == 'Tây Ninh' ? 'selected' : '' }}>Tây Ninh</option>
                                        <option value="Thành phố Cần Thơ" {{ old('shipping_city', $customerProfile->city) == 'Thành phố Cần Thơ' ? 'selected' : '' }}>Thành phố Cần Thơ</option>
                                        <option value="Vĩnh Long" {{ old('shipping_city', $customerProfile->city) == 'Vĩnh Long' ? 'selected' : '' }}>Vĩnh Long</option>
                                        <option value="Đồng Tháp" {{ old('shipping_city', $customerProfile->city) == 'Đồng Tháp' ? 'selected' : '' }}>Đồng Tháp</option>
                                        <option value="Cà Mau" {{ old('shipping_city', $customerProfile->city) == 'Cà Mau' ? 'selected' : '' }}>Cà Mau</option>
                                        <option value="An Giang" {{ old('shipping_city', $customerProfile->city) == 'An Giang' ? 'selected' : '' }}>An Giang</option>
                                        <option value="Thành phố Hà Nội" {{ old('shipping_city', $customerProfile->city) == 'Thành phố Hà Nội' ? 'selected' : '' }}>Thành phố Hà Nội</option>
                                        <option value="Thành phố Huế" {{ old('shipping_city', $customerProfile->city) == 'Thành phố Huế' ? 'selected' : '' }}>Thành phố Huế</option>
                                        <option value="Lai Châu" {{ old('shipping_city', $customerProfile->city) == 'Lai Châu' ? 'selected' : '' }}>Lai Châu</option>
                                        <option value="Điện Biên" {{ old('shipping_city', $customerProfile->city) == 'Điện Biên' ? 'selected' : '' }}>Điện Biên</option>
                                        <option value="Sơn La" {{ old('shipping_city', $customerProfile->city) == 'Sơn La' ? 'selected' : '' }}>Sơn La</option>
                                        <option value="Lạng Sơn" {{ old('shipping_city', $customerProfile->city) == 'Lạng Sơn' ? 'selected' : '' }}>Lạng Sơn</option>
                                        <option value="Quảng Ninh" {{ old('shipping_city', $customerProfile->city) == 'Quảng Ninh' ? 'selected' : '' }}>Quảng Ninh</option>
                                        <option value="Thanh Hoá" {{ old('shipping_city', $customerProfile->city) == 'Thanh Hoá' ? 'selected' : '' }}>Thanh Hoá</option>
                                        <option value="Nghệ An" {{ old('shipping_city', $customerProfile->city) == 'Nghệ An' ? 'selected' : '' }}>Nghệ An</option>
                                        <option value="Hà Tĩnh" {{ old('shipping_city', $customerProfile->city) == 'Hà Tĩnh' ? 'selected' : '' }}>Hà Tĩnh</option>
                                        <option value="Cao Bằng" {{ old('shipping_city', $customerProfile->city) == 'Cao Bằng' ? 'selected' : '' }}>Cao Bằng</option>
                                    </select>
                                    <div class="invalid-feedback"></div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="shipping_ward">Phường/Xã <span class="required">*</span></label>
                                    <input type="text" name="shipping_ward" id="shipping_ward"
                                        class="form-control" value="{{ old('shipping_ward', $customerProfile->ward) }}" required>
                                    <div class="invalid-feedback"></div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="shipping_address">Địa chỉ cụ thể <span class="required">*</span></label>
                            <input type="text" name="shipping_address" id="shipping_address"
                                class="form-control" value="{{ old('shipping_address', $customerProfile->address) }}"
                                placeholder="Số nhà, tên đường" required>
                            <div class="invalid-feedback"></div>
                        </div>
                    </div>

                    <!-- Ghi chú -->
                    <div class="checkout-box">
                        <h4 class="checkout-step-title">Ghi chú đơn hàng</h4>
                        <div class="form-group">
                            <textarea name="notes" id="notes" class="form-control" rows="4"
                                placeholder="Ghi chú về đơn hàng, ví dụ: thời gian hay chỉ dẫn địa điểm giao hàng chi tiết hơn.">{{ old('notes') }}</textarea>
                        </div>
                    </div>
            </div>
        </div>

        <!-- Order Summary -->
        <div class="col-12 col-sm-12 col-md-12 col-lg-4">
            <div class="checkout-right">
                <div class="your-order mb-3">
                    <h4 class="checkout-step-title">Thông tin sản phẩm</h4>
                    <!-- Cart Items -->
                    <div class="order-review">
                        @foreach($cartItems as $item)
                        @php $primaryImage = $item->product->images->where('is_primary', 1)->first() ?? $item->product->images->first() @endphp
                        <div class="order-product">
                            <div class="product-info">
                                <div class="product-image">
                                    @if($item->product->images->isNotEmpty())
                                    <img src="{{$primaryImage->url}}"
                                        alt="{{ $item->product->name }}" width="60" height="60">
                                    @else
                                    <img src="{{ asset('assets/images/empty-img.gif') }}"
                                        alt="No Image" width="60" height="60">
                                    @endif
                                </div>
                                <div class="product-details">
                                    <h6>{{ $item->product->name }}</h6>
                                    @if($item->selected_variants)
                                    <small class="text-muted">
                                        @foreach($item->selected_variants as $key => $value)
                                        {{ $value }}
                                        @if(!$loop->last)| @endif
                                        @endforeach
                                    </small>
                                    @endif
                                    <div class="product-price">
                                        <span class="quantity">{{ $item->quantity }} sản phẩm /</span>
                                        <span class="total">{{ number_format($item->total_price, 0, ',', '.') }}đ</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                <div class="your-order mb-3">
                    <h4 class="checkout-step-title">Phương thức thanh toán</h4>
                    <!-- Cart Items -->
                    <div class="order-review">
                        <div class="delivery-methods-content">
                            <div class="customRadio clearfix">
                                <input id="payment_cod" value="cod" name="payment_method" type="radio" class="radio" {{ old('payment_method', 'cod') == 'cod' ? 'checked' : '' }}>
                                <label for="payment_cod" class="mb-0">
                                    <i class="fas fa-truck me-2"></i>
                                    Thanh toán khi nhận hàng (COD)
                                </label>
                            </div>
                            <div class="customRadio clearfix mb-0">
                                <input id="payment_online" value="online" name="payment_method" type="radio" class="radio" {{ old('payment_method') == 'online' ? 'checked' : '' }}>
                                <label for="payment_online" class="mb-0">
                                    <i class="fas fa-credit-card me-2"></i>
                                    Thanh toán online (ZaloPay)
                                </label>
                            </div>
                        </div>

                        <div class="invalid-feedback d-block" id="payment-method-error"></div>
                    </div>
                </div>

                <div class="your-order">
                    <h4 class="checkout-step-title">Thông tin thanh toán</h4>
                    <!-- Order Total -->
                    <div class="order-total">
                        <div class="total-row">
                            <span class="total-title">Tạm tính</span>
                            <span class="total-amount">{{ $cartSummary['formatted']['subtotal'] }}</span>
                        </div>
                        <div class="total-row">
                            <span class="total-title">Phí vận chuyển</span>
                            <span class="total-amount">{{ $cartSummary['formatted']['shipping_fee'] }}</span>
                        </div>
                        @if($cartSummary['discount_amount'] > 0)
                        <div class="total-row discount-row">
                            <span class="total-title">Giảm giá</span>
                            <span class="total-amount text-success">-{{ $cartSummary['formatted']['discount_amount'] }}</span>
                        </div>
                        @endif
                        <div class="total-row final-total">
                            <span class="total-title"><strong>Tổng cộng</strong></span>
                            <span class="total-amount text-danger"><strong>{{ $cartSummary['formatted']['final_total'] }}</strong></span>
                        </div>
                        <div class="checkout-tearm customCheckbox">
                            <input id="terms_accepted" name="terms_accepted" type="checkbox" value="1" {{ old('terms_accepted') ? 'checked' : '' }} required />
                            <label for="terms_accepted"> Tôi đã đọc và đồng ý với <a href="#" target="_blank">điều khoản và điều kiện</a> <span class="required">*</span></label>
                            <div class="invalid-feedback d-block" id="tearm-error"></div>
                        </div>
                    </div>

                    <!-- Place Order Button -->
                    <button type="submit" form="checkout-form" class="btn btn-success btn-lg w-100 place-order-btn">
                        <i class="fas fa-lock me-2"></i>
                        <span class="button-text">Đặt hàng</span>
                        <span class="button-loading d-none">
                            <i class="fas fa-spinner fa-spin"></i> Đang xử lý...
                        </span>
                    </button>

                    <!-- Security Badge -->
                    <div class="security-badges text-center mt-3">
                        <small class="text-muted">
                            <i class="fas fa-shield-alt me-1"></i>
                            Thông tin của bạn được bảo mật 100%
                        </small>
                    </div>
                </div>
            </div>
            </form>

        </div>
    </div>
    <!--End Checkout Form-->
</div>
<!--End Main Content-->

<style>
    .checkout-form {
        margin: 30px 0;
    }

    .checkout-box {
        background: #fff;
        border: 1px solid #e9ecef;
        border-radius: 8px;
        padding: 25px;
        margin-bottom: 25px;
    }

    .checkout-step-title {
        color: #333;
        font-size: 18px;
        font-weight: 600;
        margin-bottom: 20px;
        padding-bottom: 10px;
        border-bottom: 2px solid #007bff;
    }

    .form-group {
        margin-bottom: 20px;
    }

    .form-group label {
        font-weight: 500;
        color: #333;
        margin-bottom: 8px;
    }

    .required {
        color: #dc3545;
    }

    .form-control {
        border: 1px solid #ddd;
        border-radius: 5px;
        padding: 12px;
        font-size: 14px;
    }

    .form-control:focus {
        border-color: #007bff;
        box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
    }

    .payment-methods {
        display: flex;
        flex-direction: column;
        gap: 15px;
    }

    .form-check {
        border: 1px solid #e9ecef;
        border-radius: 8px;
        padding: 15px;
        transition: all 0.3s ease;
    }

    .form-check:hover {
        border-color: #007bff;
    }

    .form-check-input:checked+.form-check-label {
        color: #007bff;
    }

    .checkout-right {
        position: sticky;
        top: 20px;
    }

    .your-order {
        background: #fff;
        border: 1px solid #e9ecef;
        border-radius: 8px;
        padding: 25px;
    }

    .your-order h4 {
        margin-bottom: 20px;
        color: #333;
        font-weight: 600;
    }

    .order-product {
        border-bottom: 1px solid #f8f9fa;
        padding: 15px 0;
    }

    .order-product:last-child {
        border-bottom: none;
    }

    .product-info {
        display: flex;
        align-items: center;
        gap: 15px;
    }

    .product-image img {
        border-radius: 5px;
        object-fit: cover;
    }

    .product-details h6 {
        margin: 0 0 5px 0;
        font-size: 14px;
        font-weight: 500;
    }

    .product-price {
        display: flex;
        align-items: center;
        gap: 10px;
        font-size: 13px;
    }

    .product-price .total {
        font-weight: 600;
        color: #007bff;
    }

    .order-total {
        border-top: 2px solid #f8f9fa;
        padding-top: 20px;
        margin-top: 20px;
    }

    .total-row {
        display: flex;
        justify-content: space-between;
        margin-bottom: 10px;
    }

    .total-row.final-total {
        border-top: 1px solid #e9ecef;
        padding-top: 15px;
        margin-top: 15px;
        font-size: 16px;
    }

    .total-row.discount-row .total-amount {
        font-weight: 600;
    }

    .place-order-btn {
        margin-top: 20px;
        padding: 15px;
        font-size: 16px;
        font-weight: 600;
        border-radius: 8px;
    }

    .security-badges {
        margin-top: 15px;
        padding-top: 15px;
        border-top: 1px solid #f8f9fa;
    }

    .invalid-feedback {
        display: block;
        width: 100%;
        margin-top: 0.25rem;
        font-size: 0.875em;
        color: #dc3545;
    }

    @media (max-width: 768px) {
        .checkout-right {
            position: static;
            margin-top: 30px;
        }

        .checkout-box {
            padding: 20px;
        }
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const form = document.getElementById('checkout-form');
        const submitBtn = document.querySelector('.place-order-btn');

        // Handle form submission
        form.addEventListener('submit', function(e) {
            e.preventDefault();

            // Show loading state
            const buttonText = submitBtn.querySelector('.button-text');
            const buttonLoading = submitBtn.querySelector('.button-loading');

            buttonText.classList.add('d-none');
            buttonLoading.classList.remove('d-none');
            submitBtn.disabled = true;

            // Clear previous errors
            clearErrors();

            // Check payment method
            const paymentMethod = document.querySelector('input[name="payment_method"]:checked')?.value;

            if (paymentMethod === 'online') {
                // Handle ZaloPay payment flow
                handleZaloPayPayment(form);
            } else {
                // Handle regular order creation (COD)
                handleRegularOrder(form);
            }
        });

        function handleRegularOrder(form) {
            const formData = new FormData(form);

            fetch(form.action, {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Show success message
                        showNotification(data.message, 'success');

                        // Redirect to success page
                        setTimeout(() => {
                            window.location.href = data.redirect_url;
                        }, 1000);
                    } else {
                        handleOrderError(data);
                    }
                })
                .catch(error => {
                    console.error('Order Error:', error);
                    showNotification('Có lỗi xảy ra khi đặt hàng!', 'error');
                    resetButtonState();
                });
        }

        function handleZaloPayPayment(form) {
            // First create the order
            const formData = new FormData(form);

            fetch(form.action, {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Order created successfully, now process ZaloPay payment
                        processZaloPayPayment(data.order_id);
                    } else {
                        handleOrderError(data);
                    }
                })
                .catch(error => {
                    console.error('Order Creation Error:', error);
                    showNotification('Có lỗi xảy ra khi tạo đơn hàng!', 'error');
                    resetButtonState();
                });
        }

        function processZaloPayPayment(orderId) {
            fetch('{{ route("client.checkout.zalopay.payment") }}', {
                    method: 'POST',
                    body: JSON.stringify({
                        order_id: orderId
                    }),
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Redirect trực tiếp đến ZaloPay trong cùng tab
                        showNotification('Đang chuyển đến trang thanh toán ZaloPay...', 'success');

                        // Lưu order ID vào localStorage để check sau khi thanh toán
                        localStorage.setItem('zalopay_order_id', orderId);

                        // Redirect đến ZaloPay
                        window.location.href = data.order_url;
                    } else {
                        showNotification(data.message || 'Có lỗi xảy ra khi xử lý thanh toán ZaloPay!', 'error');
                        resetButtonState();
                    }
                })
                .catch(error => {
                    console.error('ZaloPay Error:', error);
                    showNotification('Có lỗi xảy ra khi kết nối ZaloPay!', 'error');
                    resetButtonState();
                });
        }

        function handleOrderError(data) {
            // Show error message
            showNotification(data.message, 'error');

            // Display validation errors
            if (data.errors) {
                displayErrors(data.errors);
            }

            // Reset button state
            resetButtonState();
        }

        function resetButtonState() {
            const buttonText = submitBtn.querySelector('.button-text');
            const buttonLoading = submitBtn.querySelector('.button-loading');

            buttonText.classList.remove('d-none');
            buttonLoading.classList.add('d-none');
            submitBtn.disabled = false;
        }

        function clearErrors() {
            document.querySelectorAll('.form-control').forEach(input => {
                input.classList.remove('is-invalid');
            });
            document.querySelectorAll('.invalid-feedback').forEach(feedback => {
                feedback.textContent = '';
            });
        }

        function displayErrors(errors) {
            Object.keys(errors).forEach(field => {
                const input = document.querySelector(`[name="${field}"]`);
                if (input) {
                    input.classList.add('is-invalid');
                    const feedback = input.nextElementSibling;
                    if (feedback && feedback.classList.contains('invalid-feedback')) {
                        feedback.textContent = errors[field][0];
                    }
                }
            });
        }

        function showNotification(message, type) {
            // Create notification element
            const notification = document.createElement('div');
            notification.className = `alert alert-${type === 'success' ? 'success' : 'danger'} alert-dismissible fade show position-fixed`;
            notification.style.cssText = 'top: 20px; right: 20px; z-index: 9999; min-width: 300px;';
            notification.innerHTML = `
           ${message}
           <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
       `;

            document.body.appendChild(notification);

            // Auto remove after 5 seconds
            setTimeout(() => {
                if (notification.parentNode) {
                    notification.remove();
                }
            }, 5000);
        }
    });
</script>