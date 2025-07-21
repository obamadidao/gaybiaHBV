@extends('layouts.client.ClientLayout')

@section('content')
<div id="page-content">               
<!--Home Slideshow-->
<section class="slideshow slideshow-wrapper">
<div class="home-slideshow slick-arrow-dots circle-dots">
@foreach($banners as $banner)
<div class="slide">
<div class="slideshow-wrap">
<a href="{{ $banner->link }}">
<picture>
<source media="(max-width:767px)" srcset="{{ asset('storage/' . $banner->image_url) }}" width="1100" height="700">
<img  src="{{ asset('storage/' . $banner->image_url) }}" alt="slideshow" title="" width="1920" height="700"/>
</picture>
</a>
</div>
</div>
@endforeach
</div>
</section>
<!--End Home Slideshow-->

<!--Popular Categories-->
<section class="section collection-slider section-clr cs_1">
<div class="container">
<div class="row align-items-center">
<div class="col-12 col-sm-12 col-md-12">
<div class="section-header">
<h2>Danh mục sản phẩm</h2>
</div>
</div>
<div class="col-12 col-sm-12 col-md-12">
<div class="collection-slider-4items gp15 arwOut5 hov-arrow dots-hide">
@foreach($cateRoot as $category)
<div class="category-item zoomscal-hov">
                                    <a href="#" class="category-link clr-none">
                                    <a href="{{ route('client.category', $category->slug) }}" class="category-link clr-none">
<div class="zoom-scal zoom-scal-nopb"><img style="min-height: 300px;" class="blur-up lazyload" data-src="{{ Storage::url($category->image) }}" src="{{ Storage::url($category->image) }}" alt="collection" title="" width="300" height="300" /></div>
<div class="details mt-3 text-center">
<h4 class="category-title mb-0">{{ $category->name }}</h4>
<p class="counts">{{ $category->all_products_count }} Sản phẩm</p>
</div>
</a>
</div>
@endforeach
</div>
</div>
</div>
</div>
</section>
<!--End Popular Categories-->

<!--Products With Tabs-->
<section class="section product-slider tab-slider-product pb-0">
<div class="container">
<div class="section-header">
<h2>Sản phẩm</h2>
<p>Đa dạng sản phẩm liên quan đến bida</p>
</div>

<div class="tabs-listing">
<ul class="nav nav-tabs style1 justify-content-center" id="productTabs" role="tablist">
<li class="nav-item" role="presentation">
<button class="nav-link head-font active" id="bestsellers-tab" data-bs-toggle="tab" data-bs-target="#bestsellers" type="button" role="tab" aria-controls="bestsellers" aria-selected="true">Mới nhất</button>
</li>
<li class="nav-item" role="presentation">
<button class="nav-link head-font" id="newarrivals-tab" data-bs-toggle="tab" data-bs-target="#newarrivals" type="button" role="tab" aria-controls="newarrivals" aria-selected="false">Giảm giá</button>
</li>
<li class="nav-item" role="presentation">
<button class="nav-link head-font" id="toprated-tab" data-bs-toggle="tab" data-bs-target="#toprated" type="button" role="tab" aria-controls="toprated" aria-selected="false">Nổi bật</button>
</li>
</ul>

<div class="tab-content" id="productTabsContent">
<div class="tab-pane show active" id="bestsellers" role="tabpanel" aria-labelledby="bestsellers-tab">
<!--Product Grid-->
<div class="grid-products grid-view-items">
<div class="row col-row product-options row-cols-xl-4 row-cols-lg-4 row-cols-md-3 row-cols-sm-3 row-cols-2">                                   
@foreach($newProducts as $product)
<div class="item col-item">
<div class="product-box">
<!-- Start Product Image -->
<div class="product-image">
<!-- Start Product Image -->
<a href="{{ route('client.product', $product->slug) }}" class="product-img"><img style="min-height: 300px;" class="blur-up lazyload" src="{{ $product->primaryImage->url }}" data-src="{{ $product->primaryImage->url }}" alt="Product" title="Product" width="625" height="781" /></a>
<!-- End Product Image -->
<!-- Product label -->
<div class="product-labels"><span class="lbl pr-label3">New</span></div>
<!-- End Product label -->
<!--Countdown Timer-->
{{-- <div class="saleTime" data-countdown="2025/01/01"></div> --}}
<!--End Countdown Timer-->
<!--Product Button-->
<div class="button-set style2">
<a href="{{ route('client.product', $product->slug) }}" class="btn btn-primary">Mua ngay</a>
</div>
<!--End Product Button-->
</div>
<!-- End Product Image -->
<!-- Start Product Details -->
<div class="product-details text-left">
<!--Product Vendor-->
<div class="product-vendor">{{$product->category->name}}</div>
<!--End Product Vendor-->
<!-- Product Name -->
<div class="product-name">
<a href="{{ route('client.product', $product->slug) }}">{{$product->name}}</a>
</div>
<!-- End Product Name -->
<!-- Product Price -->
<div class="product-price">
@if($product->base_price !== $product->compare_price)
<span class="price old-price">{{ $product->formatted_price }}</span><span class="price">{{ $product->formatted_compare_price }}</span>
@else
<span class="price">{{ $product->formatted_price }}</span>
@endif
</div>
<!-- End Product Price -->
<!-- Product Review -->
<div class="product-review">
@for($i = 0; $i < $product->stats['average_rating']; $i++)
<i class="icon anm anm-star"></i>
@endfor
@for($i = 0; $i < 5 - $product->stats['average_rating']; $i++)
<i class="icon anm anm-star-o"></i>
@endfor
<span class="caption hidden ms-1">{{ $product->stats['total'] }} Đánh giá</span>
</div>
<!-- End Product Review -->
</div>
<!-- End product details -->
</div>
</div>
@endforeach
</div>  
</div>
<!--End Product Grid-->
</div>

