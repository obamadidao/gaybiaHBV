@extends('layouts.client.ClientLayout')

@section('content')
    <!--Page Header-->
    <div class="page-header text-center">
        <div class="container">
            <div class="row">
                <div class="col-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-content-between align-items-center">
                    <div class="page-title"><h1>Đăng nhập</h1></div>
                    <!--Breadcrumbs-->
                    <div class="breadcrumbs"><a href="{{ route('client.index') }}" title="Back to the home page">Trang chủ</a><span class="title"><i class="icon anm anm-angle-right-l"></i>Tài khoản</span><span class="main-title fw-bold"><i class="icon anm anm-angle-right-l"></i>Đăng nhập</span></div>
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
                        <form method="post" action="#" class="customer-form">	
                            <h2 class="text-center fs-4 mb-3">Đăng nhập</h2>
                            <p class="text-center mb-4">Nếu bạn đã có tài khoản với chúng tôi, vui lòng đăng nhập.</p>
                            <div class="form-row">
                                <div class="form-group col-12">
                                    <label for="CustomerEmail" class="d-none">Email <span class="required">*</span></label>
                                    <input type="email" name="customer[email]" placeholder="Email" id="CustomerEmail" value="" required />
                                </div>
                                <div class="form-group col-12">
                                    <label for="CustomerPassword" class="d-none">Password <span class="required">*</span></label>
                                    <input type="password" name="customer[password]" placeholder="Password" id="CustomerPassword" value="" required />                        	
                                </div>
                                <div class="form-group col-12">
                                    <div class="login-remember-forgot d-flex justify-content-between align-items-center">
                                        <div class="remember-check customCheckbox">
                                            <input id="remember" name="remember" type="checkbox" value="remember" required />
                                            <label for="remember"> Ghi nhớ tôi</label>
                                        </div>
                                        <a href="#">Quên mật khẩu?</a>
                                    </div>
                                </div>
                                <div class="form-group col-12 mb-0">
                                    <input type="submit" class="btn btn-primary btn-lg w-100" value="Đăng nhập" />
                                </div>
                            </div>

                            <div class="login-divide"><span class="login-divide-text">OR</span></div>

                            <div class="login-signup-text mt-1 mb-2 fs-6 text-center text-muted">Chưa có tài khoản? <a href="{{ route('client.register-user') }}" class="btn-link">Đăng ký ngay</a></div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--End Main Content-->
@endsection