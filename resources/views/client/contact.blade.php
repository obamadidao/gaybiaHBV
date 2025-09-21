@extends('layouts.client.ClientLayout')

@section('title', 'Liên hệ')

@section('content')
    <!--Page Header-->
    <div class="page-header text-center">
        <div class="container">
            <div class="row">
                <div class="col-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-content-between align-items-center">
                    <div class="page-title">
                        <h1>Liên hệ với chúng tôi</h1>
                    </div>
                    <!--Breadcrumbs-->
                    <div class="breadcrumbs">
                        <a href="{{ route('client.index') }}" title="Trang chủ">Trang chủ</a>
                        <span class="main-title fw-bold"><i class="icon anm anm-angle-right-l"></i>Liên hệ</span>
                    </div>
                    <!--End Breadcrumbs-->
                </div>
            </div>
        </div>
    </div>
    <!--End Page Header-->

    <!--Main Content-->
    <div class="container">
        <div class="row">
            <div class="col-12 col-sm-12 col-md-12 col-lg-8 mb-4">
                <div class="formFeilds contact-form form-vertical">
                    <form class="contact-form" id="contactForm" method="post" action="{{ route('client.contact.store') }}">
                        @csrf
                        <h3 class="mb-4">Gửi tin nhắn cho chúng tôi</h3>
                        
                        <!-- Alert Messages -->
                        <div id="alertContainer"></div>
                        
                        <div class="row">
                            <div class="col-12 col-sm-12 col-md-6 col-lg-6">
                                <div class="form-group">
                                    <label for="contactName">Họ tên <span class="required">*</span></label>
                                    <input type="text" id="contactName" name="name" class="form-control" 
                                           value="{{ old('name', Auth::user()->customerProfile->first_name ?? '') }} {{ old('name', Auth::user()->customerProfile->last_name ?? '') }}" required />
                                    <div class="invalid-feedback"></div>
                                </div>
                            </div>
                            <div class="col-12 col-sm-12 col-md-6 col-lg-6">
                                <div class="form-group">
                                    <label for="contactEmail">Email <span class="required">*</span></label>
                                    <input type="email" id="contactEmail" name="email" class="form-control" 
                                           value="{{ old('email', Auth::user()->email ?? '') }}" required />
                                    <div class="invalid-feedback"></div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-12 col-sm-12 col-md-6 col-lg-6">
                                <div class="form-group">
                                    <label for="contactPhone">Số điện thoại</label>
                                    <input type="tel" id="contactPhone" name="phone" class="form-control" 
                                           value="{{ old('phone', Auth::user()->customerProfile->phone ?? '') }}" />
                                </div>
                            </div>
                            <div class="col-12 col-sm-12 col-md-6 col-lg-6">
                                <div class="form-group">
                                    <label for="contactPriority">Mức độ ưu tiên</label>
                                    <select id="contactPriority" name="priority" class="form-control">
                                        <option value="medium" {{ old('priority') == 'medium' ? 'selected' : '' }}>Trung bình</option>
                                        <option value="low" {{ old('priority') == 'low' ? 'selected' : '' }}>Thấp</option>
                                        <option value="high" {{ old('priority') == 'high' ? 'selected' : '' }}>Cao</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-12 col-sm-12 col-md-12 col-lg-12">
                                <div class="form-group">
                                    <label for="contactSubject">Chủ đề <span class="required">*</span></label>
                                    <input type="text" id="contactSubject" name="subject" class="form-control" 
                                           value="{{ old('subject') }}" placeholder="Nhập chủ đề tin nhắn" required />
                                    <div class="invalid-feedback"></div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-12 col-sm-12 col-md-12 col-lg-12">
                                <div class="form-group">
                                    <label for="contactMessage">Nội dung tin nhắn <span class="required">*</span></label>
                                    <textarea rows="8" id="contactMessage" name="message" class="form-control" 
                                              placeholder="Nhập nội dung tin nhắn (ít nhất 10 ký tự)" required>{{ old('message') }}</textarea>
                                    <div class="invalid-feedback"></div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-12 col-sm-12 col-md-12 col-lg-12">
                                <button type="submit" id="submitBtn" class="btn btn-primary btn-lg">
                                    <span class="btn-text">
                                        <i class="icon anm anm-envelope-l me-2"></i>Gửi tin nhắn
                                    </span>
                                    <span class="btn-loading d-none">
                                        <span class="spinner-border spinner-border-sm me-2" role="status"></span>
                                        Đang gửi...
                                    </span>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <div class="col-12 col-sm-12 col-md-12 col-lg-4 mb-4">
                <div class="contact-details">
                    <h3 class="mb-4">Thông tin liên hệ</h3>
                    
                    <div class="contact-item d-flex align-items-start mb-4">
                        <div class="contact-icon me-3">
                            <i class="icon anm anm-map-marker-al fs-5 text-primary"></i>
                        </div>
                        <div class="contact-content">
                            <h5 class="mb-1">Địa chỉ</h5>
                            <p class="mb-0">123 Đường ABC, Quận XYZ<br>Thành phố Hồ Chí Minh, Việt Nam</p>
                        </div>
                    </div>

                    <div class="contact-item d-flex align-items-start mb-4">
                        <div class="contact-icon me-3">
                            <i class="icon anm anm-phone-l fs-5 text-primary"></i>
                        </div>
                        <div class="contact-content">
                            <h5 class="mb-1">Điện thoại</h5>
                            <p class="mb-0">
                                <a href="tel:+84123456789" class="text-decoration-none">+84 123 456 789</a><br>
                                <a href="tel:+84987654321" class="text-decoration-none">+84 987 654 321</a>
                            </p>
                        </div>
                    </div>

                    <div class="contact-item d-flex align-items-start mb-4">
                        <div class="contact-icon me-3">
                            <i class="icon anm anm-envelope-l fs-5 text-primary"></i>
                        </div>
                        <div class="contact-content">
                            <h5 class="mb-1">Email</h5>
                            <p class="mb-0">
                                <a href="mailto:info@shopbida.com" class="text-decoration-none">info@shopbida.com</a><br>
                                <a href="mailto:support@shopbida.com" class="text-decoration-none">support@shopbida.com</a>
                            </p>
                        </div>
                    </div>

                    <div class="contact-item d-flex align-items-start mb-4">
                        <div class="contact-icon me-3">
                            <i class="icon anm anm-clock-r fs-5 text-primary"></i>
                        </div>
                        <div class="contact-content">
                            <h5 class="mb-1">Giờ làm việc</h5>
                            <p class="mb-0">
                                Thứ 2 - Thứ 6: 8:00 - 18:00<br>
                                Thứ 7: 8:00 - 17:00<br>
                                Chủ nhật: Nghỉ
                            </p>
                        </div>
                    </div>

                    @if(Auth::check())
                    <div class="mt-4">
                        <a href="{{ route('client.contact.my-contacts') }}" class="btn btn-outline-primary btn-sm">
                            <i class="icon anm anm-list-ul me-2"></i>Xem lịch sử liên hệ
                        </a>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- FAQ Section -->
        <div class="row mt-5">
            <div class="col-12">
                <h3 class="text-center mb-4">Câu hỏi thường gặp</h3>
                <div class="accordion" id="faqAccordion">
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="faq1">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" 
                                    data-bs-target="#collapse1" aria-expanded="false" aria-controls="collapse1">
                                Làm thế nào để đặt hàng?
                            </button>
                        </h2>
                        <div id="collapse1" class="accordion-collapse collapse" aria-labelledby="faq1" 
                             data-bs-parent="#faqAccordion">
                            <div class="accordion-body">
                                Bạn có thể duyệt sản phẩm trên website, thêm vào giỏ hàng và tiến hành thanh toán. 
                                Chúng tôi hỗ trợ thanh toán COD và ZaloPay.
                            </div>
                        </div>
                    </div>
                    
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="faq2">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" 
                                    data-bs-target="#collapse2" aria-expanded="false" aria-controls="collapse2">
                                Chính sách đổi trả như thế nào?
                            </button>
                        </h2>
                        <div id="collapse2" class="accordion-collapse collapse" aria-labelledby="faq2" 
                             data-bs-parent="#faqAccordion">
                            <div class="accordion-body">
                                Chúng tôi hỗ trợ đổi trả trong vòng 7 ngày kể từ ngày nhận hàng với điều kiện 
                                sản phẩm còn nguyên vẹn, chưa sử dụng.
                            </div>
                        </div>
                    </div>
                    
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="faq3">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" 
                                    data-bs-target="#collapse3" aria-expanded="false" aria-controls="collapse3">
                                Thời gian giao hàng?
                            </button>
                        </h2>
                        <div id="collapse3" class="accordion-collapse collapse" aria-labelledby="faq3" 
                             data-bs-parent="#faqAccordion">
                            <div class="accordion-body">
                                Thời gian giao hàng từ 1-3 ngày làm việc trong nội thành và 3-7 ngày 
                                cho các tỉnh thành khác.
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--End Main Content-->
@endsection