<div class="tab-pane" id="newarrivals" role="tabpanel" aria-labelledby="newarrivals-tab">
<!--Product Grid-->
<div class="grid-products grid-view-items">
<div class="row col-row product-options row-cols-xl-4 row-cols-lg-4 row-cols-md-3 row-cols-sm-3 row-cols-2">                                                                              
@foreach($saleProducts as $product)
<div class="item col-item">
<div class="product-box">
<!-- Start Product Image -->
<div class="product-image">
<!-- Start Product Image -->
<a href="{{ route('client.product', $product->slug) }}" class="product-img"><img style="min-height: 300px;" class="blur-up lazyload" src="{{ $product->primaryImage->url }}" data-src="{{ $product->primaryImage->url }}" alt="Product" title="Product" width="625" height="781" /></a>
<!-- End Product Image -->
<!-- Product label -->
<div class="product-labels"><span class="lbl pr-label3">Sale</span></div>
<!-- End Product label -->
<!--Countdown Timer-->
{{-- <div class="saleTime" data-countdown="2025/01/01"></div> --}}
<!--End Countdown Timer-->
<!--Product Button-->
<div class="button-set style2">
<a href="{{ route('client.product', $product->slug) }}" class="btn btn-primary">Mua ngay</a>
</div>
<!--End Product Button-->
</div>
<!-- End Product Image -->
<!-- Start Product Details -->
<div class="product-details text-left">
<!--Product Vendor-->
<div class="product-vendor">{{$product->category->name}}</div>
<!--End Product Vendor-->
<!-- Product Name -->
<div class="product-name">
<a href="{{ route('client.product', $product->slug) }}">{{$product->name}}</a>
</div>
<!-- End Product Name -->
<!-- Product Price -->
<div class="product-price">
@if($product->base_price !== $product->compare_price)
<span class="price old-price">{{ $product->formatted_price }}</span><span class="price">{{ $product->formatted_compare_price }}</span>
@else
<span class="price">{{ $product->formatted_price }}</span>
@endif
</div>
<!-- End Product Price -->
<!-- Product Review -->
<div class="product-review">
@for($i = 0; $i < $product->stats['average_rating']; $i++)
<i class="icon anm anm-star"></i>
@endfor
@for($i = 0; $i < 5 - $product->stats['average_rating']; $i++)
<i class="icon anm anm-star-o"></i>
@endfor
<span class="caption hidden ms-1">{{ $product->stats['total'] }} Đánh giá</span>
</div>
<!-- End Product Review -->
</div>
<!-- End product details -->
</div>
</div>
@endforeach
</div>
</div>
<!--End Product Grid-->
</div>

