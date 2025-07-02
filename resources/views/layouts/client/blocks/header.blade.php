<header class="header mih-75 d-flex align-items-center header-5 header-fixed">
    <div class="container-fluid">        
        <div class="row">
            <!--Logo-->
            <div class="logo col-4 col-sm-4 col-md-4 col-lg-1 col-xxl-1 align-self-center">
                <a class="logoImg" href="index.html"><img src="assets/images/logo-tools.png" alt="Hema Multipurpose Html Template" title="Hema Multipurpose Html Template" width="149" height="39" /></a>
            </div>
            <!--End Logo-->
            <!--Menu-->
            <div class="col-1 col-sm-1 col-md-1 col-lg-6 col-xxl-6 align-self-center d-menu-col hdr-menu-left menu-position-left">
                <nav class="navigation ps-lg-4 ps-xl-3" id="AccessibleNav">
                    <ul id="siteNav" class="site-nav medium left">
                    <li class="lvl1"><a href="{{ route('client.category', 'co-bida') }}">Cơ bida</a></li>Add commentMore actions
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
                                <div class="search-category">
                                    <select class="rgsearch-category border-0">
                                        <option value="0">All Categories</option>
                                        <option value="1">- All</option>
                                        <option value="2">- Fashion</option>
                                        <option value="3">- Shoes</option>
                                        <option value="4">- Electronic</option>
                                        <option value="5">- Jewelry</option>
                                        <option value="6">- Vegetables</option>
                                        <option value="7">- Furniture</option>
                                        <option value="8">- Accessories</option>
                                    </select>
                                </div>
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
                    <div class="search-drawer offcanvas offcanvas-top" tabindex="-1" id="search-drawer">
                        <div class="container">
                            <div class="search-header d-flex-center justify-content-between mb-3">
                                <h3 class="title m-0">What are you looking for?</h3>
                                <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                            </div>
                            <div class="search-body">
                                <form class="form minisearch" id="header-search" action="#" method="get">
                                    <!--Search Field-->
                                    <div class="d-flex searchField">
                                        <div class="search-category">
                                            <select class="rgsearch-category rounded-end-0">
                                                <option value="0">All Categories</option>
                                                <option value="1">- All</option>
                                                <option value="2">- Fashion</option>
                                                <option value="3">- Shoes</option>
                                                <option value="4">- Electronic</option>
                                                <option value="5">- Jewelry</option>
                                                <option value="6">- Vegetables</option>
                                                <option value="7">- Furniture</option>
                                                <option value="8">- Accessories</option>
                                            </select>
                                        </div>
                                        <div class="input-box d-flex fl-1">
                                            <input type="text" class="input-text border-start-0 border-end-0" placeholder="Search for products..." value="" />
                                            <button type="submit" class="action search d-flex-justify-center btn btn-primary rounded-start-0"><i class="icon anm anm-search-l"></i></button>
                                        </div>
                                    </div>
                                    <!--End Search Field-->
                                    <!--Search popular-->
                                    <div class="popular-searches d-flex-justify-center mt-3">
                                        <span class="title fw-600">Trending Now:</span>
                                        <div class="d-flex-wrap searches-items">
                                            <a class="text-link ms-2" href="#">Forks,</a>
                                            <a class="text-link ms-2" href="#">Tools,</a>
                                            <a class="text-link ms-2" href="#">Parts</a>
                                        </div>
                                    </div>
                                    <!--End Search popular-->
                                    <!--Search products-->
                                    <div class="search-products">
                                        <ul class="items g-2 g-md-3 row row-cols-lg-4 row-cols-md-3 row-cols-sm-2">
                                            <li class="item empty w-100 text-center text-muted d-none">You don't have any items in your search.</li>
                                            <li class="item">                                                       
                                                <div class="mini-list-item d-flex align-items-center w-100 clearfix">
                                                    <div class="mini-image text-center"><a class="item-link" href="product-layout1.html"><img class="blur-up lazyload" data-src="assets/images/products/tools1-120x170.jpg" src="assets/images/products/tools1-120x170.jpg" alt="image" title="product" width="120" height="170" /></a></div>
                                                    <div class="ms-3 details text-left">
                                                        <div class="product-name"><a class="item-title" href="product-layout1.html">Tool Plasterer</a></div>
                                                        <div class="product-price"><span class="old-price">$114.00</span><span class="price">$99.00</span></div>
                                                        <div class="product-review d-flex align-items-center justify-content-start">
                                                            <i class="icon anm anm-star"></i><i class="icon anm anm-star"></i><i class="icon anm anm-star"></i><i class="icon anm anm-star-o"></i><i class="icon anm anm-star-o"></i>
                                                            <span class="caption hidden ms-2">3 reviews</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </li>
                                            <li class="item">
                                                <div class="mini-list-item d-flex align-items-center w-100 clearfix">
                                                    <div class="mini-image text-center"><a class="item-link" href="product-layout1.html"><img class="blur-up lazyload" data-src="assets/images/products/tools2-120x170.jpg" src="assets/images/products/tools2-120x170.jpg" alt="image" title="product" width="120" height="170" /></a></div>
                                                    <div class="ms-3 details text-left">
                                                        <div class="product-name"><a class="item-title" href="product-layout1.html">Hammer Tool</a></div>
                                                        <div class="product-price"><span class="price">$128.00</span></div>
                                                        <div class="product-review d-flex align-items-center justify-content-start">
                                                            <i class="icon anm anm-star"></i><i class="icon anm anm-star"></i><i class="icon anm anm-star"></i><i class="icon anm anm-star"></i><i class="icon anm anm-star"></i>
                                                            <span class="caption hidden ms-2">9 reviews</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </li>
                                            <li class="item">
                                                <div class="mini-list-item d-flex align-items-center w-100 clearfix">
                                                    <div class="mini-image text-center"><a class="item-link" href="product-layout1.html"><img class="blur-up lazyload" data-src="assets/images/products/tools3-120x170.jpg" src="assets/images/products/tools3-120x170.jpg" alt="image" title="product" width="120" height="170" /></a></div>
                                                    <div class="ms-3 details text-left">
                                                        <div class="product-name"><a class="item-title" href="product-layout1.html">Planes Hand tool</a></div>
                                                        <div class="product-price"><span class="price">$99.00</span></div>
                                                        <div class="product-review d-flex align-items-center justify-content-start">
                                                            <i class="icon anm anm-star"></i><i class="icon anm anm-star"></i><i class="icon anm anm-star"></i><i class="icon anm anm-star"></i><i class="icon anm anm-star-o"></i>
                                                            <span class="caption hidden ms-2">30 reviews</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </li>
                                        </ul>
                                    </div>
                                    <!--End Search products-->
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <!--End Search-->
                <!--Setting-->
                <div class="setting-parent iconset">
                    <div class="setting-link" title="Setting"><i class="hdr-icon icon anm anm-cog-l"></i></div>
                    <div id="settingsBox">
                        <div class="currency-picker mb-2">
                            <span class="ttl">Select Currency</span>
                            <ul id="currencies" class="cnrLangList">
                                <li class="selected"><a href="#;" class="active">INR</a></li><li><a href="#;">GBP</a></li><li><a href="#;">CAD</a></li><li><a href="#;">USD</a></li><li><a href="#;">AUD</a></li><li><a href="#;">EUR</a></li><li><a href="#;">JPY</a></li>
                            </ul>
                        </div>
                        <div class="language-picker">
                            <span class="ttl">Select Language</span>
                            <ul id="language" class="cnrLangList">
                                <li><a href="#" class="active">English</a></li><li><a href="#">French</a></li><li><a href="#">German</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <!--End Setting-->
                <!--Account-->
                <div class="account-parent iconset">
                <div class="account-link" title="Account">Add commentMore actions
                        <i class="hdr-icon icon anm anm-user-al"></i>
                        @auth
                            <span class="d-none d-md-inline ms-1">{{ Auth::user()->name }}</span>
                        @endauth
                    </div>
                    <div id="accountBox">
                        <div class="customer-links">
                            <ul class="m-0">
                            @guestAdd commentMore actions
                                    <li><a href="{{ route('client.login-user') }}"><i class="icon anm anm-sign-in-al"></i>Đăng nhập</a></li>
                                    <li><a href="{{ route('client.register-user') }}"><i class="icon anm anm-user-al"></i>Đăng ký</a></li>
                                @else
                                    <li><a href="{{ route('client.profile-user') }}"><i class="icon anm anm-user-al"></i>Tài khoản</a></li>
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
                <!--Wishlist-->
                <div class="wishlist-link iconset" title="Wishlist"><a href="wishlist-style1.html"><i class="hdr-icon icon anm anm-heart-l"></i><span class="wishlist-count">5</span></a></div>
                <!--End Wishlist-->
                <!--Minicart-->
                <div class="header-cart iconset" title="Cart">
                    <a href="#;" class="header-cart btn-minicart clr-none" data-bs-toggle="offcanvas" data-bs-target="#minicart-drawer"><i class="hdr-icon icon anm anm-cart-l"></i><span class="cart-count">2</span></a>
                </div>
                <!--End Minicart-->
                <!--Mobile Toggle-->
                <button type="button" class="iconset pe-0 menu-icon js-mobile-nav-toggle mobile-nav--open d-lg-none" title="Menu"><i class="hdr-icon icon anm anm-times-l"></i><i class="hdr-icon icon anm anm-bars-r"></i></button>
                <!--End Mobile Toggle-->
            </div>
            <!--End Right Icon-->
        </div>
    </div>
</header>