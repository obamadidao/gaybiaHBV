@extends('layouts.client.ClientLayout')

@section('content')
<!--Page Header-->
<div class="page-header text-center">
    <div class="container">
        <div class="row">
            <div class="col-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-content-between align-items-center">
                <div class="page-title">
                    <h1>
                        @if ($category->parent)
                        <a href="{{ route('client.category', $category->parent->slug) }}" class="text-decoration-none">{{ $category->parent->name }}</a> >
                        @endif
                        {{ $category->name }}
                    </h1>
                </div>
                <!--Breadcrumbs-->
                <div class="breadcrumbs"><a href="{{ route('client.index') }}" title="Back to the home page">Trang chủ</a><span class="title"><i class="icon anm anm-angle-right-l"></i>Danh mục</span><span class="main-title"><i class="icon anm anm-angle-right-l"></i>{{ $category->name }}</span></div>
                <!--End Breadcrumbs-->
            </div>
        </div>
    </div>
</div>
<!--End Page Header-->

<!--Main Content-->
<div class="container">
    <!--Category Slider-->
    <div class="collection-slider-6items gp10 slick-arrow-dots sub-collection section pt-0">
        @foreach ($category->children as $child)
        <div class="category-item zoomscal-hov">
            <a href="{{ route('client.category', $child->slug) }}" class="category-link clr-none">
                <div class="zoom-scal zoom-scal-nopb rounded-0"><img class="rounded-0 blur-up lazyload" data-src="{{ $child->image ? asset('storage/' . $child->image) : asset('assets/images/collection/category.jpg') }}" src="{{ $child->image ? asset('storage/' . $child->image) : asset('assets/images/collection/category.jpg') }}" alt="{{ $child->name }}" title="{{ $child->name }}" width="365" height="365" /></div>
                <div class="details text-center">
                    <h4 class="category-title mb-0">{{ $child->name }}</h4>
                    <p class="counts">{{ $child->products->count() }} sản phẩm</p>
                </div>
            </a>
        </div>
        @endforeach
    </div>
    <!--End Category Slider-->

    <!--Toolbar-->
    <div class="toolbar toolbar-wrapper shop-toolbar">
        <div class="row align-items-center">
            <div class="col-4 col-sm-2 col-md-4 col-lg-4 text-left filters-toolbar-item d-flex order-1 order-sm-0">
                <div class="filters-item d-flex align-items-center">
                    <label class="mb-0 me-2 d-none d-lg-inline-block">Bố cục:</label>
                    <div class="grid-options view-mode d-flex">
                        <a class="icon-mode mode-grid grid-3 d-md-block" data-col="3"></a>
                        <a class="icon-mode mode-grid grid-4 d-lg-block" data-col="4"></a>
                        <a class="icon-mode mode-grid grid-5 d-xl-block active" data-col="5"></a>
                    </div>
                </div>
            </div>
            <div class="col-12 col-sm-4 col-md-4 col-lg-4 text-center product-count order-0 order-md-1 mb-3 mb-sm-0">
                <span class="toolbar-product-count">Showing: 15 products</span>
            </div>
            <div class="col-8 col-sm-6 col-md-4 col-lg-4 text-right filters-toolbar-item d-flex justify-content-end order-2 order-sm-2">
                <div class="filters-item d-flex align-items-center">
                    <label for="ShowBy" class="mb-0 me-2 text-nowrap d-none d-sm-inline-flex">Show:</label>
                    <select name="ShowBy" id="ShowBy" class="filters-toolbar-show">
                        <option value="title-ascending" selected="selected">10</option>
                        <option>15</option>
                        <option>20</option>
                        <option>25</option>
                        <option>30</option>
                    </select>
                </div>
                <div class="filters-item d-flex align-items-center ms-2 ms-lg-3">
                    <label for="SortBy" class="mb-0 me-2 text-nowrap d-none">Sắp xếp:</label>
                    <select name="SortBy" id="SortBy" class="filters-toolbar-sort">
                        <option value="featured" selected="selected">Mới nhất</option>
                        <option value="title-ascending">Giá tăng dần</option>
                        <option value="title-descending">Giá giảm dần</option>
                    </select>
                </div>
            </div>
        </div>
    </div>
    <!--End Toolbar-->

    <div class="row">
        <!--Products-->
        <div class="col-12 col-sm-12 col-md-12 col-lg-12 main-col">
            <!--Product Grid-->
            <div class="grid-products grid-view-items">
                <div class="row col-row product-options row-cols-xl-5 row-cols-lg-4 row-cols-md-3 row-cols-sm-3 row-cols-2">
                    @foreach ($products as $product)
                    <div class="item col-item">
                        <div class="product-box">
                            <!-- Start Product Image -->
                            <div class="product-image">
                                <!-- Start Product Image -->
                                <a href="product-layout1.html" class="product-img rounded-0"><img class="rounded-0 blur-up lazyload" src="assets/images/products/product1.jpg" alt="Product" title="Product" width="625" height="808" /></a>
                                <!-- End Product Image -->
                                <!-- Product label -->
                                <div class="product-labels"><span class="lbl on-sale">Sale</span></div>
                                <!-- End Product label -->
                                <!--Countdown Timer-->
                                <div class="saleTime" data-countdown="2025/01/01"></div>
                                <!--End Countdown Timer-->
                                <!--Product Button-->
                                <div class="button-set style1">
                                    <!--Cart Button-->
                                    <a href="#quickshop-modal" class="btn-icon addtocart quick-shop-modal" data-bs-toggle="modal" data-bs-target="#quickshop_modal">
                                        <span class="icon-wrap d-flex-justify-center h-100 w-100" data-bs-toggle="tooltip" data-bs-placement="left" title="Quick Shop"><i class="icon anm anm-cart-l"></i><span class="text">Quick Shop</span></span>
                                    </a>
                                    <!--End Cart Button-->
                                    <!--Quick View Button-->
                                    <a href="#quickview-modal" class="btn-icon quickview quick-view-modal" data-bs-toggle="modal" data-bs-target="#quickview_modal">
                                        <span class="icon-wrap d-flex-justify-center h-100 w-100" data-bs-toggle="tooltip" data-bs-placement="left" title="Quick View"><i class="icon anm anm-search-plus-l"></i><span class="text">Quick View</span></span>
                                    </a>
                                    <!--End Quick View Button-->
                                    <!--Wishlist Button-->
                                    <a href="wishlist-style2.html" class="btn-icon wishlist" data-bs-toggle="tooltip" data-bs-placement="left" title="Add To Wishlist"><i class="icon anm anm-heart-l"></i><span class="text">Add To Wishlist</span></a>
                                    <!--End Wishlist Button-->
                                    <!--Compare Button-->
                                    <a href="compare-style2.html" class="btn-icon compare" data-bs-toggle="tooltip" data-bs-placement="left" title="Add to Compare"><i class="icon anm anm-random-r"></i><span class="text">Add to Compare</span></a>
                                    <!--End Compare Button-->
                                </div>
                                <!--End Product Button-->
                            </div>
                            <!-- End Product Image -->
                            <!-- Start Product Details -->
                            <div class="product-details text-left">
                                <!--Product Vendor-->
                                <div class="product-vendor">Tops</div>
                                <!--End Product Vendor-->
                                <!-- Product Name -->
                                <div class="product-name">
                                    <a href="product-layout1.html">Oxford Cuban Shirt</a>
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
                                <!--Sort Description-->
                                <p class="sort-desc hidden">There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, or randomised words which don't look even slightly believable. If you are going to use a passage...</p>
                                <!--End Sort Description-->
                                <!--Color Variant -->
                                <ul class="variants-clr swatches">
                                    <li class="swatch medium radius"><span class="swatchLbl" data-bs-toggle="tooltip" data-bs-placement="top" title="Navy"><img src="assets/images/products/product1.jpg" alt="img" width="625" height="808"></span></li>
                                    <li class="swatch medium radius"><span class="swatchLbl" data-bs-toggle="tooltip" data-bs-placement="top" title="Green"><img src="assets/images/products/product1-1.jpg" alt="img" width="625" height="808"></span></li>
                                    <li class="swatch medium radius"><span class="swatchLbl" data-bs-toggle="tooltip" data-bs-placement="top" title="Gray"><img src="assets/images/products/product1-2.jpg" alt="img" width="625" height="808"></span></li>
                                    <li class="swatch medium radius"><span class="swatchLbl" data-bs-toggle="tooltip" data-bs-placement="top" title="Orange"><img src="assets/images/products/product1-3.jpg" alt="img" width="625" height="808"></span></li>
                                </ul>
                                <!-- End Variant -->
                                <!-- Product Button -->
                                <div class="button-action hidden">
                                    <div class="addtocart-btn">
                                        <form class="addtocart" action="#" method="post">
                                            <a href="#quickshop-modal" class="btn btn-md quick-shop quick-shop-modal" data-bs-toggle="modal" data-bs-target="#quickshop_modal">
                                                <i class="icon anm anm-cart-l me-2"></i><span class="text">Quick Shop</span>
                                            </a>
                                        </form>
                                    </div>
                                </div>
                                <!-- End Product Button -->
                            </div>
                            <!-- End product details -->
                        </div>
                    </div>
                    @endforeach
                </div>

                <!-- Pagination -->
                <nav class="clearfix pagination-bottom">
                    <ul class="pagination justify-content-center">
                        <li class="page-item disabled"><a class="page-link" href="#"><i class="icon anm anm-angle-left-l"></i></a></li>
                        <li class="page-item active"><a class="page-link" href="#">1</a></li>
                        <li class="page-item"><a class="page-link" href="#">2</a></li>
                        <li class="page-item"><a class="page-link dot" href="#">...</a></li>
                        <li class="page-item"><a class="page-link" href="#">5</a></li>
                        <li class="page-item"><a class="page-link" href="#"><i class="icon anm anm-angle-right-l"></i></a></li>
                    </ul>
                </nav>
                <!-- End Pagination -->
            </div>
            <!--End Product Grid-->
        </div>
        <!--End Products-->
    </div>
</div>
<!--End Main Content-->
@endsection