<div class="tab-pane" id="toprated" role="tabpanel" aria-labelledby="toprated-tab">
<!--Product Grid-->
<div class="grid-products grid-view-items">
<div class="row col-row product-options row-cols-xl-4 row-cols-lg-4 row-cols-md-3 row-cols-sm-3 row-cols-2">                                                                            
@foreach($featuredProducts as $product)
<div class="item col-item">
<div class="product-box">
<!-- Start Product Image -->
<div class="product-image">
<!-- Start Product Image -->
<a href="{{ route('client.product', $product->slug) }}" class="product-img"><img style="min-height: 300px;" class="blur-up lazyload" src="{{ $product->primaryImage->url }}" data-src="{{ $product->primaryImage->url }}" alt="Product" title="Product" width="625" height="781" /></a>
<!-- End Product Image -->
<!-- Product label -->
<div class="product-labels"><span class="lbl pr-label3">Hot</span></div>
<!-- End Product label -->
<!--Countdown Timer-->
{{-- <div class="saleTime" data-countdown="2025/01/01"></div> --}}
<!--End Countdown Timer-->
<!--Product Button-->
<div class="button-set style2">
<a href="{{ route('client.product', $product->slug) }}" class="btn btn-primary">Mua ngay</a>
</div>
<!--End Product Button-->
</div>
<!-- End Product Image -->
<!-- Start Product Details -->
<div class="product-details text-left">
<!--Product Vendor-->
<div class="product-vendor">{{$product->category->name}}</div>
<!--End Product Vendor-->
<!-- Product Name -->
<div class="product-name">
<a href="{{ route('client.product', $product->slug) }}">{{$product->name}}</a>
</div>
<!-- End Product Name -->
<!-- Product Price -->
<div class="product-price">
@if($product->base_price !== $product->compare_price)
<span class="price old-price">{{ $product->formatted_price }}</span><span class="price">{{ $product->formatted_compare_price }}</span>
@else
<span class="price">{{ $product->formatted_price }}</span>
@endif
</div>
<!-- End Product Price -->
<!-- Product Review -->
<div class="product-review">
@for($i = 0; $i < $product->stats['average_rating']; $i++)
<i class="icon anm anm-star"></i>
@endfor
@for($i = 0; $i < 5 - $product->stats['average_rating']; $i++)
<i class="icon anm anm-star-o"></i>
@endfor
<span class="caption hidden ms-1">{{ $product->stats['total'] }} Đánh giá</span>
</div>
<!-- End Product Review -->
</div>
<!-- End product details -->
</div>
</div>
@endforeach
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
<section class="section pb-0 mb-5">
<div class="container">
<div class="section-header">
<h2>Mã giảm giá</h2>
</div>

<div class="top-info-bar style1 promoMsg">
<div class="topBar-slider-style1">
@foreach($activeDiscounts as $discount)
<div class="item text-center d-flex d-flex-justify-center">
<p><strong>{{$discount->description}}</strong> hãy nhập mã <span class="text-danger"><strong onclick="copyToClipboard('{{ $discount->code }}')" style="cursor:pointer" title="Click để sao chép">{{ $discount->code }}</strong></span></p>
<script>
                               function copyToClipboard(text) {
                                   navigator.clipboard.writeText(text);
                                   alert('Đã sao chép mã: ' + text);
                               }
                               </script>
</div>
@endforeach
</div>
</div>
</div>
</section>
<!--End Promo bar-->

<!--Service Section-->
<section class="section service-section section-clr mt-m6">
<div class="container">
<div class="service-info text-center service-slider-5items gp15 arwOut5 slick-arrow-dots">
<div class="service-wrap">
<div class="service-icon mb-2 pb-1">
<i class="icon anm anm-check-badge-r"></i>
</div>
<div class="service-content">
<h3 class="fs-5 mb-2">Chất lượng sản phẩm</h3>
<span class="text-muted">Kiểm soát chất lượng toàn diện và giá cả phải chăng</span>
</div>
</div>
<div class="service-wrap">
<div class="service-icon mb-2 pb-1">
<i class="icon anm anm-home-r"></i>
</div>
<div class="service-content">
<h3 class="fs-5 mb-2">Kho hàng toàn quốc</h3>
<span class="text-muted">Mua sắm từ hơn 20 kho hàng trên toàn quốc</span>
</div>
</div>
<div class="service-wrap">
<div class="service-icon mb-2 pb-1">
<i class="icon anm anm-truck-r"></i>
</div>
<div class="service-content">
<h3 class="fs-5 mb-2">Giao hàng nhanh</h3>
<span class="text-muted">Giao hàng tận nơi nhanh chóng và thuận tiện</span>
</div>
</div>
<div class="service-wrap">
<div class="service-icon mb-2 pb-1">
<i class="icon anm anm-lock-ar"></i>
</div>
<div class="service-content">
<h3 class="fs-5 mb-2">Thanh toán an toàn</h3>
<span class="text-muted">Hơn 8 phương thức thanh toán an toàn khác nhau</span>
</div>
</div>
<div class="service-wrap">
<div class="service-icon mb-2 pb-1">
<i class="icon anm anm-phone-call-l"></i>
</div>
<div class="service-content">
<h3 class="fs-5 mb-2">Hỗ trợ tận tâm</h3>
<span class="text-muted">Dịch vụ khách hàng 24/7 - Chúng tôi luôn sẵn sàng hỗ trợ!</span>
</div>
</div>
</div>
</div>
</section>
<!--End Service Section-->
</div>