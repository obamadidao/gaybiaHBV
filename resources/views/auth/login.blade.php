@extends('layouts.app')

@section('content')
<section class="fxt-template-animation fxt-template-layout18" data-bg-image="{{ asset('login_ass/img/figure/bg18-l.jpg') }}">
    <div class="fxt-content">
        <div class="fxt-header">
            <a href="login-18.html" class="fxt-logo">
                <h1 class="text-white">HBV BilliardShop</h1>
            </a>
        </div>
        <div class="fxt-form">
            <p>Đăng nhập tài khoản</p>
            <form method="POST" action="{{ route('login') }}">
                @csrf
                <div class="form-group">
                    <div class="fxt-transformY-50 fxt-transition-delay-1">
                        <input type="email" id="email" class="form-control @error('email') is-invalid @enderror" name="email" placeholder="Email" required="required">
                        @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
                <div class="form-group">
                    <div class="fxt-transformY-50 fxt-transition-delay-2">
                        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" placeholder="********" required="required">
                        @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                        <i toggle="#password" class="fa fa-fw fa-eye toggle-password field-icon"></i>
                    </div>
                </div>
                <div class="form-group">
                    <div class="fxt-transformY-50 fxt-transition-delay-3">
                        <div class="fxt-checkbox-area">
                            <div class="checkbox">
                                <input id="checkbox1" type="checkbox">
                                <label for="checkbox1">Nhớ tài khoản</label>
                            </div>
                            <a href="forgot-password-18.html" class="switcher-text">Quên mật khẩu</a>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="fxt-transformY-50 fxt-transition-delay-4">
                        <button type="submit" class="fxt-btn-fill">Đăng nhập</button>
                    </div>
                </div>
            </form>
        </div>
        {{-- <div class="fxt-style-line">
            <div class="fxt-transformY-50 fxt-transition-delay-5">
                <h3>Or Login With</h3>
            </div>
        </div>
        <ul class="fxt-socials">
            <li class="fxt-google">
                <div class="fxt-transformY-50 fxt-transition-delay-6">
                    <a href="#" title="google"><i class="fab fa-google-plus-g"></i><span>Google +</span></a>
                </div>
            </li>
            <li class="fxt-twitter">
                <div class="fxt-transformY-50 fxt-transition-delay-7">
                    <a href="#" title="twitter"><i class="fab fa-twitter"></i><span>Twitter</span></a>
                </div>
            </li>
            <li class="fxt-facebook">
                <div class="fxt-transformY-50 fxt-transition-delay-8">
                    <a href="#" title="Facebook"><i class="fab fa-facebook-f"></i><span>Facebook</span></a>
                </div>
            </li>
        </ul> --}}
        <div class="fxt-footer">
            <div class="fxt-transformY-50 fxt-transition-delay-9">
                <p>Không có tài khoản?<a href="register-18.html" class="switcher-text2 inline-text">Đăng ký</a></p>
            </div>
        </div>
    </div>
</section>
@endsection