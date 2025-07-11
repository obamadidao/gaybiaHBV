<header class="header mih-75 d-flex align-items-center header-5 header-fixed">
<div class="container-fluid">        
<div class="row">
<!--Logo-->
<div class="logo col-4 col-sm-4 col-md-4 col-lg-1 col-xxl-1 align-self-center">
<a class="logoImg" href="{{ route('client.index') }}"><img src="{{ asset('assets/images/logo-tools.png') }}" alt="Hema Multipurpose Html Template" title="Hema Multipurpose Html Template" width="149" height="39" /></a>
</div>
<!--End Logo-->
<!--Menu-->
<div class="col-1 col-sm-1 col-md-1 col-lg-6 col-xxl-6 align-self-center d-menu-col hdr-menu-left menu-position-left">
<nav class="navigation ps-lg-4 ps-xl-3" id="AccessibleNav">
<ul id="siteNav" class="site-nav medium left">
<li class="lvl1"><a href="{{ route('client.index') }}">Trang chủ</a></li>
<li class="lvl1"><a href="{{ route('client.category', 'co-bida') }}">Cơ bida</a></li>
<li class="lvl1"><a href="{{ route('client.category', 'ban-bida') }}">Bàn bida</a></li>
<li class="lvl1"><a href="{{ route('client.category', 'bi-bida') }}">Bi bida</a></li>
<li class="lvl1"><a href="{{ route('client.category', 'phu-kien-bida') }}">Phụ kiện</a></li>
<li class="lvl1"><a href="{{ route('client.category', 'den-ban-bida') }}">Đèn bàn</a></li>
<li class="lvl1"><a href="{{ route('client.contact') }}">Liên hệ</a></li>
</ul>
</nav>
</div>
<!--End Menu-->
<!--Right Icon-->
<div class="col-8 col-sm-8 col-md-8 col-lg-5 col-xxl-5 align-self-center icons-col text-right">
<!--Search-->
<div class="search-parent iconset">
<!--Search Inline-->
<div class="minisearch-inline d-none d-lg-block">
<form class="form minisearch search-inline-brd" id="header-search0" action="#" method="get">
<label class="label d-none"><span>Search</span></label>
<!--Search Field-->
<div class="d-flex searchField">
<div class="input-box d-flex fl-1">
<input type="text" class="form-control input-group-field search-input border-0" placeholder="Search here..." value="" />
<button type="submit" class="input-group-btn text-link search-submit border-0"><i class="hdr-icon icon anm anm-search-l"></i></button>
</div>
</div>
<!--End Search Field-->
</form>
</div>
<!--End Search Inline-->

<div class="site-search d-lg-none" data-bs-toggle="tooltip" data-bs-placement="top" title="Search">
<a href="#;" class="search-icon clr-none" data-bs-toggle="offcanvas" data-bs-target="#search-drawer"><i class="hdr-icon icon anm anm-search-l"></i></a>
</div>
</div>
<!--End Search-->

<!--Account-->
<div class="account-parent iconset">
<div class="account-link" title="Account">
<i class="hdr-icon icon anm anm-user-al"></i>
@auth
<span class="d-none d-md-inline ms-1">{{ Auth::user()->name }}</span>
@endauth
</div>
<div id="accountBox">
<div class="customer-links">
<ul class="m-0">
@guest
<li><a href="{{ route('client.login-user') }}"><i class="icon anm anm-sign-in-al"></i>Đăng nhập</a></li>
<li><a href="{{ route('client.register-user') }}"><i class="icon anm anm-user-al"></i>Đăng ký</a></li>
@else
<li><a href="{{ route('client.profile-user') }}"><i class="icon anm anm-user-al"></i>Tài khoản</a></li>
                                    <li><a href="{{ route('client.order.index') }}"><i class="icon anm anm-bag-l"></i>Đơn hàng</a></li>
<li><a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><i class="icon anm anm-sign-out-al"></i>Đăng xuất</a></li>
<form id="logout-form" action="{{ route('client.logout-user') }}" method="POST" class="d-none">
@csrf
</form>
@endguest
</ul>
</div>
</div>
</div>
<!--End Account-->
<!--Minicart-->
<div class="header-cart iconset" title="Cart">
<a href="{{ route('client.cart.index') }}" class="header-cart btn-minicart clr-none">
<i class="hdr-icon icon anm anm-cart-l"></i>
<span class="cart-count" data-cart-count="0" style="display: none;">0</span>
</a>
</div>
<!--End Minicart-->
<!--Mobile Toggle-->
<button type="button" class="iconset pe-0 menu-icon js-mobile-nav-toggle mobile-nav--open d-lg-none" title="Menu"><i class="hdr-icon icon anm anm-times-l"></i><i class="hdr-icon icon anm anm-bars-r"></i></button>
<!--End Mobile Toggle-->
</div>
<!--End Right Icon-->
</div>
</div>