@push('script')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const contactForm = document.getElementById('contactForm');
    const submitBtn = document.getElementById('submitBtn');
    const alertContainer = document.getElementById('alertContainer');
    
    contactForm.addEventListener('submit', function(e) {
        e.preventDefault();
        
        // Show loading state
        submitBtn.disabled = true;
        submitBtn.querySelector('.btn-text').classList.add('d-none');
        submitBtn.querySelector('.btn-loading').classList.remove('d-none');
        
        // Clear previous errors
        clearErrors();
        clearAlerts();
        
        // Prepare form data
        const formData = new FormData(contactForm);
        
        // Submit form
        fetch(contactForm.action, {
            method: 'POST',
            body: formData,
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                showAlert('success', data.message);
                contactForm.reset();
            } else {
                if (data.errors) {
                    showValidationErrors(data.errors);
                } else {
                    showAlert('danger', data.message || 'Có lỗi xảy ra khi gửi tin nhắn.');
                }
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showAlert('danger', 'Có lỗi xảy ra khi gửi tin nhắn. Vui lòng thử lại sau.');
        })
        .finally(() => {
            // Hide loading state
            submitBtn.disabled = false;
            submitBtn.querySelector('.btn-text').classList.remove('d-none');
            submitBtn.querySelector('.btn-loading').classList.add('d-none');
        });
    });
    
    function showAlert(type, message) {
        const alertHtml = `
            <div class="alert alert-${type} alert-dismissible fade show" role="alert">
                <i class="fa fa-${type === 'success' ? 'check-circle' : 'exclamation-triangle'} me-2"></i>
                ${message}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        `;
        alertContainer.innerHTML = alertHtml;
        alertContainer.scrollIntoView({ behavior: 'smooth', block: 'center' });
    }
    
    function showValidationErrors(errors) {
        let errorMessage = 'Vui lòng kiểm tra lại các trường sau:<ul>';
        Object.keys(errors).forEach(field => {
            const input = document.querySelector(`[name="${field}"]`);
            if (input) {
                input.classList.add('is-invalid');
                const feedback = input.nextElementSibling;
                if (feedback && feedback.classList.contains('invalid-feedback')) {
                    feedback.textContent = errors[field][0];
                }
            }
            errorMessage += `<li>${errors[field][0]}</li>`;
        });
        errorMessage += '</ul>';
        showAlert('danger', errorMessage);
    }
    
    function clearErrors() {
        const invalidInputs = contactForm.querySelectorAll('.is-invalid');
        invalidInputs.forEach(input => {
            input.classList.remove('is-invalid');
            const feedback = input.nextElementSibling;
            if (feedback && feedback.classList.contains('invalid-feedback')) {
                feedback.textContent = '';
            }
        });
    }
    
    function clearAlerts() {
        alertContainer.innerHTML = '';
    }
});
</script>
@endpush