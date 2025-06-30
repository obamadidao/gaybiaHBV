@extends('layouts.client.ClientLayout')

@section('content')
    <div id="page-content">               
        <!--Home Slideshow-->
        <section class="slideshow slideshow-wrapper">
            <div class="home-slideshow slick-arrow-dots circle-dots">
                <div class="slide">
                    <div class="slideshow-wrap">
                        <picture>
                            <source media="(max-width:767px)" srcset="assets/images/slideshow/demo5-banner2-mbl.jpg" width="1100" height="700">
                            <img  src="assets/images/slideshow/demo5-banner2.jpg" alt="slideshow" title="" width="1920" height="700"/>
                        </picture>
                        <div class="container">
                            <div class="slideshow-content slideshow-overlay middle-center">
                                <div class="slideshow-content-in">
                                    <div class="wrap-caption animation style4">
                                        <p class="ss-small-title text-dark">We are leading hand tools manufacturer</p>
                                        <h2 class="ss-mega-title text-dark">High Performance <br>Industrial Tools</h2>
                                        <p class="ss-sub-title text-dark xs-hide">Runs faster. Costs less and never breaks.</p>
                                        <div class="ss-btnWrap">
                                            <a class="btn btn-secondary" href="shop-grid-view.html">Shop now</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="slide">
                    <div class="slideshow-wrap">
                        <picture>
                            <source media="(max-width:767px)" srcset="assets/images/slideshow/demo5-banner1-mbl.jpg" width="1100" height="700">
                            <img  src="assets/images/slideshow/demo5-banner1.jpg" alt="slideshow" title="" width="1920" height="700"/>
                        </picture>
                        <div class="container">
                            <div class="slideshow-content slideshow-overlay middle-center">
                                <div class="slideshow-content-in">
                                    <div class="wrap-caption animation style4">
                                        <p class="ss-small-title text-dark">Tools parts in the store</p>
                                        <h2 class="ss-mega-title text-dark">Professional <br>Tools</h2>
                                        <p class="ss-sub-title text-dark xs-hide">Power your tools. It is another excellent tool from Bosch</p>
                                        <div class="ss-btnWrap">
                                            <a class="btn btn-primary" href="shop-grid-view.html">Order now</a>
                                            <a class="btn btn-secondary" href="shop-grid-view.html">Explore now</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>                      
            </div>
        </section>
        <!--End Home Slideshow-->

        <!--Popular Categories-->
        <section class="section collection-slider section-clr cs_1">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-12 col-sm-12 col-md-12">
                        <div class="section-header">
                            <h2>Shop by Categories</h2>
                        </div>
                    </div>
                    <div class="col-12 col-sm-12 col-md-12">
                        <div class="collection-slider-4items gp15 arwOut5 hov-arrow dots-hide">
                            <div class="category-item zoomscal-hov">
                                <a href="shop-left-sidebar.html" class="category-link clr-none">
                                    <div class="zoom-scal zoom-scal-nopb"><img class="blur-up lazyload" data-src="assets/images/collection/demo5-collection1.jpg" src="assets/images/collection/demo5-collection1.jpg" alt="collection" title="" width="300" height="300" /></div>
                                    <div class="details mt-3 text-center">
                                        <h4 class="category-title mb-0">Agriculture Tools</h4>
                                        <p class="counts">20 Products</p>
                                    </div>
                                </a>
                            </div>
                            <div class="category-item zoomscal-hov">
                                <a href="shop-left-sidebar.html" class="category-link clr-none">
                                    <div class="zoom-scal zoom-scal-nopb"><img class="blur-up lazyload" data-src="assets/images/collection/demo5-collection2.jpg" src="assets/images/collection/demo5-collection2.jpg" alt="collection" title="" width="300" height="300" /></div>
                                    <div class="details mt-3 text-center">
                                        <h4 class="category-title mb-0">Garden Tools</h4>
                                        <p class="counts">24 Products</p>
                                    </div>
                                </a>
                            </div>
                            <div class="category-item zoomscal-hov">
                                <a href="shop-left-sidebar.html" class="category-link clr-none">
                                    <div class="zoom-scal zoom-scal-nopb"><img class="blur-up lazyload" data-src="assets/images/collection/demo5-collection3.jpg" src="assets/images/collection/demo5-collection3.jpg" alt="collection" title="" width="300" height="300" /></div>
                                    <div class="details mt-3 text-center">
                                        <h4 class="category-title mb-0">Construction Tools</h4>
                                        <p class="counts">13 Products</p>
                                    </div>
                                </a>
                            </div>
                            <div class="category-item zoomscal-hov">
                                <a href="shop-left-sidebar.html" class="category-link clr-none">
                                    <div class="zoom-scal zoom-scal-nopb"><img class="blur-up lazyload" data-src="assets/images/collection/demo5-collection4.jpg" src="assets/images/collection/demo5-collection4.jpg" alt="collection" title="" width="300" height="300" /></div>
                                    <div class="details mt-3 text-center">
                                        <h4 class="category-title mb-0">Hand Tools</h4>
                                        <p class="counts">26 Products</p>
                                    </div>
                                </a>
                            </div>
                            <div class="category-item zoomscal-hov">
                                <a href="shop-left-sidebar.html" class="category-link clr-none">
                                    <div class="zoom-scal zoom-scal-nopb"><img class="blur-up lazyload" data-src="assets/images/collection/demo5-collection5.jpg" src="assets/images/collection/demo5-collection5.jpg" alt="collection" title="" width="300" height="300" /></div>
                                    <div class="details mt-3 text-center">
                                        <h4 class="category-title mb-0">Hand Power Tool</h4>
                                        <p class="counts">18 Products</p>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!--End Popular Categories-->

        <!--Products With Tabs-->
        <section class="section product-slider tab-slider-product pb-0">
            <div class="container">
                <div class="section-header d-none">
                    <h2>Special Offers</h2>
                    <p>Browse the huge variety of our best seller</p>
                </div>

                <div class="tabs-listing">
                    <ul class="nav nav-tabs style1 justify-content-center" id="productTabs" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link head-font active" id="bestsellers-tab" data-bs-toggle="tab" data-bs-target="#bestsellers" type="button" role="tab" aria-controls="bestsellers" aria-selected="true">Hand Tools</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link head-font" id="newarrivals-tab" data-bs-toggle="tab" data-bs-target="#newarrivals" type="button" role="tab" aria-controls="newarrivals" aria-selected="false">Electronics Tools</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link head-font" id="toprated-tab" data-bs-toggle="tab" data-bs-target="#toprated" type="button" role="tab" aria-controls="toprated" aria-selected="false">Construction Tools</button>
                        </li>
                    </ul>

                    <div class="tab-content" id="productTabsContent">
                        <div class="tab-pane show active" id="bestsellers" role="tabpanel" aria-labelledby="bestsellers-tab">
                            <!--Product Grid-->
                            <div class="grid-products grid-view-items">
                                <div class="row col-row product-options row-cols-xl-4 row-cols-lg-4 row-cols-md-3 row-cols-sm-3 row-cols-2">                                   
                                    <div class="item col-item">
                                        <div class="product-box">
                                            <!-- Start Product Image -->
                                            <div class="product-image">
                                                <!-- Start Product Image -->
                                                <a href="product-layout1.html" class="product-img"><img class="blur-up lazyload" src="assets/images/products/tools1.jpg" data-src="assets/images/products/tools1.jpg" alt="Product" title="Product" width="625" height="781" /></a>
                                                <!-- End Product Image -->
                                                <!-- Product label -->
                                                <div class="product-labels"><span class="lbl on-sale">Sale</span></div>
                                                <!-- End Product label -->
                                                <!--Countdown Timer-->
                                                <div class="saleTime" data-countdown="2025/01/01"></div>
                                                <!--End Countdown Timer-->
                                                <!--Product Button-->
                                                <div class="button-set style2">
                                                    <!--Cart Button-->
                                                    <a href="#quickshop-modal" class="btn-icon addtocart quick-shop-modal" data-bs-toggle="modal" data-bs-target="#quickshop_modal">
                                                        <span class="icon-wrap d-flex-justify-center h-100 w-100" data-bs-toggle="tooltip" data-bs-placement="top" title="Quick Shop"><i class="icon anm anm-cart-l"></i><span class="text">Quick Shop</span></span>
                                                    </a>
                                                    <!--End Cart Button-->
                                                    <!--Quick View Button-->
                                                    <a href="#quickview-modal" class="btn-icon quickview quick-view-modal" data-bs-toggle="modal" data-bs-target="#quickview_modal">
                                                        <span class="icon-wrap d-flex-justify-center h-100 w-100" data-bs-toggle="tooltip" data-bs-placement="top" title="Quick View"><i class="icon anm anm-search-plus-l"></i><span class="text">Quick View</span></span>
                                                    </a>
                                                    <!--End Quick View Button-->
                                                    <!--Wishlist Button-->
                                                    <a href="wishlist-style2.html" class="btn-icon wishlist" data-bs-toggle="tooltip" data-bs-placement="top" title="Add To Wishlist"><i class="icon anm anm-heart-l"></i><span class="text">Add To Wishlist</span></a>
                                                    <!--End Wishlist Button-->
                                                    <!--Compare Button-->
                                                    <a href="compare-style2.html" class="btn-icon compare" data-bs-toggle="tooltip" data-bs-placement="top" title="Add to Compare"><i class="icon anm anm-random-r"></i><span class="text">Add to Compare</span></a>
                                                    <!--End Compare Button-->
                                                </div>
                                                <!--End Product Button-->
                                            </div>
                                            <!-- End Product Image -->
                                            <!-- Start Product Details -->
                                            <div class="product-details text-left">
                                                <!--Product Vendor-->
                                                <div class="product-vendor">Tools</div>
                                                <!--End Product Vendor-->
                                                <!-- Product Name -->
                                                <div class="product-name">
                                                    <a href="product-layout1.html">Masonry trowel Tool Plasterer</a>
                                                </div>
                                                <!-- End Product Name -->
                                                <!-- Product Price -->
                                                <div class="product-price">
                                                    <span class="price old-price">$114.00</span><span class="price">$99.00</span>
                                                </div>
                                                <!-- End Product Price -->
                                                <!-- Product Review -->
                                                <div class="product-review">
                                                    <i class="icon anm anm-star"></i><i class="icon anm anm-star"></i><i class="icon anm anm-star"></i><i class="icon anm anm-star"></i><i class="icon anm anm-star-o"></i>
                                                    <span class="caption hidden ms-1">3 Reviews</span>
                                                </div>
                                                <!-- End Product Review -->
                                            </div>
                                            <!-- End product details -->
                                        </div>
                                    </div>
                                    <div class="item col-item">
                                        <div class="product-box">
                                            <!-- Start Product Image -->
                                            <div class="product-image">
                                                <!-- Start Product Image -->
                                                <a href="product-layout1.html" class="product-img">
                                                    <!-- Image -->
                                                    <img class="primary blur-up lazyload" data-src="assets/images/products/tools2.jpg" src="assets/images/products/tools2.jpg" alt="Product" title="Product" width="625" height="781" />
                                                    <!-- End Image -->
                                                    <!-- Hover Image -->
                                                    <img class="hover blur-up lazyload" data-src="assets/images/products/tools2-1.jpg" src="assets/images/products/tools2-1.jpg" alt="Product" title="Product" width="625" height="781" />
                                                    <!-- End Hover Image -->
                                                </a>
                                                <!-- End Product Image -->
                                                <!--Product Button-->
                                                <div class="button-set style2">
                                                    <!--Cart Button-->
                                                    <a href="#quickshop-modal" class="btn-icon addtocart quick-shop-modal" data-bs-toggle="modal" data-bs-target="#quickshop_modal">
                                                        <span class="icon-wrap d-flex-justify-center h-100 w-100" data-bs-toggle="tooltip" data-bs-placement="top" title="Select Options"><i class="icon anm anm-cart-l"></i><span class="text">Select Options</span></span>
                                                    </a>
                                                    <!--End Cart Button-->
                                                    <!--Quick View Button-->
                                                    <a href="#quickview-modal" class="btn-icon quickview quick-view-modal" data-bs-toggle="modal" data-bs-target="#quickview_modal">
                                                        <span class="icon-wrap d-flex-justify-center h-100 w-100" data-bs-toggle="tooltip" data-bs-placement="top" title="Quick View"><i class="icon anm anm-search-plus-l"></i><span class="text">Quick View</span></span>
                                                    </a>
                                                    <!--End Quick View Button-->
                                                    <!--Wishlist Button-->
                                                    <a href="wishlist-style2.html" class="btn-icon wishlist" data-bs-toggle="tooltip" data-bs-placement="top" title="Add To Wishlist"><i class="icon anm anm-heart-l"></i><span class="text">Add To Wishlist</span></a>
                                                    <!--End Wishlist Button-->
                                                    <!--Compare Button-->
                                                    <a href="compare-style2.html" class="btn-icon compare" data-bs-toggle="tooltip" data-bs-placement="top" title="Add to Compare"><i class="icon anm anm-random-r"></i><span class="text">Add to Compare</span></a>
                                                    <!--End Compare Button-->
                                                </div>
                                                <!--End Product Button-->
                                            </div>
                                            <!-- End Product Image -->
                                            <!-- Start Product Details -->
                                            <div class="product-details text-left">
                                                <!--Product Vendor-->
                                                <div class="product-vendor">Bosh</div>
                                                <!--End Product Vendor-->
                                                <!-- Product Name -->
                                                <div class="product-name">
                                                    <a href="product-layout1.html">Hammer drill Electric Tool</a>
                                                </div>
                                                <!-- End Product Name -->
                                                <!-- Product Price -->
                                                <div class="product-price">
                                                    <span class="price">$128.00</span>
                                                </div>
                                                <!-- End Product Price -->
                                                <!-- Product Review -->
                                                <div class="product-review">
                                                    <i class="icon anm anm-star"></i><i class="icon anm anm-star"></i><i class="icon anm anm-star"></i><i class="icon anm anm-star"></i><i class="icon anm anm-star"></i>
                                                    <span class="caption hidden ms-1">8 Reviews</span>
                                                </div>
                                                <!-- End Product Review -->
                                            </div>
                                            <!-- End product details -->
                                        </div>
                                    </div>
                                    <div class="item col-item">
                                        <div class="product-box">
                                            <!-- Start Product Image -->
                                            <div class="product-image">
                                                <!-- Start Product Image -->
                                                <a href="product-layout1.html" class="product-img">
                                                    <!-- Image -->
                                                    <img class="primary blur-up lazyload" data-src="assets/images/products/tools3.jpg" src="assets/images/products/tools3.jpg" alt="Product" title="Product" width="625" height="781" />
                                                    <!-- End Image -->
                                                    <!-- Hover Image -->
                                                    <img class="hover blur-up lazyload" data-src="assets/images/products/tools3-1.jpg" src="assets/images/products/tools3-1.jpg" alt="Product" title="Product" width="625" height="781" />
                                                    <!-- End Hover Image -->
                                                </a>
                                                <!-- End Product Image -->
                                                <!-- Product label -->
                                                <div class="product-labels"><span class="lbl pr-label3">New</span></div>
                                                <!-- End Product label -->
                                                <!--Product Button-->
                                                <div class="button-set style2">
                                                    <!--Cart Button-->
                                                    <a href="#addtocart-modal" class="btn-icon addtocart add-to-cart-modal" data-bs-toggle="modal" data-bs-target="#addtocart_modal">
                                                        <span class="icon-wrap d-flex-justify-center h-100 w-100" data-bs-toggle="tooltip" data-bs-placement="top" title="Add to Cart"><i class="icon anm anm-cart-l"></i><span class="text">Add to Cart</span></span>
                                                    </a>
                                                    <!--End Cart Button-->
                                                    <!--Quick View Button-->
                                                    <a href="#quickview-modal" class="btn-icon quickview quick-view-modal" data-bs-toggle="modal" data-bs-target="#quickview_modal">
                                                        <span class="icon-wrap d-flex-justify-center h-100 w-100" data-bs-toggle="tooltip" data-bs-placement="top" title="Quick View"><i class="icon anm anm-search-plus-l"></i><span class="text">Quick View</span></span>
                                                    </a>
                                                    <!--End Quick View Button-->
                                                    <!--Wishlist Button-->
                                                    <a href="wishlist-style2.html" class="btn-icon wishlist" data-bs-toggle="tooltip" data-bs-placement="top" title="Add To Wishlist"><i class="icon anm anm-heart-l"></i><span class="text">Add To Wishlist</span></a>
                                                    <!--End Wishlist Button-->
                                                    <!--Compare Button-->
                                                    <a href="compare-style2.html" class="btn-icon compare" data-bs-toggle="tooltip" data-bs-placement="top" title="Add to Compare"><i class="icon anm anm-random-r"></i><span class="text">Add to Compare</span></a>
                                                    <!--End Compare Button-->
                                                </div>
                                                <!--End Product Button-->
                                            </div>
                                            <!-- End Product Image -->
                                            <!-- Start Product Details -->
                                            <div class="product-details text-left">
                                                <!--Product Vendor-->
                                                <div class="product-vendor">Hand tool</div>
                                                <!--End Product Vendor-->
                                                <!-- Product Name -->
                                                <div class="product-name">
                                                    <a href="product-layout1.html">Hand Planes Hand tool</a>
                                                </div>
                                                <!-- End Product Name -->
                                                <!-- Product Price -->
                                                <div class="product-price">
                                                    <span class="price">$99.00</span>
                                                </div>
                                                <!-- End Product Price -->
                                                <!-- Product Review -->
                                                <div class="product-review">
                                                    <i class="icon anm anm-star"></i><i class="icon anm anm-star"></i><i class="icon anm anm-star-o"></i><i class="icon anm anm-star-o"></i><i class="icon anm anm-star-o"></i>
                                                    <span class="caption hidden ms-1">10 Reviews</span>
                                                </div>
                                                <!-- End Product Review -->
                                            </div>
                                            <!-- End product details -->
                                        </div>
                                    </div>
                                    <div class="item col-item">
                                        <div class="product-box">
                                            <!-- Start Product Image -->
                                            <div class="product-image">
                                                <!-- Start Product Image -->
                                                <a href="product-layout1.html" class="product-img">
                                                    <!-- Image -->
                                                    <img class="primary blur-up lazyload" data-src="assets/images/products/tools4.jpg" src="assets/images/products/tools4.jpg" alt="Product" title="Product" width="625" height="781" />
                                                    <!-- End Image -->
                                                    <!-- Hover Image -->
                                                    <img class="hover blur-up lazyload" data-src="assets/images/products/tools4-1.jpg" src="assets/images/products/tools4-1.jpg" alt="Product" title="Product" width="625" height="781" />
                                                    <!-- End Hover Image -->
                                                </a>
                                                <!-- End Product Image -->
                                                <!--Product Button-->
                                                <div class="button-set style2">
                                                    <!--Cart Button-->
                                                    <a href="#addtocart-modal" class="btn-icon addtocart add-to-cart-modal" data-bs-toggle="modal" data-bs-target="#addtocart_modal">
                                                        <span class="icon-wrap d-flex-justify-center h-100 w-100" data-bs-toggle="tooltip" data-bs-placement="top" title="Add to Cart"><i class="icon anm anm-cart-l"></i><span class="text">Add to Cart</span></span>
                                                    </a>
                                                    <!--End Cart Button-->
                                                    <!--Quick View Button-->
                                                    <a href="#quickview-modal" class="btn-icon quickview quick-view-modal" data-bs-toggle="modal" data-bs-target="#quickview_modal">
                                                        <span class="icon-wrap d-flex-justify-center h-100 w-100" data-bs-toggle="tooltip" data-bs-placement="top" title="Quick View"><i class="icon anm anm-search-plus-l"></i><span class="text">Quick View</span></span>
                                                    </a>
                                                    <!--End Quick View Button-->
                                                    <!--Wishlist Button-->
                                                    <a href="wishlist-style2.html" class="btn-icon wishlist" data-bs-toggle="tooltip" data-bs-placement="top" title="Add To Wishlist"><i class="icon anm anm-heart-l"></i><span class="text">Add To Wishlist</span></a>
                                                    <!--End Wishlist Button-->
                                                    <!--Compare Button-->
                                                    <a href="compare-style2.html" class="btn-icon compare" data-bs-toggle="tooltip" data-bs-placement="top" title="Add to Compare"><i class="icon anm anm-random-r"></i><span class="text">Add to Compare</span></a>
                                                    <!--End Compare Button-->
                                                </div>
                                                <!--End Product Button-->
                                                <!--Product Availability-->
                                                <div class="product-availability rounded-5">
                                                    <div class="lh-1 d-flex justify-content-between">
                                                        <div class="text-sold">Sold:<strong class="text-primary ms-1">34</strong></div>
                                                        <div class="text-available">Available:<strong class="text-primary ms-1">16</strong></div>
                                                    </div>
                                                    <div class="progress"><div class="progress-bar w-75" role="progressbar" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100"></div></div>
                                                </div>
                                                <!--End Product Availability-->
                                            </div>
                                            <!-- End Product Image -->
                                            <!-- Start Product Details -->
                                            <div class="product-details text-left">
                                                <!--Product Vendor-->
                                                <div class="product-vendor">Garden tool</div>
                                                <!--End Product Vendor-->
                                                <!-- Product Name -->
                                                <div class="product-name">
                                                    <a href="product-layout1.html">Gardening Forks Garden tool</a>
                                                </div>
                                                <!-- End Product Name -->
                                                <!-- Product Price -->
                                                <div class="product-price">
                                                    <span class="price old-price">$198.00</span><span class="price">$99.00</span>
                                                </div>
                                                <!-- End Product Price -->
                                                <!-- Product Review -->
                                                <div class="product-review">
                                                    <i class="icon anm anm-star-o"></i><i class="icon anm anm-star-o"></i><i class="icon anm anm-star-o"></i><i class="icon anm anm-star-o"></i><i class="icon anm anm-star-o"></i>
                                                    <span class="caption hidden ms-1">0 Reviews</span>
                                                </div>
                                                <!-- End Product Review -->
                                            </div>
                                            <!-- End product details -->
                                        </div>
                                    </div>
                                    <div class="item col-item">
                                        <div class="product-box">
                                            <!-- Start Product Image -->
                                            <div class="product-image">
                                                <!-- Start Product Image -->
                                                <a href="product-layout1.html" class="product-img">
                                                    <!-- Image -->
                                                    <img class="primary blur-up lazyload" data-src="assets/images/products/tools5.jpg" src="assets/images/products/tools5.jpg" alt="Product" title="Product" width="625" height="781" />
                                                    <!-- End Image -->
                                                    <!-- Hover Image -->
                                                    <img class="hover blur-up lazyload" data-src="assets/images/products/tools5-1.jpg" src="assets/images/products/tools5-1.jpg" alt="Product" title="Product" width="625" height="781" />
                                                    <!-- End Hover Image -->
                                                </a>
                                                <!-- End Product Image -->
                                                <!-- Product label -->
                                                <div class="product-labels"><span class="lbl pr-label2">Hot</span></div>
                                                <!-- End Product label -->
                                                <!--Product Button-->
                                                <div class="button-set style2">
                                                    <!--Cart Button-->
                                                    <a href="#addtocart-modal" class="btn-icon addtocart add-to-cart-modal" data-bs-toggle="modal" data-bs-target="#addtocart_modal">
                                                        <span class="icon-wrap d-flex-justify-center h-100 w-100" data-bs-toggle="tooltip" data-bs-placement="top" title="Add to Cart"><i class="icon anm anm-cart-l"></i><span class="text">Add to Cart</span></span>
                                                    </a>
                                                    <!--End Cart Button-->
                                                    <!--Quick View Button-->
                                                    <a href="#quickview-modal" class="btn-icon quickview quick-view-modal" data-bs-toggle="modal" data-bs-target="#quickview_modal">
                                                        <span class="icon-wrap d-flex-justify-center h-100 w-100" data-bs-toggle="tooltip" data-bs-placement="top" title="Quick View"><i class="icon anm anm-search-plus-l"></i><span class="text">Quick View</span></span>
                                                    </a>
                                                    <!--End Quick View Button-->
                                                    <!--Wishlist Button-->
                                                    <a href="wishlist-style2.html" class="btn-icon wishlist" data-bs-toggle="tooltip" data-bs-placement="top" title="Add To Wishlist"><i class="icon anm anm-heart-l"></i><span class="text">Add To Wishlist</span></a>
                                                    <!--End Wishlist Button-->
                                                    <!--Compare Button-->
                                                    <a href="compare-style2.html" class="btn-icon compare" data-bs-toggle="tooltip" data-bs-placement="top" title="Add to Compare"><i class="icon anm anm-random-r"></i><span class="text">Add to Compare</span></a>
                                                    <!--End Compare Button-->
                                                </div>
                                                <!--End Product Button-->
                                            </div>
                                            <!-- End Product Image -->
                                            <!-- Start Product Details -->
                                            <div class="product-details text-left">
                                                <!--Product Vendor-->
                                                <div class="product-vendor">Grilling</div>
                                                <!--End Product Vendor-->
                                                <!-- Product Name -->
                                                <div class="product-name">
                                                    <a href="product-layout1.html">Barbecue Tool Grilling Tongs Fork</a>
                                                </div>
                                                <!-- End Product Name -->
                                                <!-- Product Price -->
                                                <div class="product-price">
                                                    <span class="price">$39.00</span>
                                                </div>
                                                <!-- End Product Price -->
                                                <!-- Product Review -->
                                                <div class="product-review">
                                                    <i class="icon anm anm-star"></i><i class="icon anm anm-star"></i><i class="icon anm anm-star-o"></i><i class="icon anm anm-star-o"></i><i class="icon anm anm-star-o"></i>
                                                    <span class="caption hidden ms-1">3 Reviews</span>
                                                </div>
                                                <!-- End Product Review -->
                                            </div>
                                            <!-- End product details -->
                                        </div>
                                    </div>
                                    <div class="item col-item">
                                        <div class="product-box">
                                            <!-- Start Product Image -->
                                            <div class="product-image">
                                                <!-- Start Product Image -->
                                                <a href="product-layout1.html" class="product-img">
                                                    <!-- Image -->
                                                    <img class="primary blur-up lazyload" data-src="assets/images/products/tools7.jpg" src="assets/images/products/tools7.jpg" alt="Product" title="Product" width="625" height="781" />
                                                    <!-- End Image -->
                                                    <!-- Hover Image -->
                                                    <img class="hover blur-up lazyload" data-src="assets/images/products/tools7-1.jpg" src="assets/images/products/tools7-1.jpg" alt="Product" title="Product" width="625" height="781" />
                                                    <!-- End Hover Image -->
                                                </a>
                                                <!-- End Product Image -->
                                                <!--Product Button-->
                                                <div class="button-set style2">
                                                    <!--Cart Button-->
                                                    <a href="#quickshop-modal" class="btn-icon addtocart quick-shop-modal" data-bs-toggle="modal" data-bs-target="#quickshop_modal">
                                                        <span class="icon-wrap d-flex-justify-center h-100 w-100" data-bs-toggle="tooltip" data-bs-placement="top" title="Select Options"><i class="icon anm anm-cart-l"></i><span class="text">Select Options</span></span>
                                                    </a>
                                                    <!--End Cart Button-->
                                                    <!--Quick View Button-->
                                                    <a href="#quickview-modal" class="btn-icon quickview quick-view-modal" data-bs-toggle="modal" data-bs-target="#quickview_modal">
                                                        <span class="icon-wrap d-flex-justify-center h-100 w-100" data-bs-toggle="tooltip" data-bs-placement="top" title="Quick View"><i class="icon anm anm-search-plus-l"></i><span class="text">Quick View</span></span>
                                                    </a>
                                                    <!--End Quick View Button-->
                                                    <!--Wishlist Button-->
                                                    <a href="wishlist-style2.html" class="btn-icon wishlist" data-bs-toggle="tooltip" data-bs-placement="top" title="Add To Wishlist"><i class="icon anm anm-heart-l"></i><span class="text">Add To Wishlist</span></a>
                                                    <!--End Wishlist Button-->
                                                    <!--Compare Button-->
                                                    <a href="compare-style2.html" class="btn-icon compare" data-bs-toggle="tooltip" data-bs-placement="top" title="Add to Compare"><i class="icon anm anm-random-r"></i><span class="text">Add to Compare</span></a>
                                                    <!--End Compare Button-->
                                                </div>
                                                <!--End Product Button-->
                                            </div>
                                            <!-- End Product Image -->
                                            <!-- Start Product Details -->
                                            <div class="product-details text-left">
                                                <!--Product Vendor-->
                                                <div class="product-vendor">Bosh</div>
                                                <!--End Product Vendor-->
                                                <!-- Product Name -->
                                                <div class="product-name">
                                                    <a href="product-layout1.html">Spanners Hand Tools Hex key</a>
                                                </div>
                                                <!-- End Product Name -->
                                                <!-- Product Price -->
                                                <div class="product-price">
                                                    <span class="price">$128.00</span>
                                                </div>
                                                <!-- End Product Price -->
                                                <!-- Product Review -->
                                                <div class="product-review">
                                                    <i class="icon anm anm-star"></i><i class="icon anm anm-star"></i><i class="icon anm anm-star"></i><i class="icon anm anm-star"></i><i class="icon anm anm-star"></i>
                                                    <span class="caption hidden ms-1">8 Reviews</span>
                                                </div>
                                                <!-- End Product Review -->
                                            </div>
                                            <!-- End product details -->
                                        </div>
                                    </div>
                                    <div class="item col-item">
                                        <div class="product-box">
                                            <!-- Start Product Image -->
                                            <div class="product-image">
                                                <!-- Start Product Image -->
                                                <a href="product-layout1.html" class="product-img">
                                                    <!-- Image -->
                                                    <img class="primary blur-up lazyload" data-src="assets/images/products/tools6-1.jpg" src="assets/images/products/tools6-1.jpg" alt="Product" title="Product" width="625" height="781" />
                                                    <!-- End Image -->
                                                    <!-- Hover Image -->
                                                    <img class="hover blur-up lazyload" data-src="assets/images/products/tools6.jpg" src="assets/images/products/tools6.jpg" alt="Product" title="Product" width="625" height="781" />
                                                    <!-- End Hover Image -->
                                                </a>
                                                <!-- End Product Image -->
                                                <!--Product Button-->
                                                <div class="button-set style2">
                                                    <!--Cart Button-->
                                                    <a href="#quickshop-modal" class="btn-icon addtocart quick-shop-modal" data-bs-toggle="modal" data-bs-target="#quickshop_modal">
                                                        <span class="icon-wrap d-flex-justify-center h-100 w-100" data-bs-toggle="tooltip" data-bs-placement="top" title="Select Options"><i class="icon anm anm-cart-l"></i><span class="text">Select Options</span></span>
                                                    </a>
                                                    <!--End Cart Button-->
                                                    <!--Quick View Button-->
                                                    <a href="#quickview-modal" class="btn-icon quickview quick-view-modal" data-bs-toggle="modal" data-bs-target="#quickview_modal">
                                                        <span class="icon-wrap d-flex-justify-center h-100 w-100" data-bs-toggle="tooltip" data-bs-placement="top" title="Quick View"><i class="icon anm anm-search-plus-l"></i><span class="text">Quick View</span></span>
                                                    </a>
                                                    <!--End Quick View Button-->
                                                    <!--Wishlist Button-->
                                                    <a href="wishlist-style2.html" class="btn-icon wishlist" data-bs-toggle="tooltip" data-bs-placement="top" title="Add To Wishlist"><i class="icon anm anm-heart-l"></i><span class="text">Add To Wishlist</span></a>
                                                    <!--End Wishlist Button-->
                                                    <!--Compare Button-->
                                                    <a href="compare-style2.html" class="btn-icon compare" data-bs-toggle="tooltip" data-bs-placement="top" title="Add to Compare"><i class="icon anm anm-random-r"></i><span class="text">Add to Compare</span></a>
                                                    <!--End Compare Button-->
                                                </div>
                                                <!--End Product Button-->
                                            </div>
                                            <!-- End Product Image -->
                                            <!-- Start Product Details -->
                                            <div class="product-details text-left">
                                                <!--Product Vendor-->
                                                <div class="product-vendor">Bosh</div>
                                                <!--End Product Vendor-->
                                                <!-- Product Name -->
                                                <div class="product-name">
                                                    <a href="product-layout1.html">Hammer drill Electric Tool</a>
                                                </div>
                                                <!-- End Product Name -->
                                                <!-- Product Price -->
                                                <div class="product-price">
                                                    <span class="price">$128.00</span>
                                                </div>
                                                <!-- End Product Price -->
                                                <!-- Product Review -->
                                                <div class="product-review">
                                                    <i class="icon anm anm-star"></i><i class="icon anm anm-star"></i><i class="icon anm anm-star"></i><i class="icon anm anm-star"></i><i class="icon anm anm-star"></i>
                                                    <span class="caption hidden ms-1">8 Reviews</span>
                                                </div>
                                                <!-- End Product Review -->
                                            </div>
                                            <!-- End product details -->
                                        </div>
                                    </div>
                                    <div class="item col-item">
                                        <div class="product-box">
                                            <!-- Start Product Image -->
                                            <div class="product-image">
                                                <!-- Start Product Image -->
                                                <a href="product-layout1.html" class="product-img">
                                                    <!-- Image -->
                                                    <img class="primary blur-up lazyload" data-src="assets/images/products/tools8.jpg" src="assets/images/products/tools8.jpg" alt="Product" title="Product" width="625" height="781" />
                                                    <!-- End Image -->
                                                    <!-- Hover Image -->
                                                    <img class="hover blur-up lazyload" data-src="assets/images/products/tools8-1.jpg" src="assets/images/products/tools8-1.jpg" alt="Product" title="Product" width="625" height="781" />
                                                    <!-- End Hover Image -->
                                                </a>
                                                <!-- End Product Image -->
                                                <!--Product Button-->
                                                <div class="button-set style2">
                                                    <!--Cart Button-->
                                                    <a href="#quickshop-modal" class="btn-icon addtocart quick-shop-modal" data-bs-toggle="modal" data-bs-target="#quickshop_modal">
                                                        <span class="icon-wrap d-flex-justify-center h-100 w-100" data-bs-toggle="tooltip" data-bs-placement="top" title="Select Options"><i class="icon anm anm-cart-l"></i><span class="text">Select Options</span></span>
                                                    </a>
                                                    <!--End Cart Button-->
                                                    <!--Quick View Button-->
                                                    <a href="#quickview-modal" class="btn-icon quickview quick-view-modal" data-bs-toggle="modal" data-bs-target="#quickview_modal">
                                                        <span class="icon-wrap d-flex-justify-center h-100 w-100" data-bs-toggle="tooltip" data-bs-placement="top" title="Quick View"><i class="icon anm anm-search-plus-l"></i><span class="text">Quick View</span></span>
                                                    </a>
                                                    <!--End Quick View Button-->
                                                    <!--Wishlist Button-->
                                                    <a href="wishlist-style2.html" class="btn-icon wishlist" data-bs-toggle="tooltip" data-bs-placement="top" title="Add To Wishlist"><i class="icon anm anm-heart-l"></i><span class="text">Add To Wishlist</span></a>
                                                    <!--End Wishlist Button-->
                                                    <!--Compare Button-->
                                                    <a href="compare-style2.html" class="btn-icon compare" data-bs-toggle="tooltip" data-bs-placement="top" title="Add to Compare"><i class="icon anm anm-random-r"></i><span class="text">Add to Compare</span></a>
                                                    <!--End Compare Button-->
                                                </div>
                                                <!--End Product Button-->
                                            </div>
                                            <!-- End Product Image -->
                                            <!-- Start Product Details -->
                                            <div class="product-details text-left">
                                                <!--Product Vendor-->
                                                <div class="product-vendor">Bosh</div>
                                                <!--End Product Vendor-->
                                                <!-- Product Name -->
                                                <div class="product-name">
                                                    <a href="product-layout1.html">Masonry trowel Hand tool</a>
                                                </div>
                                                <!-- End Product Name -->
                                                <!-- Product Price -->
                                                <div class="product-price">
                                                    <span class="price">$128.00</span>
                                                </div>
                                                <!-- End Product Price -->
                                                <!-- Product Review -->
                                                <div class="product-review">
                                                    <i class="icon anm anm-star"></i><i class="icon anm anm-star"></i><i class="icon anm anm-star"></i><i class="icon anm anm-star"></i><i class="icon anm anm-star"></i>
                                                    <span class="caption hidden ms-1">8 Reviews</span>
                                                </div>
                                                <!-- End Product Review -->
                                            </div>
                                            <!-- End product details -->
                                        </div>
                                    </div>                                                                
                                </div>  

                                <div class="view-collection text-center mt-4 mt-md-5">
                                    <a href="shop-left-sidebar.html" class="btn btn-primary btn-lg">View Collection</a>
                                </div>
                            </div>
                            <!--End Product Grid-->
                        </div>

                        <div class="tab-pane" id="newarrivals" role="tabpanel" aria-labelledby="newarrivals-tab">
                            <!--Product Grid-->
                            <div class="grid-products grid-view-items">
                                <div class="row col-row product-options row-cols-xl-4 row-cols-lg-4 row-cols-md-3 row-cols-sm-3 row-cols-2">                                                                              
                                    <div class="item col-item">
                                        <div class="product-box">
                                            <!-- Start Product Image -->
                                            <div class="product-image">
                                                <a href="product-layout1.html" class="product-img">
                                                    <!-- Image -->
                                                    <img class="primary blur-up lazyload" data-src="assets/images/products/tools9.jpg" src="assets/images/products/tools9.jpg" alt="Product" title="Product" width="625" height="781" />
                                                    <!-- End Image -->
                                                    <!-- Hover Image -->
                                                    <img class="hover blur-up lazyload" data-src="assets/images/products/tools9-1.jpg" src="assets/images/products/tools9-1.jpg" alt="Product" title="Product" width="625" height="781" />
                                                    <!-- End Hover Image -->
                                                </a>
                                                <!--Product Button-->
                                                <div class="button-set style2">
                                                    <!--Cart Button-->
                                                    <a href="#quickshop-modal" class="btn-icon addtocart quick-shop-modal" data-bs-toggle="modal" data-bs-target="#quickshop_modal">
                                                        <span class="icon-wrap d-flex-justify-center h-100 w-100" data-bs-toggle="tooltip" data-bs-placement="top" title="Quick Shop"><i class="icon anm anm-cart-l"></i><span class="text">Quick Shop</span></span>
                                                    </a>
                                                    <!--End Cart Button-->
                                                    <!--Quick View Button-->
                                                    <a href="#quickview-modal" class="btn-icon quickview quick-view-modal" data-bs-toggle="modal" data-bs-target="#quickview_modal">
                                                        <span class="icon-wrap d-flex-justify-center h-100 w-100" data-bs-toggle="tooltip" data-bs-placement="top" title="Quick View"><i class="icon anm anm-search-plus-l"></i><span class="text">Quick View</span></span>
                                                    </a>
                                                    <!--End Quick View Button-->
                                                    <!--Wishlist Button-->
                                                    <a href="wishlist-style2.html" class="btn-icon wishlist" data-bs-toggle="tooltip" data-bs-placement="top" title="Add To Wishlist"><i class="icon anm anm-heart-l"></i><span class="text">Add To Wishlist</span></a>
                                                    <!--End Wishlist Button-->
                                                    <!--Compare Button-->
                                                    <a href="compare-style2.html" class="btn-icon compare" data-bs-toggle="tooltip" data-bs-placement="top" title="Add to Compare"><i class="icon anm anm-random-r"></i><span class="text">Add to Compare</span></a>
                                                    <!--End Compare Button-->
                                                </div>
                                                <!--End Product Button-->
                                            </div>
                                            <!-- End Product Image -->
                                            <!-- Start Product Details -->
                                            <div class="product-details text-left">
                                                <!--Product Vendor-->
                                                <div class="product-vendor">Tools</div>
                                                <!--End Product Vendor-->
                                                <!-- Product Name -->
                                                <div class="product-name">
                                                    <a href="product-layout1.html">Hand tool Electrician Tool Boxes</a>
                                                </div>
                                                <!-- End Product Name -->
                                                <!-- Product Price -->
                                                <div class="product-price">
                                                    <span class="price old-price">$299.00</span><span class="price">$199.00</span>
                                                </div>
                                                <!-- End Product Price -->
                                                <!-- Product Review -->
                                                <div class="product-review">
                                                    <i class="icon anm anm-star"></i><i class="icon anm anm-star"></i><i class="icon anm anm-star"></i><i class="icon anm anm-star"></i><i class="icon anm anm-star-o"></i>
                                                    <span class="caption hidden ms-1">8 Reviews</span>
                                                </div>
                                                <!-- End Product Review -->
                                            </div>
                                            <!-- End product details -->
                                        </div>
                                    </div>
                                    <div class="item col-item">
                                        <div class="product-box">
                                            <!-- Start Product Image -->
                                            <div class="product-image">
                                                <!-- Start Product Image -->
                                                <a href="product-layout1.html" class="product-img">
                                                    <!-- Image -->
                                                    <img class="primary blur-up lazyload" data-src="assets/images/products/tools10.jpg" src="assets/images/products/tools10.jpg" alt="Product" title="Product" width="625" height="781" />
                                                    <!-- End Image -->
                                                    <!-- Hover Image -->
                                                    <img class="hover blur-up lazyload" data-src="assets/images/products/tools10-1.jpg" src="assets/images/products/tools10-1.jpg" alt="Product" title="Product" width="625" height="781" />
                                                    <!-- End Hover Image -->
                                                </a>
                                                <!-- End Product Image -->
                                                <!--Product Button-->
                                                <div class="button-set style2">
                                                    <!--Cart Button-->
                                                    <a href="#quickshop-modal" class="btn-icon addtocart quick-shop-modal" data-bs-toggle="modal" data-bs-target="#quickshop_modal">
                                                        <span class="icon-wrap d-flex-justify-center h-100 w-100" data-bs-toggle="tooltip" data-bs-placement="top" title="Select Options"><i class="icon anm anm-cart-l"></i><span class="text">Select Options</span></span>
                                                    </a>
                                                    <!--End Cart Button-->
                                                    <!--Quick View Button-->
                                                    <a href="#quickview-modal" class="btn-icon quickview quick-view-modal" data-bs-toggle="modal" data-bs-target="#quickview_modal">
                                                        <span class="icon-wrap d-flex-justify-center h-100 w-100" data-bs-toggle="tooltip" data-bs-placement="top" title="Quick View"><i class="icon anm anm-search-plus-l"></i><span class="text">Quick View</span></span>
                                                    </a>
                                                    <!--End Quick View Button-->
                                                    <!--Wishlist Button-->
                                                    <a href="wishlist-style2.html" class="btn-icon wishlist" data-bs-toggle="tooltip" data-bs-placement="top" title="Add To Wishlist"><i class="icon anm anm-heart-l"></i><span class="text">Add To Wishlist</span></a>
                                                    <!--End Wishlist Button-->
                                                    <!--Compare Button-->
                                                    <a href="compare-style2.html" class="btn-icon compare" data-bs-toggle="tooltip" data-bs-placement="top" title="Add to Compare"><i class="icon anm anm-random-r"></i><span class="text">Add to Compare</span></a>
                                                    <!--End Compare Button-->
                                                </div>
                                                <!--End Product Button-->
                                            </div>
                                            <!-- End Product Image -->
                                            <!-- Start Product Details -->
                                            <div class="product-details text-left">
                                                <!--Product Vendor-->
                                                <div class="product-vendor">Gardening</div>
                                                <!--End Product Vendor-->
                                                <!-- Product Name -->
                                                <div class="product-name">
                                                    <a href="product-layout1.html">Pruning Shears Tool Gardening</a>
                                                </div>
                                                <!-- End Product Name -->
                                                <!-- Product Price -->
                                                <div class="product-price">
                                                    <span class="price">$128.00</span>
                                                </div>
                                                <!-- End Product Price -->
                                                <!-- Product Review -->
                                                <div class="product-review">
                                                    <i class="icon anm anm-star"></i><i class="icon anm anm-star"></i><i class="icon anm anm-star"></i><i class="icon anm anm-star"></i><i class="icon anm anm-star"></i>
                                                    <span class="caption hidden ms-1">8 Reviews</span>
                                                </div>
                                                <!-- End Product Review -->
                                            </div>
                                            <!-- End product details -->
                                        </div>
                                    </div>
                                    <div class="item col-item">
                                        <div class="product-box">
                                            <!-- Start Product Image -->
                                            <div class="product-image">
                                                <!-- Start Product Image -->
                                                <a href="product-layout1.html" class="product-img">
                                                    <!-- Image -->
                                                    <img class="primary blur-up lazyload" data-src="assets/images/products/tools11.jpg" src="assets/images/products/tools11.jpg" alt="Product" title="Product" width="625" height="781" />
                                                    <!-- End Image -->
                                                    <!-- Hover Image -->
                                                    <img class="hover blur-up lazyload" data-src="assets/images/products/tools11-1.jpg" src="assets/images/products/tools11-1.jpg" alt="Product" title="Product" width="625" height="781" />
                                                    <!-- End Hover Image -->
                                                </a>
                                                <!-- End Product Image -->
                                                <!-- Product label -->
                                                <div class="product-labels"><span class="lbl pr-label3">New</span></div>
                                                <!-- End Product label -->
                                                <!--Product Button-->
                                                <div class="button-set style2">
                                                    <!--Cart Button-->
                                                    <a href="#addtocart-modal" class="btn-icon addtocart add-to-cart-modal" data-bs-toggle="modal" data-bs-target="#addtocart_modal">
                                                        <span class="icon-wrap d-flex-justify-center h-100 w-100" data-bs-toggle="tooltip" data-bs-placement="top" title="Add to Cart"><i class="icon anm anm-cart-l"></i><span class="text">Add to Cart</span></span>
                                                    </a>
                                                    <!--End Cart Button-->
                                                    <!--Quick View Button-->
                                                    <a href="#quickview-modal" class="btn-icon quickview quick-view-modal" data-bs-toggle="modal" data-bs-target="#quickview_modal">
                                                        <span class="icon-wrap d-flex-justify-center h-100 w-100" data-bs-toggle="tooltip" data-bs-placement="top" title="Quick View"><i class="icon anm anm-search-plus-l"></i><span class="text">Quick View</span></span>
                                                    </a>
                                                    <!--End Quick View Button-->
                                                    <!--Wishlist Button-->
                                                    <a href="wishlist-style2.html" class="btn-icon wishlist" data-bs-toggle="tooltip" data-bs-placement="top" title="Add To Wishlist"><i class="icon anm anm-heart-l"></i><span class="text">Add To Wishlist</span></a>
                                                    <!--End Wishlist Button-->
                                                    <!--Compare Button-->
                                                    <a href="compare-style2.html" class="btn-icon compare" data-bs-toggle="tooltip" data-bs-placement="top" title="Add to Compare"><i class="icon anm anm-random-r"></i><span class="text">Add to Compare</span></a>
                                                    <!--End Compare Button-->
                                                </div>
                                                <!--End Product Button-->
                                            </div>
                                            <!-- End Product Image -->
                                            <!-- Start Product Details -->
                                            <div class="product-details text-left">
                                                <!--Product Vendor-->
                                                <div class="product-vendor">Hand tool</div>
                                                <!--End Product Vendor-->
                                                <!-- Product Name -->
                                                <div class="product-name">
                                                    <a href="product-layout1.html">Garden tool Gardening Hand tool</a>
                                                </div>
                                                <!-- End Product Name -->
                                                <!-- Product Price -->
                                                <div class="product-price">
                                                    <span class="price">$199.00</span>
                                                </div>
                                                <!-- End Product Price -->
                                                <!-- Product Review -->
                                                <div class="product-review">
                                                    <i class="icon anm anm-star"></i><i class="icon anm anm-star"></i><i class="icon anm anm-star-o"></i><i class="icon anm anm-star-o"></i><i class="icon anm anm-star-o"></i>
                                                    <span class="caption hidden ms-1">3 Reviews</span>
                                                </div>
                                                <!-- End Product Review -->
                                            </div>
                                            <!-- End product details -->
                                        </div>
                                    </div>
                                    <div class="item col-item">
                                        <div class="product-box">
                                            <!-- Start Product Image -->
                                            <div class="product-image">
                                                <!-- Start Product Image -->
                                                <a href="product-layout1.html" class="product-img">
                                                    <!-- Image -->
                                                    <img class="primary blur-up lazyload" data-src="assets/images/products/tools12.jpg" src="assets/images/products/tools12.jpg" alt="Product" title="Product" width="625" height="781" />
                                                    <!-- End Image -->
                                                    <!-- Hover Image -->
                                                    <img class="hover blur-up lazyload" data-src="assets/images/products/tools12-1.jpg" src="assets/images/products/tools12-1.jpg" alt="Product" title="Product" width="625" height="781" />
                                                    <!-- End Hover Image -->
                                                </a>
                                                <!-- End Product Image -->
                                                <!--Product Button-->
                                                <div class="button-set style2">
                                                    <!--Cart Button-->
                                                    <a href="#addtocart-modal" class="btn-icon addtocart add-to-cart-modal" data-bs-toggle="modal" data-bs-target="#addtocart_modal">
                                                        <span class="icon-wrap d-flex-justify-center h-100 w-100" data-bs-toggle="tooltip" data-bs-placement="top" title="Add to Cart"><i class="icon anm anm-cart-l"></i><span class="text">Add to Cart</span></span>
                                                    </a>
                                                    <!--End Cart Button-->
                                                    <!--Quick View Button-->
                                                    <a href="#quickview-modal" class="btn-icon quickview quick-view-modal" data-bs-toggle="modal" data-bs-target="#quickview_modal">
                                                        <span class="icon-wrap d-flex-justify-center h-100 w-100" data-bs-toggle="tooltip" data-bs-placement="top" title="Quick View"><i class="icon anm anm-search-plus-l"></i><span class="text">Quick View</span></span>
                                                    </a>
                                                    <!--End Quick View Button-->
                                                    <!--Wishlist Button-->
                                                    <a href="wishlist-style2.html" class="btn-icon wishlist" data-bs-toggle="tooltip" data-bs-placement="top" title="Add To Wishlist"><i class="icon anm anm-heart-l"></i><span class="text">Add To Wishlist</span></a>
                                                    <!--End Wishlist Button-->
                                                    <!--Compare Button-->
                                                    <a href="compare-style2.html" class="btn-icon compare" data-bs-toggle="tooltip" data-bs-placement="top" title="Add to Compare"><i class="icon anm anm-random-r"></i><span class="text">Add to Compare</span></a>
                                                    <!--End Compare Button-->
                                                </div>
                                                <!--End Product Button-->
                                                <!--Product Availability-->
                                                <div class="product-availability rounded-5">
                                                    <div class="lh-1 d-flex justify-content-between">
                                                        <div class="text-sold">Sold:<strong class="text-primary ms-1">34</strong></div>
                                                        <div class="text-available">Available:<strong class="text-primary ms-1">16</strong></div>
                                                    </div>
                                                    <div class="progress"><div class="progress-bar w-75" role="progressbar" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100"></div></div>
                                                </div>
                                                <!--End Product Availability-->
                                            </div>
                                            <!-- End Product Image -->
                                            <!-- Start Product Details -->
                                            <div class="product-details text-left">
                                                <!--Product Vendor-->
                                                <div class="product-vendor">Garden tool</div>
                                                <!--End Product Vendor-->
                                                <!-- Product Name -->
                                                <div class="product-name">
                                                    <a href="product-layout1.html">Chainsaw Cutting tool</a>
                                                </div>
                                                <!-- End Product Name -->
                                                <!-- Product Price -->
                                                <div class="product-price">
                                                    <span class="price old-price">$598.00</span><span class="price">$399.00</span>
                                                </div>
                                                <!-- End Product Price -->
                                                <!-- Product Review -->
                                                <div class="product-review">
                                                    <i class="icon anm anm-star-o"></i><i class="icon anm anm-star-o"></i><i class="icon anm anm-star-o"></i><i class="icon anm anm-star-o"></i><i class="icon anm anm-star-o"></i>
                                                    <span class="caption hidden ms-1">0 Reviews</span>
                                                </div>
                                                <!-- End Product Review -->
                                            </div>
                                            <!-- End product details -->
                                        </div>
                                    </div>
                                    <div class="item col-item">
                                        <div class="product-box">
                                            <!-- Start Product Image -->
                                            <div class="product-image">
                                                <!-- Start Product Image -->
                                                <a href="product-layout1.html" class="product-img">
                                                    <!-- Image -->
                                                    <img class="primary blur-up lazyload" data-src="assets/images/products/tools8.jpg" src="assets/images/products/tools8.jpg" alt="Product" title="Product" width="625" height="781" />
                                                    <!-- End Image -->
                                                    <!-- Hover Image -->
                                                    <img class="hover blur-up lazyload" data-src="assets/images/products/tools8-1.jpg" src="assets/images/products/tools8-1.jpg" alt="Product" title="Product" width="625" height="781" />
                                                    <!-- End Hover Image -->
                                                </a>
                                                <!-- End Product Image -->
                                                <!--Product Button-->
                                                <div class="button-set style2">
                                                    <!--Cart Button-->
                                                    <a href="#quickshop-modal" class="btn-icon addtocart quick-shop-modal" data-bs-toggle="modal" data-bs-target="#quickshop_modal">
                                                        <span class="icon-wrap d-flex-justify-center h-100 w-100" data-bs-toggle="tooltip" data-bs-placement="top" title="Select Options"><i class="icon anm anm-cart-l"></i><span class="text">Select Options</span></span>
                                                    </a>
                                                    <!--End Cart Button-->
                                                    <!--Quick View Button-->
                                                    <a href="#quickview-modal" class="btn-icon quickview quick-view-modal" data-bs-toggle="modal" data-bs-target="#quickview_modal">
                                                        <span class="icon-wrap d-flex-justify-center h-100 w-100" data-bs-toggle="tooltip" data-bs-placement="top" title="Quick View"><i class="icon anm anm-search-plus-l"></i><span class="text">Quick View</span></span>
                                                    </a>
                                                    <!--End Quick View Button-->
                                                    <!--Wishlist Button-->
                                                    <a href="wishlist-style2.html" class="btn-icon wishlist" data-bs-toggle="tooltip" data-bs-placement="top" title="Add To Wishlist"><i class="icon anm anm-heart-l"></i><span class="text">Add To Wishlist</span></a>
                                                    <!--End Wishlist Button-->
                                                    <!--Compare Button-->
                                                    <a href="compare-style2.html" class="btn-icon compare" data-bs-toggle="tooltip" data-bs-placement="top" title="Add to Compare"><i class="icon anm anm-random-r"></i><span class="text">Add to Compare</span></a>
                                                    <!--End Compare Button-->
                                                </div>
                                                <!--End Product Button-->
                                            </div>
                                            <!-- End Product Image -->
                                            <!-- Start Product Details -->
                                            <div class="product-details text-left">
                                                <!--Product Vendor-->
                                                <div class="product-vendor">Bosh</div>
                                                <!--End Product Vendor-->
                                                <!-- Product Name -->
                                                <div class="product-name">
                                                    <a href="product-layout1.html">Masonry trowel Hand tool</a>
                                                </div>
                                                <!-- End Product Name -->
                                                <!-- Product Price -->
                                                <div class="product-price">
                                                    <span class="price">$128.00</span>
                                                </div>
                                                <!-- End Product Price -->
                                                <!-- Product Review -->
                                                <div class="product-review">
                                                    <i class="icon anm anm-star"></i><i class="icon anm anm-star"></i><i class="icon anm anm-star"></i><i class="icon anm anm-star"></i><i class="icon anm anm-star"></i>
                                                    <span class="caption hidden ms-1">8 Reviews</span>
                                                </div>
                                                <!-- End Product Review -->
                                            </div>
                                            <!-- End product details -->
                                        </div>
                                    </div>  
                                    <div class="item col-item">
                                        <div class="product-box">
                                            <!-- Start Product Image -->
                                            <div class="product-image">
                                                <!-- Start Product Image -->
                                                <a href="product-layout1.html" class="product-img">
                                                    <!-- Image -->
                                                    <img class="primary blur-up lazyload" data-src="assets/images/products/tools-13.jpg" src="assets/images/products/tools-13.jpg" alt="Product" title="Product" width="625" height="781" />
                                                    <!-- End Image -->
                                                    <!-- Hover Image -->
                                                    <img class="hover blur-up lazyload" data-src="assets/images/products/tools-13-1.jpg" src="assets/images/products/tools-13-1.jpg" alt="Product" title="Product" width="625" height="781" />
                                                    <!-- End Hover Image -->
                                                </a>
                                                <!-- End Product Image -->
                                                <!-- Product label -->
                                                <div class="product-labels"><span class="lbl pr-label2">Hot</span></div>
                                                <!-- End Product label -->
                                                <!--Product Button-->
                                                <div class="button-set style2">
                                                    <!--Cart Button-->
                                                    <a href="#addtocart-modal" class="btn-icon addtocart add-to-cart-modal" data-bs-toggle="modal" data-bs-target="#addtocart_modal">
                                                        <span class="icon-wrap d-flex-justify-center h-100 w-100" data-bs-toggle="tooltip" data-bs-placement="top" title="Add to Cart"><i class="icon anm anm-cart-l"></i><span class="text">Add to Cart</span></span>
                                                    </a>
                                                    <!--End Cart Button-->
                                                    <!--Quick View Button-->
                                                    <a href="#quickview-modal" class="btn-icon quickview quick-view-modal" data-bs-toggle="modal" data-bs-target="#quickview_modal">
                                                        <span class="icon-wrap d-flex-justify-center h-100 w-100" data-bs-toggle="tooltip" data-bs-placement="top" title="Quick View"><i class="icon anm anm-search-plus-l"></i><span class="text">Quick View</span></span>
                                                    </a>
                                                    <!--End Quick View Button-->
                                                    <!--Wishlist Button-->
                                                    <a href="wishlist-style2.html" class="btn-icon wishlist" data-bs-toggle="tooltip" data-bs-placement="top" title="Add To Wishlist"><i class="icon anm anm-heart-l"></i><span class="text">Add To Wishlist</span></a>
                                                    <!--End Wishlist Button-->
                                                    <!--Compare Button-->
                                                    <a href="compare-style2.html" class="btn-icon compare" data-bs-toggle="tooltip" data-bs-placement="top" title="Add to Compare"><i class="icon anm anm-random-r"></i><span class="text">Add to Compare</span></a>
                                                    <!--End Compare Button-->
                                                </div>
                                                <!--End Product Button-->
                                            </div>
                                            <!-- End Product Image -->
                                            <!-- Start Product Details -->
                                            <div class="product-details text-left">
                                                <!--Product Vendor-->
                                                <div class="product-vendor">Wrench</div>
                                                <!--End Product Vendor-->
                                                <!-- Product Name -->
                                                <div class="product-name">
                                                    <a href="product-layout1.html">Pliers Hand tool Wrench</a>
                                                </div>
                                                <!-- End Product Name -->
                                                <!-- Product Price -->
                                                <div class="product-price">
                                                    <span class="price">$39.00</span>
                                                </div>
                                                <!-- End Product Price -->
                                                <!-- Product Review -->
                                                <div class="product-review">
                                                    <i class="icon anm anm-star"></i><i class="icon anm anm-star"></i><i class="icon anm anm-star-o"></i><i class="icon anm anm-star-o"></i><i class="icon anm anm-star-o"></i>
                                                    <span class="caption hidden ms-1">3 Reviews</span>
                                                </div>
                                                <!-- End Product Review -->
                                            </div>
                                            <!-- End product details -->
                                        </div>
                                    </div>
                                    <div class="item col-item">
                                        <div class="product-box">
                                            <!-- Start Product Image -->
                                            <div class="product-image">
                                                <!-- Start Product Image -->
                                                <a href="product-layout1.html" class="product-img">
                                                    <!-- Image -->
                                                    <img class="primary blur-up lazyload" data-src="assets/images/products/tools7.jpg" src="assets/images/products/tools7.jpg" alt="Product" title="Product" width="625" height="781" />
                                                    <!-- End Image -->
                                                    <!-- Hover Image -->
                                                    <img class="hover blur-up lazyload" data-src="assets/images/products/tools7-1.jpg" src="assets/images/products/tools7-1.jpg" alt="Product" title="Product" width="625" height="781" />
                                                    <!-- End Hover Image -->
                                                </a>
                                                <!-- End Product Image -->
                                                <!--Product Button-->
                                                <div class="button-set style2">
                                                    <!--Cart Button-->
                                                    <a href="#quickshop-modal" class="btn-icon addtocart quick-shop-modal" data-bs-toggle="modal" data-bs-target="#quickshop_modal">
                                                        <span class="icon-wrap d-flex-justify-center h-100 w-100" data-bs-toggle="tooltip" data-bs-placement="top" title="Select Options"><i class="icon anm anm-cart-l"></i><span class="text">Select Options</span></span>
                                                    </a>
                                                    <!--End Cart Button-->
                                                    <!--Quick View Button-->
                                                    <a href="#quickview-modal" class="btn-icon quickview quick-view-modal" data-bs-toggle="modal" data-bs-target="#quickview_modal">
                                                        <span class="icon-wrap d-flex-justify-center h-100 w-100" data-bs-toggle="tooltip" data-bs-placement="top" title="Quick View"><i class="icon anm anm-search-plus-l"></i><span class="text">Quick View</span></span>
                                                    </a>
                                                    <!--End Quick View Button-->
                                                    <!--Wishlist Button-->
                                                    <a href="wishlist-style2.html" class="btn-icon wishlist" data-bs-toggle="tooltip" data-bs-placement="top" title="Add To Wishlist"><i class="icon anm anm-heart-l"></i><span class="text">Add To Wishlist</span></a>
                                                    <!--End Wishlist Button-->
                                                    <!--Compare Button-->
                                                    <a href="compare-style2.html" class="btn-icon compare" data-bs-toggle="tooltip" data-bs-placement="top" title="Add to Compare"><i class="icon anm anm-random-r"></i><span class="text">Add to Compare</span></a>
                                                    <!--End Compare Button-->
                                                </div>
                                                <!--End Product Button-->
                                            </div>
                                            <!-- End Product Image -->
                                            <!-- Start Product Details -->
                                            <div class="product-details text-left">
                                                <!--Product Vendor-->
                                                <div class="product-vendor">Bosh</div>
                                                <!--End Product Vendor-->
                                                <!-- Product Name -->
                                                <div class="product-name">
                                                    <a href="product-layout1.html">Spanners Hand Tools Hex key</a>
                                                </div>
                                                <!-- End Product Name -->
                                                <!-- Product Price -->
                                                <div class="product-price">
                                                    <span class="price">$128.00</span>
                                                </div>
                                                <!-- End Product Price -->
                                                <!-- Product Review -->
                                                <div class="product-review">
                                                    <i class="icon anm anm-star"></i><i class="icon anm anm-star"></i><i class="icon anm anm-star"></i><i class="icon anm anm-star"></i><i class="icon anm anm-star"></i>
                                                    <span class="caption hidden ms-1">8 Reviews</span>
                                                </div>
                                                <!-- End Product Review -->
                                            </div>
                                            <!-- End product details -->
                                        </div>
                                    </div>
                                    <div class="item col-item">
                                        <div class="product-box">
                                            <!-- Start Product Image -->
                                            <div class="product-image">
                                                <!-- Start Product Image -->
                                                <a href="product-layout1.html" class="product-img">
                                                    <!-- Image -->
                                                    <img class="primary blur-up lazyload" data-src="assets/images/products/tools6-1.jpg" src="assets/images/products/tools6-1.jpg" alt="Product" title="Product" width="625" height="781" />
                                                    <!-- End Image -->
                                                    <!-- Hover Image -->
                                                    <img class="hover blur-up lazyload" data-src="assets/images/products/tools6.jpg" src="assets/images/products/tools6.jpg" alt="Product" title="Product" width="625" height="781" />
                                                    <!-- End Hover Image -->
                                                </a>
                                                <!-- End Product Image -->
                                                <!--Product Button-->
                                                <div class="button-set style2">
                                                    <!--Cart Button-->
                                                    <a href="#quickshop-modal" class="btn-icon addtocart quick-shop-modal" data-bs-toggle="modal" data-bs-target="#quickshop_modal">
                                                        <span class="icon-wrap d-flex-justify-center h-100 w-100" data-bs-toggle="tooltip" data-bs-placement="top" title="Select Options"><i class="icon anm anm-cart-l"></i><span class="text">Select Options</span></span>
                                                    </a>
                                                    <!--End Cart Button-->
                                                    <!--Quick View Button-->
                                                    <a href="#quickview-modal" class="btn-icon quickview quick-view-modal" data-bs-toggle="modal" data-bs-target="#quickview_modal">
                                                        <span class="icon-wrap d-flex-justify-center h-100 w-100" data-bs-toggle="tooltip" data-bs-placement="top" title="Quick View"><i class="icon anm anm-search-plus-l"></i><span class="text">Quick View</span></span>
                                                    </a>
                                                    <!--End Quick View Button-->
                                                    <!--Wishlist Button-->
                                                    <a href="wishlist-style2.html" class="btn-icon wishlist" data-bs-toggle="tooltip" data-bs-placement="top" title="Add To Wishlist"><i class="icon anm anm-heart-l"></i><span class="text">Add To Wishlist</span></a>
                                                    <!--End Wishlist Button-->
                                                    <!--Compare Button-->
                                                    <a href="compare-style2.html" class="btn-icon compare" data-bs-toggle="tooltip" data-bs-placement="top" title="Add to Compare"><i class="icon anm anm-random-r"></i><span class="text">Add to Compare</span></a>
                                                    <!--End Compare Button-->
                                                </div>
                                                <!--End Product Button-->
                                            </div>
                                            <!-- End Product Image -->
                                            <!-- Start Product Details -->
                                            <div class="product-details text-left">
                                                <!--Product Vendor-->
                                                <div class="product-vendor">Bosh</div>
                                                <!--End Product Vendor-->
                                                <!-- Product Name -->
                                                <div class="product-name">
                                                    <a href="product-layout1.html">Hammer drill Electric Tool</a>
                                                </div>
                                                <!-- End Product Name -->
                                                <!-- Product Price -->
                                                <div class="product-price">
                                                    <span class="price">$128.00</span>
                                                </div>
                                                <!-- End Product Price -->
                                                <!-- Product Review -->
                                                <div class="product-review">
                                                    <i class="icon anm anm-star"></i><i class="icon anm anm-star"></i><i class="icon anm anm-star"></i><i class="icon anm anm-star"></i><i class="icon anm anm-star"></i>
                                                    <span class="caption hidden ms-1">8 Reviews</span>
                                                </div>
                                                <!-- End Product Review -->
                                            </div>
                                            <!-- End product details -->
                                        </div>
                                    </div>  
                                </div>

                                <div class="view-collection text-center mt-4 mt-md-5">
                                    <a href="shop-left-sidebar.html" class="btn btn-secondary btn-lg">View Collection</a>
                                </div>
                            </div>
                            <!--End Product Grid-->
                        </div>

                        <div class="tab-pane" id="toprated" role="tabpanel" aria-labelledby="toprated-tab">
                            <!--Product Grid-->
                            <div class="grid-products grid-view-items">
                                <div class="row col-row product-options row-cols-xl-4 row-cols-lg-4 row-cols-md-3 row-cols-sm-3 row-cols-2">                                                                            
                                    <div class="item col-item">
                                        <div class="product-box">
                                            <!-- Start Product Image -->
                                            <div class="product-image">
                                                <!-- Start Product Image -->
                                                <a href="product-layout1.html" class="product-img"><img class="blur-up lazyload" src="assets/images/products/tools1.jpg" data-src="assets/images/products/tools1.jpg" alt="Product" title="Product" width="625" height="781" /></a>
                                                <!-- End Product Image -->
                                                <!-- Product label -->
                                                <div class="product-labels"><span class="lbl on-sale">Sale</span></div>
                                                <!-- End Product label -->
                                                <!--Countdown Timer-->
                                                <div class="saleTime" data-countdown="2025/01/01"></div>
                                                <!--End Countdown Timer-->
                                                <!--Product Button-->
                                                <div class="button-set style2">
                                                    <!--Cart Button-->
                                                    <a href="#quickshop-modal" class="btn-icon addtocart quick-shop-modal" data-bs-toggle="modal" data-bs-target="#quickshop_modal">
                                                        <span class="icon-wrap d-flex-justify-center h-100 w-100" data-bs-toggle="tooltip" data-bs-placement="top" title="Quick Shop"><i class="icon anm anm-cart-l"></i><span class="text">Quick Shop</span></span>
                                                    </a>
                                                    <!--End Cart Button-->
                                                    <!--Quick View Button-->
                                                    <a href="#quickview-modal" class="btn-icon quickview quick-view-modal" data-bs-toggle="modal" data-bs-target="#quickview_modal">
                                                        <span class="icon-wrap d-flex-justify-center h-100 w-100" data-bs-toggle="tooltip" data-bs-placement="top" title="Quick View"><i class="icon anm anm-search-plus-l"></i><span class="text">Quick View</span></span>
                                                    </a>
                                                    <!--End Quick View Button-->
                                                    <!--Wishlist Button-->
                                                    <a href="wishlist-style2.html" class="btn-icon wishlist" data-bs-toggle="tooltip" data-bs-placement="top" title="Add To Wishlist"><i class="icon anm anm-heart-l"></i><span class="text">Add To Wishlist</span></a>
                                                    <!--End Wishlist Button-->
                                                    <!--Compare Button-->
                                                    <a href="compare-style2.html" class="btn-icon compare" data-bs-toggle="tooltip" data-bs-placement="top" title="Add to Compare"><i class="icon anm anm-random-r"></i><span class="text">Add to Compare</span></a>
                                                    <!--End Compare Button-->
                                                </div>
                                                <!--End Product Button-->
                                            </div>
                                            <!-- End Product Image -->
                                            <!-- Start Product Details -->
                                            <div class="product-details text-left">
                                                <!--Product Vendor-->
                                                <div class="product-vendor">Tools</div>
                                                <!--End Product Vendor-->
                                                <!-- Product Name -->
                                                <div class="product-name">
                                                    <a href="product-layout1.html">Masonry trowel Tool Plasterer</a>
                                                </div>
                                                <!-- End Product Name -->
                                                <!-- Product Price -->
                                                <div class="product-price">
                                                    <span class="price old-price">$114.00</span><span class="price">$99.00</span>
                                                </div>
                                                <!-- End Product Price -->
                                                <!-- Product Review -->
                                                <div class="product-review">
                                                    <i class="icon anm anm-star"></i><i class="icon anm anm-star"></i><i class="icon anm anm-star"></i><i class="icon anm anm-star"></i><i class="icon anm anm-star-o"></i>
                                                    <span class="caption hidden ms-1">3 Reviews</span>
                                                </div>
                                                <!-- End Product Review -->
                                            </div>
                                            <!-- End product details -->
                                        </div>
                                    </div>
                                    <div class="item col-item">
                                        <div class="product-box">
                                            <!-- Start Product Image -->
                                            <div class="product-image">
                                                <!-- Start Product Image -->
                                                <a href="product-layout1.html" class="product-img">
                                                    <!-- Image -->
                                                    <img class="primary blur-up lazyload" data-src="assets/images/products/tools2.jpg" src="assets/images/products/tools2.jpg" alt="Product" title="Product" width="625" height="781" />
                                                    <!-- End Image -->
                                                    <!-- Hover Image -->
                                                    <img class="hover blur-up lazyload" data-src="assets/images/products/tools2-1.jpg" src="assets/images/products/tools2-1.jpg" alt="Product" title="Product" width="625" height="781" />
                                                    <!-- End Hover Image -->
                                                </a>
                                                <!-- End Product Image -->
                                                <!--Product Button-->
                                                <div class="button-set style2">
                                                    <!--Cart Button-->
                                                    <a href="#quickshop-modal" class="btn-icon addtocart quick-shop-modal" data-bs-toggle="modal" data-bs-target="#quickshop_modal">
                                                        <span class="icon-wrap d-flex-justify-center h-100 w-100" data-bs-toggle="tooltip" data-bs-placement="top" title="Select Options"><i class="icon anm anm-cart-l"></i><span class="text">Select Options</span></span>
                                                    </a>
                                                    <!--End Cart Button-->
                                                    <!--Quick View Button-->
                                                    <a href="#quickview-modal" class="btn-icon quickview quick-view-modal" data-bs-toggle="modal" data-bs-target="#quickview_modal">
                                                        <span class="icon-wrap d-flex-justify-center h-100 w-100" data-bs-toggle="tooltip" data-bs-placement="top" title="Quick View"><i class="icon anm anm-search-plus-l"></i><span class="text">Quick View</span></span>
                                                    </a>
                                                    <!--End Quick View Button-->
                                                    <!--Wishlist Button-->
                                                    <a href="wishlist-style2.html" class="btn-icon wishlist" data-bs-toggle="tooltip" data-bs-placement="top" title="Add To Wishlist"><i class="icon anm anm-heart-l"></i><span class="text">Add To Wishlist</span></a>
                                                    <!--End Wishlist Button-->
                                                    <!--Compare Button-->
                                                    <a href="compare-style2.html" class="btn-icon compare" data-bs-toggle="tooltip" data-bs-placement="top" title="Add to Compare"><i class="icon anm anm-random-r"></i><span class="text">Add to Compare</span></a>
                                                    <!--End Compare Button-->
                                                </div>
                                                <!--End Product Button-->
                                            </div>
                                            <!-- End Product Image -->
                                            <!-- Start Product Details -->
                                            <div class="product-details text-left">
                                                <!--Product Vendor-->
                                                <div class="product-vendor">Bosh</div>
                                                <!--End Product Vendor-->
                                                <!-- Product Name -->
                                                <div class="product-name">
                                                    <a href="product-layout1.html">Hammer drill Electric Tool</a>
                                                </div>
                                                <!-- End Product Name -->
                                                <!-- Product Price -->
                                                <div class="product-price">
                                                    <span class="price">$128.00</span>
                                                </div>
                                                <!-- End Product Price -->
                                                <!-- Product Review -->
                                                <div class="product-review">
                                                    <i class="icon anm anm-star"></i><i class="icon anm anm-star"></i><i class="icon anm anm-star"></i><i class="icon anm anm-star"></i><i class="icon anm anm-star"></i>
                                                    <span class="caption hidden ms-1">8 Reviews</span>
                                                </div>
                                                <!-- End Product Review -->
                                            </div>
                                            <!-- End product details -->
                                        </div>
                                    </div>
                                    <div class="item col-item">
                                        <div class="product-box">
                                            <!-- Start Product Image -->
                                            <div class="product-image">
                                                <!-- Start Product Image -->
                                                <a href="product-layout1.html" class="product-img">
                                                    <!-- Image -->
                                                    <img class="primary blur-up lazyload" data-src="assets/images/products/tools12.jpg" src="assets/images/products/tools12.jpg" alt="Product" title="Product" width="625" height="781" />
                                                    <!-- End Image -->
                                                    <!-- Hover Image -->
                                                    <img class="hover blur-up lazyload" data-src="assets/images/products/tools12-1.jpg" src="assets/images/products/tools12-1.jpg" alt="Product" title="Product" width="625" height="781" />
                                                    <!-- End Hover Image -->
                                                </a>
                                                <!-- End Product Image -->
                                                <!--Product Button-->
                                                <div class="button-set style2">
                                                    <!--Cart Button-->
                                                    <a href="#addtocart-modal" class="btn-icon addtocart add-to-cart-modal" data-bs-toggle="modal" data-bs-target="#addtocart_modal">
                                                        <span class="icon-wrap d-flex-justify-center h-100 w-100" data-bs-toggle="tooltip" data-bs-placement="top" title="Add to Cart"><i class="icon anm anm-cart-l"></i><span class="text">Add to Cart</span></span>
                                                    </a>
                                                    <!--End Cart Button-->
                                                    <!--Quick View Button-->
                                                    <a href="#quickview-modal" class="btn-icon quickview quick-view-modal" data-bs-toggle="modal" data-bs-target="#quickview_modal">
                                                        <span class="icon-wrap d-flex-justify-center h-100 w-100" data-bs-toggle="tooltip" data-bs-placement="top" title="Quick View"><i class="icon anm anm-search-plus-l"></i><span class="text">Quick View</span></span>
                                                    </a>
                                                    <!--End Quick View Button-->
                                                    <!--Wishlist Button-->
                                                    <a href="wishlist-style2.html" class="btn-icon wishlist" data-bs-toggle="tooltip" data-bs-placement="top" title="Add To Wishlist"><i class="icon anm anm-heart-l"></i><span class="text">Add To Wishlist</span></a>
                                                    <!--End Wishlist Button-->
                                                    <!--Compare Button-->
                                                    <a href="compare-style2.html" class="btn-icon compare" data-bs-toggle="tooltip" data-bs-placement="top" title="Add to Compare"><i class="icon anm anm-random-r"></i><span class="text">Add to Compare</span></a>
                                                    <!--End Compare Button-->
                                                </div>
                                                <!--End Product Button-->
                                                <!--Product Availability-->
                                                <div class="product-availability rounded-5">
                                                    <div class="lh-1 d-flex justify-content-between">
                                                        <div class="text-sold">Sold:<strong class="text-primary ms-1">34</strong></div>
                                                        <div class="text-available">Available:<strong class="text-primary ms-1">16</strong></div>
                                                    </div>
                                                    <div class="progress"><div class="progress-bar w-75" role="progressbar" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100"></div></div>
                                                </div>
                                                <!--End Product Availability-->
                                            </div>
                                            <!-- End Product Image -->
                                            <!-- Start Product Details -->
                                            <div class="product-details text-left">
                                                <!--Product Vendor-->
                                                <div class="product-vendor">Garden tool</div>
                                                <!--End Product Vendor-->
                                                <!-- Product Name -->
                                                <div class="product-name">
                                                    <a href="product-layout1.html">Chainsaw Cutting tool</a>
                                                </div>
                                                <!-- End Product Name -->
                                                <!-- Product Price -->
                                                <div class="product-price">
                                                    <span class="price old-price">$598.00</span><span class="price">$399.00</span>
                                                </div>
                                                <!-- End Product Price -->
                                                <!-- Product Review -->
                                                <div class="product-review">
                                                    <i class="icon anm anm-star-o"></i><i class="icon anm anm-star-o"></i><i class="icon anm anm-star-o"></i><i class="icon anm anm-star-o"></i><i class="icon anm anm-star-o"></i>
                                                    <span class="caption hidden ms-1">0 Reviews</span>
                                                </div>
                                                <!-- End Product Review -->
                                            </div>
                                            <!-- End product details -->
                                        </div>
                                    </div>
                                    <div class="item col-item">
                                        <div class="product-box">
                                            <!-- Start Product Image -->
                                            <div class="product-image">
                                                <!-- Start Product Image -->
                                                <a href="product-layout1.html" class="product-img">
                                                    <!-- Image -->
                                                    <img class="primary blur-up lazyload" data-src="assets/images/products/tools4.jpg" src="assets/images/products/tools4.jpg" alt="Product" title="Product" width="625" height="781" />
                                                    <!-- End Image -->
                                                    <!-- Hover Image -->
                                                    <img class="hover blur-up lazyload" data-src="assets/images/products/tools4-1.jpg" src="assets/images/products/tools4-1.jpg" alt="Product" title="Product" width="625" height="781" />
                                                    <!-- End Hover Image -->
                                                </a>
                                                <!-- End Product Image -->
                                                <!--Product Button-->
                                                <div class="button-set style2">
                                                    <!--Cart Button-->
                                                    <a href="#addtocart-modal" class="btn-icon addtocart add-to-cart-modal" data-bs-toggle="modal" data-bs-target="#addtocart_modal">
                                                        <span class="icon-wrap d-flex-justify-center h-100 w-100" data-bs-toggle="tooltip" data-bs-placement="top" title="Add to Cart"><i class="icon anm anm-cart-l"></i><span class="text">Add to Cart</span></span>
                                                    </a>
                                                    <!--End Cart Button-->
                                                    <!--Quick View Button-->
                                                    <a href="#quickview-modal" class="btn-icon quickview quick-view-modal" data-bs-toggle="modal" data-bs-target="#quickview_modal">
                                                        <span class="icon-wrap d-flex-justify-center h-100 w-100" data-bs-toggle="tooltip" data-bs-placement="top" title="Quick View"><i class="icon anm anm-search-plus-l"></i><span class="text">Quick View</span></span>
                                                    </a>
                                                    <!--End Quick View Button-->
                                                    <!--Wishlist Button-->
                                                    <a href="wishlist-style2.html" class="btn-icon wishlist" data-bs-toggle="tooltip" data-bs-placement="top" title="Add To Wishlist"><i class="icon anm anm-heart-l"></i><span class="text">Add To Wishlist</span></a>
                                                    <!--End Wishlist Button-->
                                                    <!--Compare Button-->
                                                    <a href="compare-style2.html" class="btn-icon compare" data-bs-toggle="tooltip" data-bs-placement="top" title="Add to Compare"><i class="icon anm anm-random-r"></i><span class="text">Add to Compare</span></a>
                                                    <!--End Compare Button-->
                                                </div>
                                                <!--End Product Button-->
                                                <!--Product Availability-->
                                                <div class="product-availability rounded-5">
                                                    <div class="lh-1 d-flex justify-content-between">
                                                        <div class="text-sold">Sold:<strong class="text-primary ms-1">34</strong></div>
                                                        <div class="text-available">Available:<strong class="text-primary ms-1">16</strong></div>
                                                    </div>
                                                    <div class="progress"><div class="progress-bar w-75" role="progressbar" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100"></div></div>
                                                </div>
                                                <!--End Product Availability-->
                                            </div>
                                            <!-- End Product Image -->
                                            <!-- Start Product Details -->
                                            <div class="product-details text-left">
                                                <!--Product Vendor-->
                                                <div class="product-vendor">Garden tool</div>
                                                <!--End Product Vendor-->
                                                <!-- Product Name -->
                                                <div class="product-name">
                                                    <a href="product-layout1.html">Gardening Forks Garden tool</a>
                                                </div>
                                                <!-- End Product Name -->
                                                <!-- Product Price -->
                                                <div class="product-price">
                                                    <span class="price old-price">$198.00</span><span class="price">$99.00</span>
                                                </div>
                                                <!-- End Product Price -->
                                                <!-- Product Review -->
                                                <div class="product-review">
                                                    <i class="icon anm anm-star-o"></i><i class="icon anm anm-star-o"></i><i class="icon anm anm-star-o"></i><i class="icon anm anm-star-o"></i><i class="icon anm anm-star-o"></i>
                                                    <span class="caption hidden ms-1">0 Reviews</span>
                                                </div>
                                                <!-- End Product Review -->
                                            </div>
                                            <!-- End product details -->
                                        </div>
                                    </div>
                                    <div class="item col-item">
                                        <div class="product-box">
                                            <!-- Start Product Image -->
                                            <div class="product-image">
                                                <!-- Start Product Image -->
                                                <a href="product-layout1.html" class="product-img">
                                                    <!-- Image -->
                                                    <img class="primary blur-up lazyload" data-src="assets/images/products/tools8.jpg" src="assets/images/products/tools8.jpg" alt="Product" title="Product" width="625" height="781" />
                                                    <!-- End Image -->
                                                    <!-- Hover Image -->
                                                    <img class="hover blur-up lazyload" data-src="assets/images/products/tools8-1.jpg" src="assets/images/products/tools8-1.jpg" alt="Product" title="Product" width="625" height="781" />
                                                    <!-- End Hover Image -->
                                                </a>
                                                <!-- End Product Image -->
                                                <!--Product Button-->
                                                <div class="button-set style2">
                                                    <!--Cart Button-->
                                                    <a href="#quickshop-modal" class="btn-icon addtocart quick-shop-modal" data-bs-toggle="modal" data-bs-target="#quickshop_modal">
                                                        <span class="icon-wrap d-flex-justify-center h-100 w-100" data-bs-toggle="tooltip" data-bs-placement="top" title="Select Options"><i class="icon anm anm-cart-l"></i><span class="text">Select Options</span></span>
                                                    </a>
                                                    <!--End Cart Button-->
                                                    <!--Quick View Button-->
                                                    <a href="#quickview-modal" class="btn-icon quickview quick-view-modal" data-bs-toggle="modal" data-bs-target="#quickview_modal">
                                                        <span class="icon-wrap d-flex-justify-center h-100 w-100" data-bs-toggle="tooltip" data-bs-placement="top" title="Quick View"><i class="icon anm anm-search-plus-l"></i><span class="text">Quick View</span></span>
                                                    </a>
                                                    <!--End Quick View Button-->
                                                    <!--Wishlist Button-->
                                                    <a href="wishlist-style2.html" class="btn-icon wishlist" data-bs-toggle="tooltip" data-bs-placement="top" title="Add To Wishlist"><i class="icon anm anm-heart-l"></i><span class="text">Add To Wishlist</span></a>
                                                    <!--End Wishlist Button-->
                                                    <!--Compare Button-->
                                                    <a href="compare-style2.html" class="btn-icon compare" data-bs-toggle="tooltip" data-bs-placement="top" title="Add to Compare"><i class="icon anm anm-random-r"></i><span class="text">Add to Compare</span></a>
                                                    <!--End Compare Button-->
                                                </div>
                                                <!--End Product Button-->
                                            </div>
                                            <!-- End Product Image -->
                                            <!-- Start Product Details -->
                                            <div class="product-details text-left">
                                                <!--Product Vendor-->
                                                <div class="product-vendor">Bosh</div>
                                                <!--End Product Vendor-->
                                                <!-- Product Name -->
                                                <div class="product-name">
                                                    <a href="product-layout1.html">Masonry trowel Hand tool</a>
                                                </div>
                                                <!-- End Product Name -->
                                                <!-- Product Price -->
                                                <div class="product-price">
                                                    <span class="price">$128.00</span>
                                                </div>
                                                <!-- End Product Price -->
                                                <!-- Product Review -->
                                                <div class="product-review">
                                                    <i class="icon anm anm-star"></i><i class="icon anm anm-star"></i><i class="icon anm anm-star"></i><i class="icon anm anm-star"></i><i class="icon anm anm-star"></i>
                                                    <span class="caption hidden ms-1">8 Reviews</span>
                                                </div>
                                                <!-- End Product Review -->
                                            </div>
                                            <!-- End product details -->
                                        </div>
                                    </div>
                                    <div class="item col-item">
                                        <div class="product-box">
                                            <!-- Start Product Image -->
                                            <div class="product-image">
                                                <!-- Start Product Image -->
                                                <a href="product-layout1.html" class="product-img">
                                                    <!-- Image -->
                                                    <img class="primary blur-up lazyload" data-src="assets/images/products/tools7.jpg" src="assets/images/products/tools7.jpg" alt="Product" title="Product" width="625" height="781" />
                                                    <!-- End Image -->
                                                    <!-- Hover Image -->
                                                    <img class="hover blur-up lazyload" data-src="assets/images/products/tools7-1.jpg" src="assets/images/products/tools7-1.jpg" alt="Product" title="Product" width="625" height="781" />
                                                    <!-- End Hover Image -->
                                                </a>
                                                <!-- End Product Image -->
                                                <!--Product Button-->
                                                <div class="button-set style2">
                                                    <!--Cart Button-->
                                                    <a href="#quickshop-modal" class="btn-icon addtocart quick-shop-modal" data-bs-toggle="modal" data-bs-target="#quickshop_modal">
                                                        <span class="icon-wrap d-flex-justify-center h-100 w-100" data-bs-toggle="tooltip" data-bs-placement="top" title="Select Options"><i class="icon anm anm-cart-l"></i><span class="text">Select Options</span></span>
                                                    </a>
                                                    <!--End Cart Button-->
                                                    <!--Quick View Button-->
                                                    <a href="#quickview-modal" class="btn-icon quickview quick-view-modal" data-bs-toggle="modal" data-bs-target="#quickview_modal">
                                                        <span class="icon-wrap d-flex-justify-center h-100 w-100" data-bs-toggle="tooltip" data-bs-placement="top" title="Quick View"><i class="icon anm anm-search-plus-l"></i><span class="text">Quick View</span></span>
                                                    </a>
                                                    <!--End Quick View Button-->
                                                    <!--Wishlist Button-->
                                                    <a href="wishlist-style2.html" class="btn-icon wishlist" data-bs-toggle="tooltip" data-bs-placement="top" title="Add To Wishlist"><i class="icon anm anm-heart-l"></i><span class="text">Add To Wishlist</span></a>
                                                    <!--End Wishlist Button-->
                                                    <!--Compare Button-->
                                                    <a href="compare-style2.html" class="btn-icon compare" data-bs-toggle="tooltip" data-bs-placement="top" title="Add to Compare"><i class="icon anm anm-random-r"></i><span class="text">Add to Compare</span></a>
                                                    <!--End Compare Button-->
                                                </div>
                                                <!--End Product Button-->
                                            </div>
                                            <!-- End Product Image -->
                                            <!-- Start Product Details -->
                                            <div class="product-details text-left">
                                                <!--Product Vendor-->
                                                <div class="product-vendor">Bosh</div>
                                                <!--End Product Vendor-->
                                                <!-- Product Name -->
                                                <div class="product-name">
                                                    <a href="product-layout1.html">Spanners Hand Tools Hex key</a>
                                                </div>
                                                <!-- End Product Name -->
                                                <!-- Product Price -->
                                                <div class="product-price">
                                                    <span class="price">$128.00</span>
                                                </div>
                                                <!-- End Product Price -->
                                                <!-- Product Review -->
                                                <div class="product-review">
                                                    <i class="icon anm anm-star"></i><i class="icon anm anm-star"></i><i class="icon anm anm-star"></i><i class="icon anm anm-star"></i><i class="icon anm anm-star"></i>
                                                    <span class="caption hidden ms-1">8 Reviews</span>
                                                </div>
                                                <!-- End Product Review -->
                                            </div>
                                            <!-- End product details -->
                                        </div>
                                    </div>
                                    <div class="item col-item">
                                        <div class="product-box">
                                            <!-- Start Product Image -->
                                            <div class="product-image">
                                                <a href="product-layout1.html" class="product-img">
                                                    <!-- Image -->
                                                    <img class="primary blur-up lazyload" data-src="assets/images/products/tools9.jpg" src="assets/images/products/tools9.jpg" alt="Product" title="Product" width="625" height="781" />
                                                    <!-- End Image -->
                                                    <!-- Hover Image -->
                                                    <img class="hover blur-up lazyload" data-src="assets/images/products/tools9-1.jpg" src="assets/images/products/tools9-1.jpg" alt="Product" title="Product" width="625" height="781" />
                                                    <!-- End Hover Image -->
                                                </a>
                                                <!--Product Button-->
                                                <div class="button-set style2">
                                                    <!--Cart Button-->
                                                    <a href="#quickshop-modal" class="btn-icon addtocart quick-shop-modal" data-bs-toggle="modal" data-bs-target="#quickshop_modal">
                                                        <span class="icon-wrap d-flex-justify-center h-100 w-100" data-bs-toggle="tooltip" data-bs-placement="top" title="Quick Shop"><i class="icon anm anm-cart-l"></i><span class="text">Quick Shop</span></span>
                                                    </a>
                                                    <!--End Cart Button-->
                                                    <!--Quick View Button-->
                                                    <a href="#quickview-modal" class="btn-icon quickview quick-view-modal" data-bs-toggle="modal" data-bs-target="#quickview_modal">
                                                        <span class="icon-wrap d-flex-justify-center h-100 w-100" data-bs-toggle="tooltip" data-bs-placement="top" title="Quick View"><i class="icon anm anm-search-plus-l"></i><span class="text">Quick View</span></span>
                                                    </a>
                                                    <!--End Quick View Button-->
                                                    <!--Wishlist Button-->
                                                    <a href="wishlist-style2.html" class="btn-icon wishlist" data-bs-toggle="tooltip" data-bs-placement="top" title="Add To Wishlist"><i class="icon anm anm-heart-l"></i><span class="text">Add To Wishlist</span></a>
                                                    <!--End Wishlist Button-->
                                                    <!--Compare Button-->
                                                    <a href="compare-style2.html" class="btn-icon compare" data-bs-toggle="tooltip" data-bs-placement="top" title="Add to Compare"><i class="icon anm anm-random-r"></i><span class="text">Add to Compare</span></a>
                                                    <!--End Compare Button-->
                                                </div>
                                                <!--End Product Button-->
                                            </div>
                                            <!-- End Product Image -->
                                            <!-- Start Product Details -->
                                            <div class="product-details text-left">
                                                <!--Product Vendor-->
                                                <div class="product-vendor">Tools</div>
                                                <!--End Product Vendor-->
                                                <!-- Product Name -->
                                                <div class="product-name">
                                                    <a href="product-layout1.html">Hand tool Electrician Tool Boxes</a>
                                                </div>
                                                <!-- End Product Name -->
                                                <!-- Product Price -->
                                                <div class="product-price">
                                                    <span class="price old-price">$299.00</span><span class="price">$199.00</span>
                                                </div>
                                                <!-- End Product Price -->
                                                <!-- Product Review -->
                                                <div class="product-review">
                                                    <i class="icon anm anm-star"></i><i class="icon anm anm-star"></i><i class="icon anm anm-star"></i><i class="icon anm anm-star"></i><i class="icon anm anm-star-o"></i>
                                                    <span class="caption hidden ms-1">8 Reviews</span>
                                                </div>
                                                <!-- End Product Review -->
                                            </div>
                                            <!-- End product details -->
                                        </div>
                                    </div>
                                    <div class="item col-item">
                                        <div class="product-box">
                                            <!-- Start Product Image -->
                                            <div class="product-image">
                                                <!-- Start Product Image -->
                                                <a href="product-layout1.html" class="product-img">
                                                    <!-- Image -->
                                                    <img class="primary blur-up lazyload" data-src="assets/images/products/tools10.jpg" src="assets/images/products/tools10.jpg" alt="Product" title="Product" width="625" height="781" />
                                                    <!-- End Image -->
                                                    <!-- Hover Image -->
                                                    <img class="hover blur-up lazyload" data-src="assets/images/products/tools10-1.jpg" src="assets/images/products/tools10-1.jpg" alt="Product" title="Product" width="625" height="781" />
                                                    <!-- End Hover Image -->
                                                </a>
                                                <!-- End Product Image -->
                                                <!--Product Button-->
                                                <div class="button-set style2">
                                                    <!--Cart Button-->
                                                    <a href="#quickshop-modal" class="btn-icon addtocart quick-shop-modal" data-bs-toggle="modal" data-bs-target="#quickshop_modal">
                                                        <span class="icon-wrap d-flex-justify-center h-100 w-100" data-bs-toggle="tooltip" data-bs-placement="top" title="Select Options"><i class="icon anm anm-cart-l"></i><span class="text">Select Options</span></span>
                                                    </a>
                                                    <!--End Cart Button-->
                                                    <!--Quick View Button-->
                                                    <a href="#quickview-modal" class="btn-icon quickview quick-view-modal" data-bs-toggle="modal" data-bs-target="#quickview_modal">
                                                        <span class="icon-wrap d-flex-justify-center h-100 w-100" data-bs-toggle="tooltip" data-bs-placement="top" title="Quick View"><i class="icon anm anm-search-plus-l"></i><span class="text">Quick View</span></span>
                                                    </a>
                                                    <!--End Quick View Button-->
                                                    <!--Wishlist Button-->
                                                    <a href="wishlist-style2.html" class="btn-icon wishlist" data-bs-toggle="tooltip" data-bs-placement="top" title="Add To Wishlist"><i class="icon anm anm-heart-l"></i><span class="text">Add To Wishlist</span></a>
                                                    <!--End Wishlist Button-->
                                                    <!--Compare Button-->
                                                    <a href="compare-style2.html" class="btn-icon compare" data-bs-toggle="tooltip" data-bs-placement="top" title="Add to Compare"><i class="icon anm anm-random-r"></i><span class="text">Add to Compare</span></a>
                                                    <!--End Compare Button-->
                                                </div>
                                                <!--End Product Button-->
                                            </div>
                                            <!-- End Product Image -->
                                            <!-- Start Product Details -->
                                            <div class="product-details text-left">
                                                <!--Product Vendor-->
                                                <div class="product-vendor">Gardening</div>
                                                <!--End Product Vendor-->
                                                <!-- Product Name -->
                                                <div class="product-name">
                                                    <a href="product-layout1.html">Pruning Shears Tool Gardening</a>
                                                </div>
                                                <!-- End Product Name -->
                                                <!-- Product Price -->
                                                <div class="product-price">
                                                    <span class="price">$128.00</span>
                                                </div>
                                                <!-- End Product Price -->
                                                <!-- Product Review -->
                                                <div class="product-review">
                                                    <i class="icon anm anm-star"></i><i class="icon anm anm-star"></i><i class="icon anm anm-star"></i><i class="icon anm anm-star"></i><i class="icon anm anm-star"></i>
                                                    <span class="caption hidden ms-1">8 Reviews</span>
                                                </div>
                                                <!-- End Product Review -->
                                            </div>
                                            <!-- End product details -->
                                        </div>
                                    </div>                                     
                                </div>

                                <div class="view-collection text-center mt-4 mt-md-5">
                                    <a href="shop-left-sidebar.html" class="btn btn-secondary btn-lg">View Collection</a>
                                </div>
                            </div>
                            <!--End Product Grid-->
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!--End Products With Tabs-->

        <!--Promo bar-->
        <section class="section pb-0">
            <div class="container">
                <div class="section-header d-none">
                    <h2>Promotion</h2>
                </div>

                <div class="top-info-bar style1 promoMsg">
                    <div class="topBar-slider-style1">
                        <div class="item text-center d-flex d-flex-justify-center">
                            Best Deals and Lowest Price on Top Brands&nbsp;:&nbsp;<b>Get 25% Flat Off on Tools</b>
                        </div>
                        <div class="item text-center d-flex d-flex-justify-center">
                            Leading&nbsp;<b>Hand Tools</b> &nbsp;Manufacturer. All Kinds Of&nbsp;<b>Safety Tools</b>&nbsp;Available.
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!--End Promo bar-->

        <!--Collection banner-->
        <section class="section collection-banners three-one-bnr">
            <div class="container">                      
                <div class="collection-banner-grid three-bnr">
                    <div class="row sp-row">
                        <div class="col-12 col-sm-12 col-md-5 col-lg-5 collection-banner-item">
                            <div class="collection-item sp-col">
                                <a href="shop-left-sidebar.html" class="zoom-scal clr-none">
                                    <div class="img">
                                        <img class="w-100 blur-up lazyload" data-src="assets/images/collection/demo5-ct-img1.jpg" src="assets/images/collection/demo5-ct-img1.jpg" alt="collection" title="" width="533" height="447" />
                                    </div>
                                    <div class="details middle-left">
                                        <div class="inner text-left">
                                            <h3 class="title">Construction <br>Tools</h3>
                                            <p class="counts">25 Products</p>
                                        </div>
                                    </div>
                                </a>
                            </div>                                
                        </div>
                        <div class="col-12 col-sm-12 col-md-2 col-lg-2 collection-banner-item">
                            <div class="collection-item sp-col h-100">
                                <a href="shop-left-sidebar.html" class="zoom-scal clr-none h-100">
                                    <div class="img h-100">
                                        <img class="w-100 h-100 blur-up lazyload" data-src="assets/images/collection/demo5-ct-img2.jpg" src="assets/images/collection/demo5-ct-img2.jpg" alt="collection" title="" width="533" height="447" />
                                    </div>
                                    <div class="details middle-center text-center d-flex-justify-center whiteText offerText w-100 h-100 p-0">
                                        <p class="tex-top text-uppercase m-0">Super Sale</p>
                                        <h3 class="pro-sale m-0"><span class="tex1 d-block">Get 40%</span><span class="tex2 d-block my-2 my-md-0">OFF</span><span class="tex3 d-block">All Products</span></h3>
                                        <p class="tex-bom m-0">Discount Code <span class="code fw-bold m-0 d-block text-uppercase">Hema40</span></p>
                                    </div>
                                </a>
                            </div>                                
                        </div>
                        <div class="col-12 col-sm-12 col-md-5 col-lg-5 collection-banner-item">
                            <div class="collection-item sp-col">
                                <a href="shop-left-sidebar.html" class="zoom-scal clr-none">
                                    <div class="img">
                                        <img class="w-100 blur-up lazyload" data-src="assets/images/collection/demo5-ct-img3.jpg" src="assets/images/collection/demo5-ct-img3.jpg" alt="collection" title="" width="533" height="447" />
                                    </div>
                                    <div class="details middle-right">
                                        <div class="inner text-left">
                                            <h3 class="title">Garden <br>Tools</h3>
                                            <p class="counts">12 Products</p>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!--End Collection banner-->

        <!--Popular Collection-->
        <section class="section collection-slider section-text section-clr">
            <div class="container">
                <div class="image-text-slider3items gp15 arwOut5 hov-arrow">
                    <div class="category-item zoomscal-hov">
                        <a href="shop-left-sidebar.html" class="category-link clr-none">
                            <div class="zoom-scal zoom-scal-nopb"><img class="blur-up lazyload" data-src="assets/images/collection/demo5-bnr1.jpg" src="assets/images/collection/demo5-bnr1.jpg" alt="collection" title="" width="420" height="460" /></div>
                            <div class="details mt-4 text-left">
                                <h4 class="category-title">Powerfull Hand Tools</h4>
                                <p class="dec">Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical.</p>
                                <span class="btn btn-secondary">Shop Now</span>
                            </div>
                        </a>
                    </div>
                    <div class="category-item zoomscal-hov">
                        <a href="shop-left-sidebar.html" class="category-link clr-none">
                            <div class="zoom-scal zoom-scal-nopb"><img class="blur-up lazyload" data-src="assets/images/collection/demo5-bnr2.jpg" src="assets/images/collection/demo5-bnr2.jpg" alt="collection" title="" width="420" height="460" /></div>
                            <div class="details mt-4 text-left">
                                <h4 class="category-title">Gardening Tools</h4>
                                <p class="dec">Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical.</p>
                                <span class="btn btn-secondary">Shop Now</span>
                            </div>
                        </a>
                    </div>
                    <div class="category-item zoomscal-hov">
                        <a href="shop-left-sidebar.html" class="category-link clr-none">
                            <div class="zoom-scal zoom-scal-nopb"><img class="blur-up lazyload" data-src="assets/images/collection/demo5-bnr3.jpg" src="assets/images/collection/demo5-bnr3.jpg" alt="collection" title="" width="420" height="460" /></div>
                            <div class="details mt-4 text-left">
                                <h4 class="category-title">Electronics Hand Tools</h4>
                                <p class="dec">Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical.</p>
                                <span class="btn btn-secondary">Shop Now</span>
                            </div>
                        </a>
                    </div>                           
                </div>
            </div>
        </section>
        <!--End Popular Collection-->

        <!--Blog Post-->
        <section class="section home-blog-post">
            <div class="container">
                <div class="section-header">
                    <h2>Latest from our Blog</h2>
                </div>

                <div class="blog-slider-3items blog-post-style2 gp15 arwOut5 hov-arrow">
                    <div class="blog-item">
                        <div class="blog-article zoomscal-hov bg-white">
                            <div class="blog-img">
                                <a class="featured-image zoom-scal m-0" href="blog-details.html"><img class="blur-up lazyload" data-src="assets/images/blog/demo5-post1.jpg" src="assets/images/blog/demo5-post1.jpg" alt="New shop collection our shop" width="740" height="410" /></a>
                            </div>
                            <div class="blog-content py-4 pb-0">
                                <ul class="publish-detail d-flex-wrap text-uppercase mb-2">                      
                                    <li><i class="icon anm anm-user-al"></i> <span>Mark Rogers</span></li>
                                    <li><i class="icon anm anm-calendar"></i> <time datetime="2023-02-14">Jan 02, 2023</time></li>
                                </ul>
                                <h2 class="h3 m-0 text-none"><a href="blog-details.html">New shop collection our shop</a></h2>                                                                                
                                <div class="blog-bottom d-flex-center justify-content-between mt-3">
                                    <a href="blog-details.html" class="text-link text-decoration-none text-uppercase">Read More<i class="icon anm anm-arw-right ms-2"></i></a>
                                    <a href="#" class="text-link text-decoration-none"><i class="icon anm anm-comments-l me-2"></i>12</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="blog-item">
                        <div class="blog-article zoomscal-hov bg-white">
                            <div class="blog-img">
                                <a class="featured-image zoom-scal m-0" href="blog-details.html"><img class="blur-up lazyload" data-src="assets/images/blog/demo5-post2.jpg" src="assets/images/blog/demo5-post2.jpg" alt="Gift ideas for everyone" width="740" height="410" /></a>
                            </div>
                            <div class="blog-content py-4 pb-0">
                                <ul class="publish-detail d-flex-wrap text-uppercase mb-2">                      
                                    <li><i class="icon anm anm-user-al"></i> <span>Mark Rogers</span></li>
                                    <li><i class="icon anm anm-calendar"></i> <time datetime="2023-02-14">Jan 24, 2023</time></li>
                                </ul>
                                <h2 class="h3 m-0 text-none"><a href="blog-details.html">Best gift ideas for everyone</a></h2>                                                                             
                                <div class="blog-bottom d-flex-center justify-content-between mt-3">
                                    <a href="blog-details.html" class="text-link text-decoration-none text-uppercase">Read More<i class="icon anm anm-arw-right ms-2"></i></a>
                                    <a href="#" class="text-link text-decoration-none"><i class="icon anm anm-comments-l me-2"></i>12</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="blog-item">
                        <div class="blog-article zoomscal-hov bg-white">
                            <div class="blog-img">
                                <a class="featured-image zoom-scal m-0" href="blog-details.html"><img class="blur-up lazyload" data-src="assets/images/blog/demo5-post3.jpg" src="assets/images/blog/demo5-post3.jpg" alt="Sales with best collection" width="740" height="410" /></a>
                            </div>
                            <div class="blog-content py-4 pb-0">
                                <ul class="publish-detail d-flex-wrap text-uppercase mb-2">                      
                                    <li><i class="icon anm anm-user-al"></i> <span>Mark Rogers</span></li>
                                    <li><i class="icon anm anm-calendar"></i> <time datetime="2023-02-14">Feb 14, 2023</time></li>
                                </ul>
                                <h2 class="h3 m-0 text-none"><a href="blog-details.html">Sales with best collection</a></h2>                                     
                                <div class="blog-bottom d-flex-center justify-content-between mt-3">
                                    <a href="blog-details.html" class="text-link text-decoration-none text-uppercase">Read More<i class="icon anm anm-arw-right ms-2"></i></a>
                                    <a href="#" class="text-link text-decoration-none"><i class="icon anm anm-comments-l me-2"></i>12</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!--End Blog Post-->

        <!--Service Section-->
        <section class="section service-section section-clr mt-m6">
            <div class="container">
                <div class="service-info text-center service-slider-5items gp15 arwOut5 slick-arrow-dots">
                    <div class="service-wrap">
                        <div class="service-icon mb-2 pb-1">
                            <i class="icon anm anm-check-badge-r"></i>
                        </div>
                        <div class="service-content">
                            <h3 class="fs-5 mb-2">Products Quality</h3>
                            <span class="text-muted">Comprehensive quality control and affordable prices</span>
                        </div>
                    </div>
                    <div class="service-wrap">
                        <div class="service-icon mb-2 pb-1">
                            <i class="icon anm anm-home-r"></i>
                        </div>
                        <div class="service-content">
                            <h3 class="fs-5 mb-2">Global Warehouse</h3>
                            <span class="text-muted">Shop from 20+ warehouses world wide.</span>
                        </div>
                    </div>
                    <div class="service-wrap">
                        <div class="service-icon mb-2 pb-1">
                            <i class="icon anm anm-truck-r"></i>
                        </div>
                        <div class="service-content">
                            <h3 class="fs-5 mb-2">Fast Shipping</h3>
                            <span class="text-muted">Fast and convenient door to door delivery</span>
                        </div>
                    </div>
                    <div class="service-wrap">
                        <div class="service-icon mb-2 pb-1">
                            <i class="icon anm anm-lock-ar"></i>
                        </div>
                        <div class="service-content">
                            <h3 class="fs-5 mb-2">Payment Security</h3>
                            <span class="text-muted">More than 8 different secure payment methods</span>
                        </div>
                    </div>
                    <div class="service-wrap">
                        <div class="service-icon mb-2 pb-1">
                            <i class="icon anm anm-phone-call-l"></i>
                        </div>
                        <div class="service-content">
                            <h3 class="fs-5 mb-2">Dedicated Support</h3>
                            <span class="text-muted">24/7 Customer Service - We're here & happy to help!</span>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!--End Service Section-->
    </div>
@endsection