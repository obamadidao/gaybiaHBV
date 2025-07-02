@extends('layouts.client.ClientLayout')

@section('content')
    <!--Page Header-->
    <div class="page-header text-center">
        <div class="container">
            <div class="row">
                <div class="col-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-content-between align-items-center">
                    <div class="page-title"><h1>Đăng ký</h1></div>
                    <!--Breadcrumbs-->
                    <div class="breadcrumbs"><a href="{{ route('client.index') }}" title="Back to the home page">Trang chủ</a><span class="title"><i class="icon anm anm-angle-right-l"></i>Tài khoản</span><span class="main-title fw-bold"><i class="icon anm anm-angle-right-l"></i>Đăng ký</span></div>
                    <!--End Breadcrumbs-->
                </div>
            </div>
        </div>
    </div>
    <!--End Page Header-->

    <!--Main Content-->
    <div class="container">   
        <div class="login-register pt-2">
            <div class="row">
                <div class="col-12 col-sm-12 col-md-8 offset-md-2 col-lg-6 offset-lg-3">
                    <div class="inner h-100">
                        <form method="POST" action="{{ route('client.handle-register') }}" class="customer-form">
                            @csrf
                            <h2 class="text-center fs-4 mb-3">Đăng ký tài khoản</h2>
                            <p class="text-center mb-4">Tạo tài khoản mới để mua sắm tại cửa hàng Bida của chúng tôi.</p>
                            
                            {{-- Hiển thị thông báo lỗi --}}
                            @if (session('error'))
                                <div class="alert alert-danger mb-3">
                                    {{ session('error') }}
                                </div>
                            @endif
                            
                            @if (session('success'))
                                <div class="alert alert-success mb-3">
                                    {{ session('success') }}
                                </div>
                            @endif
                            
                            <div class="form-row">
                                <div class="form-group col-12">
                                    <label for="CustomerName" class="d-none">Họ tên <span class="required">*</span></label>
                                    <input type="text" name="name" placeholder="Họ và tên" id="CustomerName" value="{{ old('name') }}" required class="@error('name') is-invalid @enderror" />
                                    @error('name')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group col-12">
                                    <label for="CustomerEmail" class="d-none">Email <span class="required">*</span></label>
                                    <input type="email" name="email" placeholder="Email" id="CustomerEmail" value="{{ old('email') }}" required class="@error('email') is-invalid @enderror" />
                                    @error('email')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group col-12">
                                    <label for="CustomerPassword" class="d-none">Mật khẩu <span class="required">*</span></label>
                                    <input type="password" name="password" placeholder="Mật khẩu (ít nhất 6 ký tự)" id="CustomerPassword" required class="@error('password') is-invalid @enderror" />
                                    @error('password')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group col-12">
                                    <label for="CustomerPasswordConfirm" class="d-none">Xác nhận mật khẩu <span class="required">*</span></label>
                                    <input type="password" name="password_confirmation" placeholder="Xác nhận mật khẩu" id="CustomerPasswordConfirm" required class="@error('password_confirmation') is-invalid @enderror" />
                                    @error('password_confirmation')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group col-12">
                                    <div class="customCheckbox">
                                        <input id="agree_terms" name="agree_terms" type="checkbox" value="1" required />
                                        <label for="agree_terms"> Tôi đồng ý với <a href="#" onclick="alert('Điều khoản sẽ được cập nhật sớm!');">Điều khoản và Điều kiện</a></label>
                                    </div>
                                </div>
                                <div class="form-group col-12 mb-0">
                                    <button type="submit" class="btn btn-primary btn-lg w-100">Đăng ký</button>
                                </div>
                            </div>

                            <div class="login-divide"><span class="login-divide-text">HOẶC</span></div>

                            <div class="login-signup-text mt-1 mb-4 fs-6 text-center text-muted">Đã có tài khoản? <a href="{{ route('client.login-user') }}" class="btn-link">Đăng nhập ngay</a></div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--End Main Content-->
@endsection