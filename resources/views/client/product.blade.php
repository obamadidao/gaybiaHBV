@extends('layouts.client.ClientLayout')

@section('content')
<!--Page Header-->
<div class="page-header text-center">
<div class="container">
<div class="row">
<div class="col-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-content-between align-items-center">
<div class="page-title"><h1>
{{ $product->name }}
</h1></div>
<!--Breadcrumbs-->
<div class="breadcrumbs"><a href="{{ route('client.index') }}" title="Back to the home page">Trang chủ</a><span class="title"><i class="icon anm anm-angle-right-l"></i>Sản phẩm</span><span class="main-title"><i class="icon anm anm-angle-right-l"></i>{{ $product->name }}</span></div>
<!--End Breadcrumbs-->
</div>
</div>
</div>
</div>
<!--End Page Header-->

<!--Main Content-->
<div class="container">     
<!--Product Content-->
<div class="product-single">
<div class="row">
<div class="col-lg-6 col-md-6 col-sm-12 col-12 product-layout-img mb-4 mb-md-0">
<!-- Product Horizontal -->
<div class="product-details-img product-horizontal-style">
<!-- Product Main -->
<div class="zoompro-wrap">
<!-- Product Image -->
@php $primaryImage = $product->images->where('is_primary', 1)->first() ?? $product->images->first() @endphp
<div class="zoompro-span">
<img id="zoompro" class="zoompro" 
src="{{ $primaryImage ? $primaryImage->url : asset('assets/images/collection/category.jpg') }}" 
data-zoom-image="{{ $primaryImage ? $primaryImage->url : asset('assets/images/collection/category.jpg') }}" 
alt="{{ $product->name }}" width="625" height="808" />
</div>
<!-- End Product Image -->
<!-- Product Label -->
<div class="product-labels">
                                @php
                                    $availableQuantity = $product->track_quantity ? max(0, $product->stock_quantity - $quantityInCart) : PHP_INT_MAX;
                                    $isLowStock = $product->track_quantity && $availableQuantity <= $product->low_stock_threshold && $availableQuantity > 0;
                                @endphp
@if($product->compare_price && $product->base_price < $product->compare_price)
<span class="lbl on-sale">
-{{ round((($product->compare_price - $product->base_price) / $product->compare_price) * 100) }}%
</span>
@endif
@if($product->is_featured)
<span class="lbl pr-label2">HOT</span>
@endif
                                @if($product->stock_quantity <= 0 && $product->track_quantity)
                                @if($availableQuantity <= 0 && $product->track_quantity)
<span class="lbl soldout">Hết hàng</span>
                                @elseif($product->isLowStock())
                                @elseif($isLowStock)
<span class="lbl pr-label1">Sắp hết</span>
@endif
</div>
<!-- End Product Label -->

</div>
<!-- End Product Main -->

<!-- Product Thumb -->
<div class="product-thumb product-horizontal-thumb mt-3">
<div id="gallery" class="product-thumb-horizontal">
@foreach ($product->images as $index => $image)
<a data-image="{{ $image->url }}" 
data-zoom-image="{{ $image->url }}" 
class="slick-slide slick-cloned {{ $index === 0 ? 'active' : '' }}">
<img style="min-height: 120px"  class="blur-up lazyload" 
data-src="{{ $image->url }}" 
src="{{ $image->url }}" 
alt="{{ $image->alt ?? $product->name }}" 
width="625" height="808" />
</a>
@endforeach
</div>
</div>
<!-- End Product Thumb -->

<!-- Product Gallery -->
<div class="lightboximages">
@foreach ($product->images as $image)
<a href="{{ $image->url }}" data-size="1000x1280"></a>
@endforeach
</div>
<!-- End Product Gallery -->
</div>
<!-- End Product Horizontal -->
</div>

<div class="col-lg-6 col-md-6 col-sm-12 col-12 product-layout-info">
<!-- Product Details -->
<div class="product-single-meta">
                        <h2 class="product-main-title">{{ $product->name }}</h2>
                        <h2 class="product-main-title">{{ $product->name }} <small class="text-muted">({{ $availableQuantity }})</small></h2>
<!-- Product Reviews -->
<div class="product-review d-flex-center mb-2">
<div class="reviewStar d-flex-center">
@for ($i = 1; $i <= 5; $i++)
@if ($i <= $reviewStats['average_rating'])
<i class="icon anm anm-star"></i>
@else
<i class="icon anm anm-star-o"></i>
@endif
@endfor
<span class="caption ms-2">{{ $reviewStats['approved'] }} đánh giá</span>
</div>
</div>
<!-- End Product Reviews -->                                    
<!-- Product Price -->
<div class="product-price d-flex-center my-3">
@if($product->compare_price && $product->base_price < $product->compare_price)
<span class="price old-price">{{ number_format($product->compare_price, 0, ',', '.') }}đ</span>
<span class="price">{{ number_format($product->base_price, 0, ',', '.') }}đ</span>
<span class="discount-badge">
<span class="devider mx-2">|</span>
<span>Tiết kiệm: </span>
<span class="save-amount">
<b class="money text-primary">{{ number_format($product->compare_price - $product->base_price, 0, ',', '.') }}đ</b>
</span>
<span class="off ms-1">
({{ round((($product->compare_price - $product->base_price) / $product->compare_price) * 100) }}%)
</span>
</span>
@else
<span class="price">{{ number_format($product->base_price, 0, ',', '.') }}đ</span>
@endif
</div>
<!-- End Product Price -->
<!-- Sort Description -->
<div class="sort-description">
@if($product->short_description)
<p>{{ $product->short_description }}</p>
@endif
</div>
                        <!-- End Sort Description -->
</div>
<!-- End Product Details -->

<!-- Product Form -->
<form method="post" action="{{ route('client.cart.add') }}" class="product-form product-form-border hidedropdown" id="add-to-cart-form"> 
@csrf
<input type="hidden" name="product_id" value="{{ $product->id }}">
<!-- Swatches -->
@if($variantsByType->count() > 0)
<div class="product-swatches-option">
@foreach($variantsByType as $variantType => $variants)
<div class="product-item swatches-option w-100 mb-4" data-option-index="{{ $loop->index }}">
                                <label class="label d-flex align-items-center">
                                    {{ $variants->first()->variant_type_name }}:
                                    <span class="slVariant ms-1 fw-bold" id="selected-{{ $variantType }}">{{ $variants->first()->variant_value }}</span>
                                    <span class="price-adjustment ms-2" id="price-adjustment-{{ $variantType }}">
                                        @if($variants->first()->price_adjustment > 0)
                                            (+{{ number_format($variants->first()->price_adjustment, 0, ',', '.') }}đ)
                                        @elseif($variants->first()->price_adjustment < 0) 
                                            (-{{ number_format(abs($variants->first()->price_adjustment), 0, ',', '.') }}đ)
                                        @endif
                                    </span>
                                <label class="label d-flex align-items-center justify-content-between">
                                    <div class="variant-info">
                                        {{ $variants->first()->variant_type_name }}:
                                        <span class="slVariant ms-1 fw-bold" id="selected-{{ $variantType }}">{{ $variants->first()->variant_value }}</span>
                                        <span class="price-adjustment ms-2" id="price-adjustment-{{ $variantType }}">
                                            @if($variants->first()->price_adjustment > 0)
                                                (+{{ number_format($variants->first()->price_adjustment, 0, ',', '.') }}đ)
                                            @elseif($variants->first()->price_adjustment < 0) 
                                                (-{{ number_format(abs($variants->first()->price_adjustment), 0, ',', '.') }}đ)
                                            @endif
                                        </span>
                                    </div>
                                    @if($product->track_quantity)
                                    <div class="variant-stock-info">
                                        <small class="text-muted">
                                            Kho: <span class="fw-bold text-info" id="variant-stock-{{ $variantType }}">{{ $variants->first()->stock_quantity }}</span>
                                            | Trong giỏ: <span class="fw-bold text-warning" id="variant-cart-{{ $variantType }}">0</span>
                                            | Có thể mua: <span class="fw-bold text-success" id="variant-available-{{ $variantType }}">{{ $variants->first()->stock_quantity }}</span>
                                        </small>
                                    </div>
                                    @endif
</label>

@if(in_array(strtolower($variantType), ['color', 'colour', 'mau', 'màu']))
{{-- Color Swatches --}}
<ul class="variants-clr swatches d-flex-center pt-1 clearfix">
@foreach($variants as $variant)
<li class="swatch x-large radius {{ $variant->stock_quantity > 0 ? 'available' : 'soldout' }} {{ $loop->first ? 'active' : '' }}" 
data-variant-id="{{ $variant->id }}" 
data-variant-value="{{ $variant->variant_value }}"
data-price-adjustment="{{ $variant->price_adjustment }}"
data-stock="{{ $variant->stock_quantity }}"
onclick="updateVariantInfo('{{ $variantType }}', '{{ $variant->variant_value }}', {{ $variant->price_adjustment }})">
<span class="swatchLbl" 
data-bs-toggle="tooltip" 
data-bs-placement="top" 
                                                      title="{{ $variant->variant_value }}">{{ $variant->variant_value }}</span>
                                                      title="{{ $variant->variant_value }} - Kho: {{ $variant->stock_quantity }}, Có thể mua: {{ $variant->stock_quantity }}">
                                                      {{ $variant->variant_value }}
                                                      <small class="d-block text-center mt-1">
                                                          @if($variant->stock_quantity <= 0)
                                                              (<span class="text-danger">Hết</span>)
                                                          @elseif($variant->stock_quantity <= 5)
                                                              (<span class="text-warning">{{ $variant->stock_quantity }}</span>)
                                                          @else
                                                              (<span class="text-success">{{ $variant->stock_quantity }}</span>)
                                                          @endif
                                                      </small>
                                                </span>
</li>
@endforeach
</ul>
@else
{{-- Size/Text Swatches --}}
<ul class="variants-size size-swatches d-flex-center pt-1 clearfix">
@foreach($variants as $variant)
<li class="swatch x-large radius {{ $variant->stock_quantity > 0 ? 'available' : 'soldout' }} {{ $loop->first ? 'active' : '' }}"
data-variant-id="{{ $variant->id }}" 
data-variant-value="{{ $variant->variant_value }}"
data-price-adjustment="{{ $variant->price_adjustment }}"
data-stock="{{ $variant->stock_quantity }}"
onclick="updateVariantInfo('{{ $variantType }}', '{{ $variant->variant_value }}', {{ $variant->price_adjustment }})">
<span class="swatchLbl" 
data-bs-toggle="tooltip" 
data-bs-placement="top" 
                                                      title="{{ $variant->variant_value }}">{{ $variant->variant_value }}</span>
                                                      title="{{ $variant->variant_value }} - Kho: {{ $variant->stock_quantity }}, Có thể mua: {{ $variant->stock_quantity }}">
                                                      {{ $variant->variant_value }}
                                                      <small class="d-block text-center mt-1">
                                                          @if($variant->stock_quantity <= 0)
                                                              (<span class="text-danger">Hết</span>)
                                                          @elseif($variant->stock_quantity <= 5)
                                                              (<span class="text-warning">{{ $variant->stock_quantity }}</span>)
                                                          @else
                                                              (<span class="text-success">{{ $variant->stock_quantity }}</span>)    
                                                          @endif
                                                      </small>
                                                </span>
</li>
@endforeach
</ul>
@endif
</div>
@endforeach
</div>                                 
@endif
<!-- End Swatches -->

<!-- Product Action -->
<div class="product-action w-100 d-flex-wrap mb-3">
<!-- Product Quantity -->
<div class="product-form-quantity w-100 d-flex-center">
<div class="qtyField">
<a class="qtyBtn minus" href="#;"><i class="icon anm anm-minus-r"></i></a>
<input type="text" name="quantity" value="1" class="product-form-input qty" />
<a class="qtyBtn plus" href="#;"><i class="icon anm anm-plus-r"></i></a>
</div>

<div class="pro-stockLbl ms-3">
@if($product->track_quantity)
                                        @if($product->stock_quantity <= 0)
                                        @if($availableQuantity <= 0)
<span class="d-flex-center stockLbl outstock text-uppercase text-danger">
<i class="icon anm anm-times-cil"></i> Hết hàng
                                                @if($quantityInCart > 0)
                                                    <small class="ms-1">({{ $quantityInCart }} trong giỏ)</small>
                                                @endif
</span>
                                        @elseif($product->isLowStock())
                                        @elseif($isLowStock)
<span class="d-flex-center stockLbl lowstock text-uppercase text-warning">
                                                <i class="icon anm anm-exclamation-cil"></i> Sắp hết ({{ $product->stock_quantity }} còn lại)
                                                <i class="icon anm anm-exclamation-cil"></i> Sắp hết ({{ $availableQuantity }} còn lại)
                                                @if($quantityInCart > 0)
                                                    <small class="ms-1">({{ $quantityInCart }} trong giỏ)</small>
                                                @endif
</span>
@else
<span class="d-flex-center stockLbl instock text-uppercase text-success">
                                                <i class="icon anm anm-check-cil"></i> Còn hàng ({{ $product->stock_quantity }})
                                                <i class="icon anm anm-check-cil"></i> Còn hàng ({{ $availableQuantity }})
                                                @if($quantityInCart > 0)
                                                    <small class="ms-1">({{ $quantityInCart }} trong giỏ)</small>
                                                @endif
</span>
@endif
@else
<span class="d-flex-center stockLbl instock text-uppercase text-success">
<i class="icon anm anm-check-cil"></i> Luôn có sẵn
                                            @if($quantityInCart > 0)
                                                <small class="ms-1">({{ $quantityInCart }} trong giỏ)</small>
                                            @endif
</span>
@endif
</div>
</div>
<!-- End Product Quantity -->

<!-- Product Add -->
<div class="product-form-submit addcart fl-1 ms-0 mt-3">
<button type="submit" name="add" class="btn btn-secondary product-form-cart-submit" id="add-to-cart-btn">
<span>Thêm vào giỏ hàng</span>
</button>
</div>
<!-- Product Add -->
</div>
<!-- End Product Action -->


</form>
<!-- End Product Form -->

<!-- Product Info -->
<div class="product-info">
@if($product->brand)
<p class="product-vendor">Thương hiệu: <span class="text">{{ $product->brand }}</span></p>  
@endif
@if($product->model)
<p class="product-type">Mẫu: <span class="text">{{ $product->model }}</span></p> 
@endif
<p class="product-sku">SKU: <span class="text">{{ $product->sku }}</span></p>
<p class="product-cat">Danh mục: <span><a href="{{ route('client.category', $product->category->slug) }}">{{ $product->category->name }}</a></span></p>
@if($product->material)
<p class="product-material">Chất liệu: <span class="text">{{ $product->material }}</span></p>
@endif
@if($product->weight || $product->length || $product->width || $product->height)
<p class="product-dimensions mb-3">
Kích thước: 
<span class="text">
@if($product->length) {{ $product->length }}cm @endif
@if($product->width) x {{ $product->width }}cm @endif  
@if($product->height) x {{ $product->height }}cm @endif
@if($product->weight) - {{ $product->weight }}g @endif
</span>
</p>
@endif
</div>
<!-- End Product Info -->


<!-- Social Sharing -->
<div class="social-sharing d-flex-center mt-2 lh-lg">
<span class="sharing-lbl fw-600">Share :</span>
<a href="#" class="d-flex-center btn btn-link btn--share share-facebook"><i class="icon anm anm-facebook-f"></i><span class="share-title">Facebook</span></a>
<a href="#" class="d-flex-center btn btn-link btn--share share-twitter"><i class="icon anm anm-twitter"></i><span class="share-title">Tweet</span></a>
<a href="#" class="d-flex-center btn btn-link btn--share share-pinterest"><i class="icon anm anm-pinterest-p"></i> <span class="share-title">Pin it</span></a>
<a href="#" class="d-flex-center btn btn-link btn--share share-linkedin"><i class="icon anm anm-linkedin-in"></i><span class="share-title">Linkedin</span></a>
<a href="#" class="d-flex-center btn btn-link btn--share share-email"><i class="icon anm anm-envelope-l"></i><span class="share-title">Email</span></a>
</div>
<!-- End Social Sharing -->
</div>
</div>
</div>
<!--Product Content-->

<!--Product Tabs-->
<div class="tabs-listing section pb-0 mb-4">
<ul class="product-tabs style2 list-unstyled d-flex-wrap d-flex-justify-center d-none d-md-flex">
<li rel="additionalInformation" class="active"><a class="tablink">Thông tin bổ sung</a></li>
<li rel="shipping-return"><a class="tablink">Vận chuyển &amp; Đổi trả</a></li>
<li rel="reviews"><a class="tablink">Đánh giá ({{ $reviewStats['approved'] }})</a></li>
</ul>

<div class="tab-container">
<!--Additional Information-->
<h3 class="tabs-ac-style d-md-none" rel="additionalInformation">Thông tin bổ sung</h3>
<div id="additionalInformation" class="tab-content">
<div class="product-description">
<div class="row">
<div class="col-12 col-sm-12 col-md-12 col-lg-12 mb-4 mb-md-0">
<div class="table-responsive">
<table class="table table-bordered align-middle table-part mb-0">
<tr>
<th>SKU</th>
<td>{{ $product->sku }}</td>
</tr>
<tr>
<th>Danh mục</th>
<td>{{ $product->category->name }}</td>
</tr>
@if($product->brand)
<tr>
<th>Thương hiệu</th>
<td>{{ $product->brand }}</td>
</tr>
@endif
@if($product->model)
<tr>
<th>Mẫu</th>
<td>{{ $product->model }}</td>
</tr>
@endif
@if($product->material)
<tr>
<th>Chất liệu</th>
<td>{{ $product->material }}</td>
</tr>
@endif
@if($product->weight || $product->length || $product->width || $product->height)
<tr>
<th>Kích thước & Trọng lượng</th>
<td>
@if($product->length || $product->width || $product->height)
{{ $product->length }}L x {{ $product->width }}W x {{ $product->height }}H cm
@endif
@if($product->weight)
@if($product->length || $product->width || $product->height); @endif
{{ $product->weight }} gram
@endif
</td>
</tr>
@endif
<tr>
<th>Ngày tạo</th>
<td>{{ $product->created_at->format('d/m/Y') }}</td>
</tr>
<tr>
<th>Tình trạng kho</th>
<td>
@if($product->track_quantity)
                                                    @if($product->stock_quantity <= 0)
                                                    @if($availableQuantity <= 0)
<span class="text-danger">Hết hàng</span>
                                                    @elseif($product->isLowStock())
                                                        <span class="text-warning">Sắp hết ({{ $product->stock_quantity }} còn lại)</span>
                                                        @if($quantityInCart > 0)
                                                            <small class="text-muted"> ({{ $quantityInCart }} trong giỏ)</small>
                                                        @endif
                                                    @elseif($isLowStock)
                                                        <span class="text-warning">Sắp hết ({{ $availableQuantity }} còn lại)</span>
                                                        @if($quantityInCart > 0)
                                                            <small class="text-muted"> ({{ $quantityInCart }} trong giỏ)</small>
                                                        @endif
@else
                                                        <span class="text-success">Còn hàng ({{ $product->stock_quantity }})</span>
                                                        <span class="text-success">Còn hàng ({{ $availableQuantity }})</span>
                                                        @if($quantityInCart > 0)
                                                            <small class="text-muted"> ({{ $quantityInCart }} trong giỏ)</small>
                                                        @endif
@endif
@else
<span class="text-info">Luôn có sẵn</span>
                                                    @if($quantityInCart > 0)
                                                        <small class="text-muted"> ({{ $quantityInCart }} trong giỏ)</small>
                                                    @endif
@endif
</td>
</tr>
</table>
</div>
</div>
</div>
</div>
</div>
<!--End Additional Information-->



<!--Shipping &amp; Return-->
<h3 class="tabs-ac-style d-md-none" rel="shipping-return">Vận chuyển &amp; Đổi trả</h3>
<div id="shipping-return" class="tab-content">
<h4 class="pb-1">Chính sách vận chuyển</h4>
<ul class="checkmark-info">
<li>Giao hàng: Trong vòng 24 giờ</li>
<li>Bảo hành chính hãng theo quy định</li>
<li>Miễn phí vận chuyển cho đơn hàng từ 500.000đ</li>
<li>Thời gian giao hàng: 2-7 ngày làm việc</li>
<li>Hỗ trợ thanh toán khi nhận hàng (COD)</li>
<li>Đổi trả dễ dàng trong 30 ngày</li>
@if($product->is_digital)
<li><strong>Sản phẩm số:</strong> Giao hàng ngay lập tức qua email</li>
@endif
</ul>
<h4 class="pt-1">Chính sách đổi trả</h4>
<p>Chúng tôi chấp nhận đổi trả trong vòng 30 ngày kể từ ngày mua hàng. Sản phẩm phải còn nguyên vẹn, chưa sử dụng và có đầy đủ bao bì, phụ kiện kèm theo. Khách hàng vui lòng liên hệ bộ phận chăm sóc khách hàng để được hướng dẫn chi tiết.</p>
<h4 class="pt-1">Hỗ trợ khách hàng</h4>
<p>Đội ngũ hỗ trợ khách hàng của chúng tôi luôn sẵn sàng giải đáp mọi thắc mắc về sản phẩm, đơn hàng và chính sách. Liên hệ hotline: 1900-xxxx hoặc email: support@example.com để được hỗ trợ nhanh nhất.</p>
</div>
<!--End Shipping &amp; Return-->

<!--Review-->
<h3 class="tabs-ac-style d-md-none" rel="reviews">Đánh giá</h3>
<div id="reviews" class="tab-content">
<div class="row">
<div class="col-12 col-sm-12 col-md-12 col-lg-6 mb-4">
<div class="ratings-main">
<div class="avg-rating d-flex-center mb-3">
<h4 class="avg-mark">{{ number_format($reviewStats['average_rating'], 1) }}</h4>
<div class="avg-content ms-3">
<p class="text-rating">Đánh giá trung bình</p>
<div class="ratings-full product-review">
<div class="reviewLink d-flex-center">
@for ($i = 1; $i <= 5; $i++)
@if ($i <= $reviewStats['average_rating'])
<i class="icon anm anm-star"></i>
@else
<i class="icon anm anm-star-o"></i>
@endif
@endfor
<span class="caption ms-2">{{ $reviewStats['approved'] }} đánh giá</span>
</div>
</div>
</div>
</div>

@if($reviewStats['approved'] > 0)
<div class="ratings-list">
@for($i = 5; $i >= 1; $i--)
<div class="ratings-container d-flex align-items-center mt-1">
<div class="ratings-full product-review m-0">
<div class="reviewLink d-flex align-items-center">
@for($j = 1; $j <= 5; $j++)
@if($j <= $i)
<i class="icon anm anm-star"></i>
@else
<i class="icon anm anm-star-o"></i>
@endif
@endfor
</div>
</div>
<div class="progress">
<div class="progress-bar" role="progressbar" 
aria-valuenow="{{ $reviewStats['rating_breakdown'][$i]['percentage'] }}" 
aria-valuemin="0" aria-valuemax="100" 
style="width:{{ $reviewStats['rating_breakdown'][$i]['percentage'] }}%;"></div>
</div>
<div class="progress-value">{{ $reviewStats['rating_breakdown'][$i]['percentage'] }}%</div>
</div>
@endfor
</div>
@else
<p class="text-center text-muted">Chưa có đánh giá nào cho sản phẩm này.</p>
@endif
</div>
<hr />
<div class="spr-reviews">
<h3 class="spr-form-title">Đánh giá của khách hàng</h3>
<div class="review-inner">
@foreach($product->approvedReviews as $review)
<div class="spr-review d-flex w-100">
<div class="spr-review-profile flex-shrink-0">
<img class="blur-up lazyload" data-src="{{ $review->user->avatar ? $review->user->avatar : asset('assets/images/users/user-img1.jpg') }}" src="{{ $review->user->avatar ? $review->user->avatar : asset('assets/images/users/user-img1.jpg') }}" alt="" width="200" height="200" />
</div>
<div class="spr-review-content flex-grow-1">
<div class="d-flex justify-content-between flex-column mb-2">
<div class="title-review d-flex align-items-center justify-content-between">
<h5 class="spr-review-header-title text-transform-none mb-0">{{ $review->user->name }}</h5>
<span class="product-review spr-starratings m-0"><span class="reviewLink">
@for($i = 1; $i <= 5; $i++)
@if($i <= $review->rating)
<i class="icon anm anm-star"></i>
@else
<i class="icon anm anm-star-o"></i>
@endif
@endfor
</span></span>
</div>
</div>
<b class="head-font">{{ $review->title }}</b>
<p class="spr-review-body">{{ $review->content }}</p>
</div>
</div>
@endforeach
</div>
</div>
</div>

<div class="col-12 col-sm-12 col-md-12 col-lg-6 mb-4">
                            <form method="post" action="#" class="product-review-form new-review-form">
                                <h3 class="spr-form-title">Write a Review</h3>
                                <p>Your email address will not be published. Required fields are marked *</p>
                                <fieldset class="row spr-form-contact">
                                    <div class="col-sm-6 spr-form-contact-name form-group">
                                        <label class="spr-form-label" for="nickname">Name <span class="required">*</span></label>
                                        <input class="spr-form-input spr-form-input-text" id="nickname" type="text" name="name" required />
                                    </div>
                                    <div class="col-sm-6 spr-form-contact-email form-group">
                                        <label class="spr-form-label" for="email">Email <span class="required">*</span></label>
                                        <input class="spr-form-input spr-form-input-email " id="email" type="email" name="email" required />
                                    </div>
                                    <div class="col-sm-6 spr-form-review-title form-group">
                                        <label class="spr-form-label" for="review">Review Title </label>
                                        <input class="spr-form-input spr-form-input-text " id="review" type="text" name="review" />
                                    </div>
                                    <div class="col-sm-6 spr-form-review-rating form-group">
                                        <label class="spr-form-label">Rating</label>
                                        <div class="product-review pt-1">
                                            <div class="review-rating">
                                                <a href="#;"><i class="icon anm anm-star-o"></i></a><a href="#;"><i class="icon anm anm-star-o"></i></a><a href="#;"><i class="icon anm anm-star-o"></i></a><a href="#;"><i class="icon anm anm-star-o"></i></a><a href="#;"><i class="icon anm anm-star-o"></i></a>
                            @if($reviewInfo['can_review'])
                                <form method="post" action="#" class="product-review-form new-review-form" id="review-form">
                                    @csrf
                                    <h3 class="spr-form-title">Viết đánh giá</h3>
                                    <p class="text-success"><small>Bạn đã mua sản phẩm này và có thể đánh giá</small></p>
                                    
                                    <fieldset class="row spr-form-contact">
                                        @if($reviewInfo['eligible_orders']->count() > 1)
                                        <div class="col-12 form-group">
                                            <label class="spr-form-label" for="order_id">Chọn đơn hàng <span class="required">*</span></label>
                                            <select class="form-control spr-form-input" id="order_id" name="order_id" required>
                                                <option value="">-- Chọn đơn hàng --</option>
                                                @foreach($reviewInfo['eligible_orders'] as $order)
                                                    <option value="{{ $order->id }}">
                                                        #{{ $order->order_number }} - {{ $order->created_at->format('d/m/Y') }}
                                                        @if($order->delivered_at)
                                                            (Giao: {{ $order->delivered_at->format('d/m/Y') }})
                                                        @endif
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        @else
                                            <input type="hidden" name="order_id" value="{{ $reviewInfo['eligible_orders']->first()->id }}">
                                        @endif
                                        
                                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                                        
                                        <div class="col-sm-6 spr-form-review-title form-group">
                                            <label class="spr-form-label" for="review_title">Tiêu đề đánh giá</label>
                                            <input class="spr-form-input spr-form-input-text" id="review_title" type="text" name="title" maxlength="255" />
                                        </div>
                                        <div class="col-sm-6 spr-form-review-rating form-group">
                                            <label class="spr-form-label">Đánh giá <span class="required">*</span></label>
                                            <div class="product-review pt-1">
                                                <div class="review-rating" id="review-rating">
                                                    <a href="#" data-rating="1"><i class="icon anm anm-star-o"></i></a>
                                                    <a href="#" data-rating="2"><i class="icon anm anm-star-o"></i></a>
                                                    <a href="#" data-rating="3"><i class="icon anm anm-star-o"></i></a>
                                                    <a href="#" data-rating="4"><i class="icon anm anm-star-o"></i></a>
                                                    <a href="#" data-rating="5"><i class="icon anm anm-star-o"></i></a>
                                                </div>
                                                <input type="hidden" id="rating" name="rating" value="" required>
                                                <small class="text-muted" id="rating-text"></small>
</div>
</div>
                                    </div>
                                    <div class="col-12 spr-form-review-body form-group">
                                        <label class="spr-form-label" for="message">Body of Review <span class="spr-form-review-body-charactersremaining">(1500) characters remaining</span></label>
                                        <div class="spr-form-input">
                                            <textarea class="spr-form-input spr-form-input-textarea" id="message" name="message" rows="3"></textarea>
                                        <div class="col-12 spr-form-review-body form-group">
                                            <label class="spr-form-label" for="review_content">Nội dung đánh giá <span class="required">*</span></label>
                                            <div class="spr-form-input">
                                                <textarea class="spr-form-input spr-form-input-textarea" id="review_content" name="content" rows="4" placeholder="Chia sẻ trải nghiệm của bạn về sản phẩm..." minlength="10" maxlength="1000" required></textarea>
                                            </div>
                                            <small class="text-muted">Tối thiểu 10 ký tự, tối đa 1000 ký tự</small>
                                        </div>
                                        
                                        <!-- Pros -->
                                        <div class="col-sm-6 form-group">
                                            <label class="spr-form-label">Ưu điểm</label>
                                            <div id="pros-container">
                                                <div class="input-group mb-2">
                                                    <input type="text" class="form-control" name="pros[]" placeholder="Ưu điểm của sản phẩm" maxlength="100">
                                                    <button type="button" class="btn btn-success btn-sm add-pro">+</button>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <!-- Cons -->
                                        <div class="col-sm-6 form-group">
                                            <label class="spr-form-label">Nhược điểm</label>
                                            <div id="cons-container">
                                                <div class="input-group mb-2">
                                                    <input type="text" class="form-control" name="cons[]" placeholder="Nhược điểm của sản phẩm" maxlength="100">
                                                    <button type="button" class="btn btn-success btn-sm add-con">+</button>
                                                </div>
                                            </div>
</div>
                                    </fieldset>
                                    
                                    <div class="spr-form-actions clearfix">
                                        <button type="submit" class="btn btn-primary spr-button spr-button-primary" id="submit-review-btn">
                                            Gửi đánh giá
                                        </button>
</div>
                                </fieldset>
                                <div class="spr-form-actions clearfix">
                                    <input type="submit" class="btn btn-primary spr-button spr-button-primary" value="Submit Review" />
                                </form>
                            @else
                                <div class="review-login-required">
                                    <h3 class="spr-form-title">Viết đánh giá</h3>
                                    <div class="alert alert-info">
                                        <i class="icon anm anm-info-cil me-2"></i>
                                        {{ $reviewInfo['message'] }}
                                    </div>
                                    @guest
                                        <p><a href="{{ route('login') }}" class="btn btn-primary">Đăng nhập để đánh giá</a></p>
                                    @endguest
</div>
                            </form>
                            @endif
</div>
</div>
</div>
<!--End Review-->
</div>
</div>
<!--End Product Tabs-->
</div>
<!--End Main Content-->
<!--Related Products-->
@if($relatedProducts->count() > 0)
<section class="section product-slider pb-0 mb-5">
<div class="container">
<div class="section-header">
<p class="mb-1 mt-0">Sản phẩm tương tự</p>
<h2>Bạn có thể thích những sản phẩm này</h2>
</div>
<!--Product Grid-->
<div class="product-slider-4items gp10 arwOut5 grid-products">
@foreach($relatedProducts as $relatedProduct)
<div class="item col-item">
<div class="product-box">
<!-- Start Product Image -->
<div class="product-image">
<!-- Start Product Image -->
@php $relatedPrimaryImage = $relatedProduct->images->where('is_primary', 1)->first() ?? $relatedProduct->images->first() @endphp
<a href="{{ route('client.product', $relatedProduct->slug) }}" class="product-img">
<!-- Image -->
<img class="primary blur-up lazyload" 
data-src="{{ $relatedPrimaryImage ? $relatedPrimaryImage->url : asset('assets/images/collection/category.jpg') }}" 
src="{{ $relatedPrimaryImage ? $relatedPrimaryImage->url : asset('assets/images/collection/category.jpg') }}" 
alt="{{ $relatedProduct->name }}" title="{{ $relatedProduct->name }}" width="625" height="808" />
<!-- End Image -->
<!-- Hover Image -->
@if($relatedProduct->images->count() > 1)
@php $hoverImage = $relatedProduct->images->where('is_primary', 0)->first() @endphp
<img class="hover blur-up lazyload" 
data-src="{{ $hoverImage ? $hoverImage->url : $relatedPrimaryImage->url }}" 
src="{{ $hoverImage ? $hoverImage->url : $relatedPrimaryImage->url }}" 
alt="{{ $relatedProduct->name }}" title="{{ $relatedProduct->name }}" width="625" height="808" />
@endif
<!-- End Hover Image -->
</a>
<!-- End Product Image -->

<!-- Product Label -->
@if($relatedProduct->compare_price && $relatedProduct->base_price < $relatedProduct->compare_price)
<div class="product-labels">
<span class="lbl on-sale">
-{{ round((($relatedProduct->compare_price - $relatedProduct->base_price) / $relatedProduct->compare_price) * 100) }}%
</span>
</div>
@endif

<!--Product Button-->
<div class="button-set style1">
<!--Quick View Button-->
<a href="{{ route('client.product', $relatedProduct->slug) }}" class="btn-icon quickview">
<span class="icon-wrap d-flex-justify-center h-100 w-100" data-bs-toggle="tooltip" data-bs-placement="left" title="Xem chi tiết">
<i class="icon anm anm-search-plus-l"></i><span class="text">Xem chi tiết</span>
</span>
</a>
<!--End Quick View Button-->
</div>
<!--End Product Button-->
</div>
<!-- End Product Image -->
<!-- Start Product Details -->
<div class="product-details text-left">
<!-- Product Name -->
<div class="product-name">
<a href="{{ route('client.product', $relatedProduct->slug) }}">{{ $relatedProduct->name }}</a>
</div>
<!-- End Product Name -->
<!-- Product Price -->
<div class="product-price">
@if($relatedProduct->compare_price && $relatedProduct->base_price < $relatedProduct->compare_price)
<span class="price old-price">{{ number_format($relatedProduct->compare_price, 0, ',', '.') }}đ</span>
@endif
<span class="price">{{ number_format($relatedProduct->base_price, 0, ',', '.') }}đ</span>
</div>
<!-- End Product Price -->
<!-- Product Review -->
<div class="product-review">
@for($i = 1; $i <= 5; $i++)
@if($i <= $relatedProduct->stats['average_rating'])
<i class="icon anm anm-star"></i>
@else
<i class="icon anm anm-star-o"></i>
@endif
@endfor
<span class="caption hidden ms-1">{{ $relatedProduct->stats['approved'] }} đánh giá</span>
</div>
<!-- End Product Review -->
</div>
<!-- End product details -->
</div>
</div>
@endforeach
</div>
<!--End Product Grid-->
</div>
</section>
@endif
<!--End Related Products-->
    <style>
        /* Stock Information Panel Styles */
        .stock-info-panel {
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        
        .stock-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 0.25rem;
        }
        
        .stock-label {
            font-size: 0.875rem;
        }
        
        .stock-value {
            font-size: 0.875rem;
        }
        
        /* Variant Stock Info Styles */
        .variant-stock-info {
            font-size: 0.75rem;
            line-height: 1.2;
        }
        
        /* Swatch improvements */
        .swatch .swatchLbl small {
            font-size: 0.7rem;
            line-height: 1;
            margin-top: 2px;
        }
        
        .swatch.soldout {
            opacity: 0.5;
            pointer-events: none;
        }
        
        .swatch.available:hover {
            transform: scale(1.05);
            transition: transform 0.2s ease;
        }
        
        /* Bottleneck Analysis Panel */
        .bottleneck-analysis {
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            border-left: 4px solid #ffc107 !important;
        }
        
        .bottleneck-analysis .text-danger {
            animation: pulse-red 2s infinite;
        }
        
        @keyframes pulse-red {
            0% { opacity: 1; }
            50% { opacity: 0.7; }
            100% { opacity: 1; }
        }
        
        /* Responsive adjustments */
        @media (max-width: 768px) {
            .variant-stock-info {
                display: none;
            }
            
            .stock-info-panel .col-6 {
                margin-bottom: 0.5rem;
            }
            
            .bottleneck-analysis {
                display: none !important;
            }
        }
    </style>
<script>
       // Global variables
       let selectedVariants = {};
       const basePrice = {{ $product->base_price }};
       let currentTotalPrice = basePrice;
        
        // Stock management variables
        const trackQuantity = {{ $product->track_quantity ? 'true' : 'false' }};
        const totalStock = {{ $product->stock_quantity ?? 0 }};
        let quantityInCart = {{ $quantityInCart }};
        let availableQuantity = trackQuantity ? Math.max(0, totalStock - quantityInCart) : 999999;
        
        // Variant stock data for validation
        const variantStockData = {
            @foreach($variantsByType as $variantType => $variants)
                '{{ $variantType }}': {
                    @foreach($variants as $variant)
                        '{{ $variant->variant_value }}': {{ $variant->stock_quantity ?? 0 }}{{ !$loop->last ? ',' : '' }}
                    @endforeach
                }{{ !$loop->last ? ',' : '' }}
            @endforeach
        };

        // Cart quantities by variant combinations
        const cartQuantitiesByVariants = @json($cartQuantitiesByVariants);
        
        // Helper function để generate variant key giống server-side
        function generateVariantKey(variants) {
            if (!variants || Object.keys(variants).length === 0) {
                return 'no_variants';
            }
            
            const sortedKeys = Object.keys(variants).sort();
            return sortedKeys.map(k => `${k}:${variants[k]}`).join('|');
        }

       function updateVariantInfo(variantType, variantValue, priceAdjustment) {
           // Update selected variant text
           document.getElementById('selected-' + variantType).textContent = variantValue;
           
           // Update price adjustment text
           let priceAdjustmentElement = document.getElementById('price-adjustment-' + variantType);
           if (priceAdjustment > 0) {
               priceAdjustmentElement.textContent = '(+' + new Intl.NumberFormat('vi-VN').format(priceAdjustment) + 'đ)';
           } else if (priceAdjustment < 0) {
               priceAdjustmentElement.textContent = '(-' + new Intl.NumberFormat('vi-VN').format(Math.abs(priceAdjustment)) + 'đ)';
           } else {
               priceAdjustmentElement.textContent = '';
           }

           // Update selected variants object
           selectedVariants[variantType] = variantValue;

            // Update variant stock information
            if (trackQuantity) {
                updateVariantStockInfo(variantType, variantValue);
            }

           // Update active state for variant options
           updateVariantActiveState(variantType, variantValue);

            // Update quantity limitations based on new variant selection
            updateQuantityInputLimitations();

           // Recalculate total price
           updateTotalPrice();
            
            // Update bottleneck analysis panel
            updateBottleneckPanel();
            
            // Update variant availability states
            updateVariantAvailabilityStates();
       }

       function updateVariantActiveState(selectedType, selectedValue) {
           // Remove active class from all variants of this type
           document.querySelectorAll(`[data-variant-type="${selectedType}"] .swatch`).forEach(swatch => {
               swatch.classList.remove('active');
           });

           // Add active class to selected variant
           document.querySelector(`[data-variant-value="${selectedValue}"][onclick*="${selectedType}"]`).classList.add('active');
       }

       function updateTotalPrice() {
           // Calculate total price including all variant adjustments
           let totalPrice = basePrice;
           
           document.querySelectorAll('.price-adjustment').forEach(element => {
               const adjustmentText = element.textContent.trim();
               if (adjustmentText.includes('+')) {
                   const amount = parseFloat(adjustmentText.replace(/[^0-9]/g, ''));
                   totalPrice += amount;
               } else if (adjustmentText.includes('-')) {
                   const amount = parseFloat(adjustmentText.replace(/[^0-9]/g, ''));
                   totalPrice -= amount;
               }
           });

           currentTotalPrice = totalPrice;

           // Update displayed price
           updateDisplayedPrice(totalPrice);
       }

       function updateDisplayedPrice(price) {
           // Update main product price display
           const priceElement = document.querySelector('.product-price .price:last-child');
           if (priceElement) {
               priceElement.textContent = new Intl.NumberFormat('vi-VN').format(price) + 'đ';
           }
       }

       // Handle form submission
       document.getElementById('add-to-cart-form').addEventListener('submit', function(e) {
           e.preventDefault();

           const formData = new FormData(this);
           const quantity = parseInt(formData.get('quantity'));

            // Kiểm tra số lượng tối đa có thể thêm (sử dụng logic bottleneck)
            if (trackQuantity) {
                const maxAllowed = getMaxAllowedQuantity();
                
                if (quantity > maxAllowed) {
                    // Tìm biến thể nào là bottleneck để thông báo rõ ràng
                    let bottleneckInfo = findBottleneckVariant();
                    
                    if (bottleneckInfo) {
                        showNotification(
                            `Chỉ có thể thêm tối đa ${maxAllowed} sản phẩm! ` +
                            `Bị giới hạn bởi "${bottleneckInfo.name}" (còn ${bottleneckInfo.available})`,
                            'error'
                        );
                    } else {
                        showNotification(`Chỉ có thể thêm tối đa ${maxAllowed} sản phẩm vào giỏ hàng!`, 'error');
                    }
                    return;
                }
            }

           // Add selected variants to form data
           for (const [variantType, variantValue] of Object.entries(selectedVariants)) {
               formData.append(`variants[${variantType}]`, variantValue);
           }

           // Disable button to prevent double submission
           const button = document.getElementById('add-to-cart-btn');
           const originalText = button.innerHTML;
           button.disabled = true;
           button.innerHTML = '<span>Đang thêm...</span>';

           // Send AJAX request
           fetch(this.action, {
               method: 'POST',
               body: formData,
               headers: {
                   'X-Requested-With': 'XMLHttpRequest',
                   'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || formData.get('_token')
               }
           })
           .then(response => response.json())
           .then(data => {
               if (data.success) {
                   // Show success message
                   showNotification(data.message, 'success');
                   
                   // Update cart count if exists
                   updateCartCountLocal(data.cart_count);
                    
                    // Update local cart quantities for this variant combination
                    if (trackQuantity) {
                        const variantKey = generateVariantKey(selectedVariants);
                        cartQuantitiesByVariants[variantKey] = (cartQuantitiesByVariants[variantKey] || 0) + quantity;
                        
                        // Update total quantity in cart
                        quantityInCart += quantity;
                        
                        // Update total available quantity (subtract from total stock)
                        availableQuantity = Math.max(0, totalStock - quantityInCart);
                        
                        // Update stock display and limitations
                        updateStockDisplay();
                        updateQuantityInputLimitations();
                        
                        // Update variant stock info for all selected variants
                        Object.keys(selectedVariants).forEach(variantType => {
                            updateVariantStockInfo(variantType, selectedVariants[variantType]);
                        });
                        
                        // Update bottleneck analysis panel
                        updateBottleneckPanel();
                        
                        // Update variant availability states
                        updateVariantAvailabilityStates();
                    }
               } else {
                   // Check for specific error
                   if (data.error && data.error.includes('SQLSTATE')) {
                       showNotification('Giá trị giỏ hàng quá lớn', 'error');
                   } else {
                       showNotification(data.message, 'error');
                   }
               }
           })
           .catch(error => {
               console.error('Error:', error);
               showNotification('Có lỗi xảy ra, vui lòng thử lại!', 'error');
           })
           .finally(() => {
               // Re-enable button
               button.disabled = false;
               button.innerHTML = originalText;
           });
       });

       function showNotification(message, type = 'success') {
           // Remove existing notifications
           const existingNotifications = document.querySelectorAll('.cart-notification');
           existingNotifications.forEach(notif => notif.remove());

           // Create notification
           const notification = document.createElement('div');
           notification.className = `cart-notification alert alert-${type === 'success' ? 'success' : 'danger'} alert-dismissible fade show`;
           notification.style.cssText = `
               position: fixed;
               top: 20px;
               right: 20px;
               z-index: 9999;
               min-width: 300px;
               box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
           `;
           
           notification.innerHTML = `
               <strong>${type === 'success' ? 'Thêm sản phẩm vào giỏ hàng thành công!' : 'Lỗi! Vượt quá số sản phẩm tồn kho'}</strong>
               <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
           `;

           document.body.appendChild(notification);

           // Auto remove after 3 seconds
           setTimeout(() => {
               if (notification && notification.parentNode) {
                   notification.remove();
               }
           }, 3000);
       }

        // Update variant stock information display
        function updateVariantStockInfo(variantType, variantValue) {
            if (!trackQuantity) return;
            
            // Get variant stock from data
            const variantStock = variantStockData[variantType] && variantStockData[variantType][variantValue] 
                ? variantStockData[variantType][variantValue] : 0;
            
            // Calculate how much this variant is already used in cart across ALL combinations
            let variantUsedInCart = 0;
            for (const [cartKey, cartQty] of Object.entries(cartQuantitiesByVariants)) {
                if (cartKey !== 'no_variants' && cartKey.includes(`${variantType}:${variantValue}`)) {
                    variantUsedInCart += cartQty;
                }
            }
            
            // Calculate available quantity for this variant
            const availableForThisVariant = Math.max(0, variantStock - variantUsedInCart);
            
            // Update variant stock display elements
            const stockElement = document.getElementById('variant-stock-' + variantType);
            const cartElement = document.getElementById('variant-cart-' + variantType);
            const availableElement = document.getElementById('variant-available-' + variantType);
            
            if (stockElement) stockElement.textContent = variantStock;
            if (cartElement) cartElement.textContent = variantUsedInCart;
            if (availableElement) {
                availableElement.textContent = availableForThisVariant;
                
                // Update color based on availability
                availableElement.className = 'fw-bold';
                if (availableForThisVariant <= 0) {
                    availableElement.classList.add('text-danger');
                } else if (availableForThisVariant <= 5) {
                    availableElement.classList.add('text-warning');
                } else {
                    availableElement.classList.add('text-success');
                }
            }
        }

        // Update stock display on page
        function updateStockDisplay() {
            if (!trackQuantity) return;
            
            const currentQuantityInCart = totalStock - availableQuantity;
            const lowStockThreshold = {{ $product->low_stock_threshold ?? 5 }};
            const isLowStock = availableQuantity <= lowStockThreshold && availableQuantity > 0;
            
            // Update product labels
            const productLabels = document.querySelector('.product-labels');
            if (productLabels) {
                // Remove existing stock labels
                const existingLabels = productLabels.querySelectorAll('.lbl.soldout, .lbl.pr-label1');
                existingLabels.forEach(label => label.remove());
                
                // Add new labels if needed
                if (availableQuantity <= 0) {
                    const soldoutLabel = document.createElement('span');
                    soldoutLabel.className = 'lbl soldout';
                    soldoutLabel.textContent = 'Hết hàng';
                    productLabels.appendChild(soldoutLabel);
                } else if (isLowStock) {
                    const lowStockLabel = document.createElement('span');
                    lowStockLabel.className = 'lbl pr-label1';
                    lowStockLabel.textContent = 'Sắp hết';
                    productLabels.appendChild(lowStockLabel);
                }
            }
            
            // Update stock status in form
            const stockLbl = document.querySelector('.pro-stockLbl .stockLbl');
            if (stockLbl) {
                let statusHtml = '';
                let statusClass = '';
                
                if (availableQuantity <= 0) {
                    statusClass = 'outstock text-uppercase text-danger';
                    statusHtml = '<i class="icon anm anm-times-cil"></i> Hết hàng';
                } else if (isLowStock) {
                    statusClass = 'lowstock text-uppercase text-warning';
                    statusHtml = `<i class="icon anm anm-exclamation-cil"></i> Sắp hết (${availableQuantity} còn lại)`;
                } else {
                    statusClass = 'instock text-uppercase text-success';
                    statusHtml = `<i class="icon anm anm-check-cil"></i> Còn hàng (${availableQuantity})`;
                }
                
                if (currentQuantityInCart > 0) {
                    statusHtml += ` <small class="ms-1">(${currentQuantityInCart} trong giỏ)</small>`;
                }
                
                stockLbl.className = `d-flex-center stockLbl ${statusClass}`;
                stockLbl.innerHTML = statusHtml;
            }
            
            // Disable/enable add to cart button
            const addToCartBtn = document.getElementById('add-to-cart-btn');
            if (addToCartBtn) {
                if (availableQuantity <= 0) {
                    addToCartBtn.disabled = true;
                    addToCartBtn.innerHTML = '<span>Hết hàng</span>';
                } else {
                    addToCartBtn.disabled = false;
                    addToCartBtn.innerHTML = '<span>Thêm vào giỏ hàng</span>';
                }
            }
            
            // Update stock information panel
            updateStockInfoPanel(currentQuantityInCart, availableQuantity);
        }

        // Update stock information panel
        function updateStockInfoPanel(inCartQty, availableQty) {
            if (!trackQuantity) return;
            
            // Update total stock (this shouldn't change)
            const totalStockElement = document.getElementById('total-stock');
            if (totalStockElement) totalStockElement.textContent = totalStock;
            
            // Update in cart quantity
            const inCartElement = document.getElementById('in-cart-quantity');
            if (inCartElement) inCartElement.textContent = inCartQty;
            
            // Calculate real available quantity (considering bottleneck)
            const realAvailableQty = getMaxAllowedQuantity();
            
            // Update available quantity (show real available, not just product available)
            const availableElement = document.getElementById('available-quantity');
            if (availableElement) {
                availableElement.textContent = realAvailableQty;
                
                // Add color based on real availability
                availableElement.className = 'stock-value fw-bold';
                if (realAvailableQty <= 0) {
                    availableElement.classList.add('text-danger');
                } else if (realAvailableQty <= 5) {
                    availableElement.classList.add('text-warning');
                } else {
                    availableElement.classList.add('text-success');
                }
            }
            
            // Update status based on real availability
            const statusElement = document.getElementById('stock-status');
            if (statusElement) {
                let statusHtml = '';
                const lowStockThreshold = {{ $product->min_stock ?? 5 }};
                
                if (realAvailableQty <= 0) {
                    const bottleneck = findBottleneckVariant();
                    statusHtml = '<span class="text-danger">Hết hàng</span>';
                    if (bottleneck) {
                        statusHtml += `<br><small class="text-muted">Giới hạn: ${bottleneck.name}</small>`;
                    }
                } else if (realAvailableQty <= lowStockThreshold) {
                    statusHtml = '<span class="text-warning">Sắp hết</span>';
                } else {
                    statusHtml = '<span class="text-success">Còn hàng</span>';
                }
                
                statusElement.innerHTML = statusHtml;
            }
            
            // Update bottleneck analysis panel
            updateBottleneckPanel();
        }

        // Update bottleneck analysis panel
        function updateBottleneckPanel() {
            const bottleneckPanel = document.getElementById('bottleneck-panel');
            const bottleneckContent = document.getElementById('bottleneck-content');
            
            if (!bottleneckPanel || !bottleneckContent || !trackQuantity) return;
            
            const maxAllowed = getMaxAllowedQuantity();
            const bottleneck = findBottleneckVariant();
            
            // Only show panel if there's a bottleneck limiting the quantity
            if (maxAllowed < availableQuantity || (bottleneck && bottleneck.available < availableQuantity)) {
                let content = '<div class="row g-2">';
                
                // Show product total
                content += `
                    <div class="col-12">
                        <div class="d-flex justify-content-between">
                            <span>📦 Tổng sản phẩm:</span>
                            <span class="fw-bold">${availableQuantity} có thể mua</span>
                        </div>
                    </div>
                `;
                
                // Show each variant limitation
                for (const [variantType, variantValue] of Object.entries(selectedVariants)) {
                    if (variantStockData[variantType] && variantStockData[variantType][variantValue] !== undefined) {
                        const variantStock = variantStockData[variantType][variantValue];
                        
                        let variantUsedInCart = 0;
                        for (const [cartKey, cartQty] of Object.entries(cartQuantitiesByVariants)) {
                            if (cartKey !== 'no_variants' && cartKey.includes(`${variantType}:${variantValue}`)) {
                                variantUsedInCart += cartQty;
                            }
                        }
                        
                        const availableForThisVariant = Math.max(0, variantStock - variantUsedInCart);
                        const isBottleneck = bottleneck && bottleneck.name.includes(variantValue);
                        
                        const variantTypeName = {
                            'handle_material': 'Chất liệu chuôi gậy',
                            'tip_material': 'Chất liệu đầu gậy'
                        }[variantType] || variantType;
                        
                        content += `
                            <div class="col-12">
                                <div class="d-flex justify-content-between ${isBottleneck ? 'text-danger fw-bold' : ''}">
                                    <span>${isBottleneck ? '🚫' : '🔧'} ${variantTypeName} (${variantValue}):</span>
                                    <span>${availableForThisVariant} có thể mua ${isBottleneck ? '← GIỚI HẠN' : ''}</span>
                                </div>
                            </div>
                        `;
                    }
                }
                
                content += `
                    <div class="col-12 mt-2 pt-2 border-top">
                        <div class="d-flex justify-content-between text-primary fw-bold">
                            <span>🎯 Kết quả:</span>
                            <span>${maxAllowed} có thể mua</span>
                        </div>
                    </div>
                </div>
                `;
                
                bottleneckContent.innerHTML = content;
                bottleneckPanel.style.display = 'block';
            } else {
                bottleneckPanel.style.display = 'none';
            }
        }

        // Update variant availability states based on current stock
        function updateVariantAvailabilityStates() {
            if (!trackQuantity) return;
            
            // Update all swatches based on current availability
            document.querySelectorAll('.swatch').forEach(swatch => {
                const variantValue = swatch.getAttribute('data-variant-value');
                const variantStock = parseInt(swatch.getAttribute('data-stock')) || 0;
                
                // Find variant type from onclick attribute
                const onclickAttr = swatch.getAttribute('onclick');
                if (!onclickAttr) return;
                
                const variantType = onclickAttr.match(/'([^']+)'/)?.[1];
                if (!variantType) return;
                
                // Calculate how much this variant is used in cart
                let variantUsedInCart = 0;
                for (const [cartKey, cartQty] of Object.entries(cartQuantitiesByVariants)) {
                    if (cartKey !== 'no_variants' && cartKey.includes(`${variantType}:${variantValue}`)) {
                        variantUsedInCart += cartQty;
                    }
                }
                
                const availableForThisVariant = Math.max(0, variantStock - variantUsedInCart);
                
                // Update swatch classes and states
                swatch.classList.remove('available', 'soldout');
                if (availableForThisVariant > 0) {
                    swatch.classList.add('available');
                    swatch.style.pointerEvents = 'auto';
                    swatch.style.opacity = '1';
                } else {
                    swatch.classList.add('soldout');
                    swatch.style.pointerEvents = 'none';
                    swatch.style.opacity = '0.5';
                }
                
                // Update the small stock number display
                const smallElement = swatch.querySelector('small span');
                if (smallElement) {
                    if (availableForThisVariant <= 0) {
                        smallElement.textContent = 'Hết';
                        smallElement.className = 'text-danger';
                    } else if (availableForThisVariant <= 5) {
                        smallElement.textContent = availableForThisVariant;
                        smallElement.className = 'text-warning';
                    } else {
                        smallElement.textContent = availableForThisVariant;
                        smallElement.className = 'text-success';
                    }
                }
                
                // Update tooltip
                const swatchLbl = swatch.querySelector('.swatchLbl');
                if (swatchLbl) {
                    swatchLbl.setAttribute('title', 
                        `${variantValue} - Kho: ${variantStock}, Có thể mua: ${availableForThisVariant}`
                    );
                }
            });
        }

       // Use global helper function from ClientLayout
       function updateCartCountLocal(count) {
           if (typeof window.updateCartCount === 'function') {
               window.updateCartCount(count);
           } else {
               // Fallback if global function not available
               const cartCountElements = document.querySelectorAll('.cart-count, .cart-counter, [data-cart-count]');
               cartCountElements.forEach(element => {
                   element.textContent = count;
                   element.style.display = count > 0 ? 'inline' : 'none';
               });
           }
       }

        // Update quantity input limitations
        function updateQuantityInputLimitations() {
            const quantityInput = document.querySelector('.product-form-input.qty');
            if (quantityInput && trackQuantity) {
                const maxAllowed = getMaxAllowedQuantity();
                quantityInput.setAttribute('max', maxAllowed);
                
                // If current value exceeds max allowed, reset to max allowed
                if (parseInt(quantityInput.value) > maxAllowed) {
                    quantityInput.value = Math.max(1, maxAllowed);
                }
            }
        }

        // Get max allowed quantity based on variants (FIXED LOGIC)
        function getMaxAllowedQuantity() {
            if (!trackQuantity) return 999999;
            
            // Start with product total available quantity
            let maxQty = availableQuantity; // Product stock - total quantity in cart
            
            // DEBUG: Uncomment these lines to see calculation details
            // console.log('🔍 Calculating max quantity:');
            // console.log('- Product available:', maxQty);
            
            // Check each selected variant individually
            // The MINIMUM of all variant stocks will be the bottleneck
            for (const [variantType, variantValue] of Object.entries(selectedVariants)) {
                if (variantStockData[variantType] && variantStockData[variantType][variantValue] !== undefined) {
                    const variantStock = variantStockData[variantType][variantValue];
                    
                    // Calculate how much this variant is already used in cart
                    let variantUsedInCart = 0;
                    
                    // Loop through all cart items to count usage of this specific variant
                    for (const [cartKey, cartQty] of Object.entries(cartQuantitiesByVariants)) {
                        if (cartKey !== 'no_variants' && cartKey.includes(`${variantType}:${variantValue}`)) {
                            variantUsedInCart += cartQty;
                        }
                    }
                    
                    const availableForThisVariant = Math.max(0, variantStock - variantUsedInCart);
                    
                    // DEBUG: Uncomment to see variant details
                    // console.log(`- ${variantType}:${variantValue}`, {
                    //     stock: variantStock,
                    //     usedInCart: variantUsedInCart,
                    //     available: availableForThisVariant
                    // });
                    
                    // Take the minimum - this is the bottleneck logic
                    maxQty = Math.min(maxQty, availableForThisVariant);
                }
            }
            
            // DEBUG: Uncomment to see final result
            // console.log('📊 Final max quantity:', maxQty);
            
            return maxQty;
        }

        // Find which variant is the bottleneck (limiting factor)
        function findBottleneckVariant() {
            if (!trackQuantity) return null;
            
            let minAvailable = availableQuantity;
            let bottleneck = null;
            
            // Check product total first
            if (availableQuantity <= minAvailable) {
                bottleneck = {
                    name: 'Tổng sản phẩm',
                    available: availableQuantity
                };
                minAvailable = availableQuantity;
            }
            
            // Check each variant
            for (const [variantType, variantValue] of Object.entries(selectedVariants)) {
                if (variantStockData[variantType] && variantStockData[variantType][variantValue] !== undefined) {
                    const variantStock = variantStockData[variantType][variantValue];
                    
                    // Calculate how much this variant is already used in cart
                    let variantUsedInCart = 0;
                    for (const [cartKey, cartQty] of Object.entries(cartQuantitiesByVariants)) {
                        if (cartKey !== 'no_variants' && cartKey.includes(`${variantType}:${variantValue}`)) {
                            variantUsedInCart += cartQty;
                        }
                    }
                    
                    const availableForThisVariant = Math.max(0, variantStock - variantUsedInCart);
                    
                    if (availableForThisVariant < minAvailable) {
                        // Get variant type name for display
                        const variantTypeName = {
                            'handle_material': 'Chất liệu chuôi gậy',
                            'tip_material': 'Chất liệu đầu gậy'
                        }[variantType] || variantType;
                        
                        bottleneck = {
                            name: `${variantTypeName}: ${variantValue}`,
                            available: availableForThisVariant
                        };
                        minAvailable = availableForThisVariant;
                    }
                }
            }
            
            return bottleneck;
        }

        // Handle quantity change validation
        function setupQuantityValidation() {
            const quantityInput = document.querySelector('.product-form-input.qty');
            const plusBtn = document.querySelector('.qtyBtn.plus');
            const minusBtn = document.querySelector('.qtyBtn.minus');
            
            if (quantityInput && trackQuantity) {
                // Validate on input change
                quantityInput.addEventListener('input', function() {
                    let value = parseInt(this.value) || 1;
                    const maxAllowed = getMaxAllowedQuantity();
                    
                    if (value > maxAllowed) {
                        value = maxAllowed;
                        this.value = value;
                        showNotification(`Chỉ có thể mua tối đa ${maxAllowed} sản phẩm với biến thể được chọn!`, 'warning');
                    } else if (value < 1) {
                        value = 1;
                        this.value = value;
                    }
                });
                
                // Handle plus button
                if (plusBtn) {
                    plusBtn.addEventListener('click', function(e) {
                        e.preventDefault();
                        let currentValue = parseInt(quantityInput.value) || 1;
                        const maxAllowed = getMaxAllowedQuantity();
                        
                        if (currentValue < maxAllowed) {
                            // quantityInput.value = currentValue + 1;
                        } else {
                            const bottleneck = findBottleneckVariant();
                            if (bottleneck) {
                                showNotification(
                                    `Chỉ có thể mua tối đa ${maxAllowed} sản phẩm! Bị giới hạn bởi "${bottleneck.name}"`,
                                    'warning'
                                );
                            } else {
                                showNotification(`Chỉ có thể mua tối đa ${maxAllowed} sản phẩm với biến thể được chọn!`, 'warning');
                            }
                        }
                    });
                }
                
                // Handle minus button
                if (minusBtn) {
                    minusBtn.addEventListener('click', function(e) {
                        e.preventDefault();
                        let currentValue = parseInt(quantityInput.value) || 1;
                        if (currentValue > 1) {
                            // quantityInput.value = currentValue - 1;
                        }
                    });
                }
            }
        }

       // Initialize: Set default variants as selected
       document.addEventListener('DOMContentLoaded', function() {
           // Auto-select first variant of each type
           document.querySelectorAll('.product-swatches-option .product-item').forEach(variantGroup => {
               const firstVariant = variantGroup.querySelector('.swatch.active');
               if (firstVariant) {
                   const variantType = firstVariant.getAttribute('onclick').match(/'([^']+)'/)[1];
                   const variantValue = firstVariant.getAttribute('data-variant-value');
                   const priceAdjustment = parseFloat(firstVariant.getAttribute('data-price-adjustment')) || 0;
                   
                   selectedVariants[variantType] = variantValue;
               }
           });

            // Initial price calculation
            // Initial price calculation and stock display
           updateTotalPrice();
            updateStockDisplay();
            updateQuantityInputLimitations();
            setupQuantityValidation();
            
            // Initialize variant stock info for all selected variants
            if (trackQuantity) {
                Object.keys(selectedVariants).forEach(variantType => {
                    updateVariantStockInfo(variantType, selectedVariants[variantType]);
                });
                
                // Initialize bottleneck analysis panel
                updateBottleneckPanel();
                
                // Initialize variant availability states
                updateVariantAvailabilityStates();
            }

            // Setup review form if available
            if (document.getElementById('review-form')) {
                setupReviewForm();
            }
       });

        // Review form functions
        function setupReviewForm() {
            // Star rating functionality
            const stars = document.querySelectorAll('#review-rating a');
            const ratingInput = document.getElementById('rating');
            const ratingText = document.getElementById('rating-text');
            
            const ratingTexts = {
                1: 'Rất tệ',
                2: 'Tệ', 
                3: 'Trung bình',
                4: 'Tốt',
                5: 'Rất tốt'
            };

            stars.forEach(star => {
                star.addEventListener('click', function(e) {
                    e.preventDefault();
                    const rating = this.getAttribute('data-rating');
                    ratingInput.value = rating;
                    ratingText.textContent = ratingTexts[rating];
                    
                    // Update star display
                    stars.forEach((s, index) => {
                        const icon = s.querySelector('i');
                        if (index < rating) {
                            icon.className = 'icon anm anm-star';
                        } else {
                            icon.className = 'icon anm anm-star-o';
                        }
                    });
                });
            });

            // Add/remove pros and cons
            setupDynamicInputs('.add-pro', '#pros-container', 'pros[]', 'Ưu điểm khác');
            setupDynamicInputs('.add-con', '#cons-container', 'cons[]', 'Nhược điểm khác');

            // Form submission
            const reviewForm = document.getElementById('review-form');
            reviewForm.addEventListener('submit', function(e) {
                e.preventDefault();
                submitReview();
            });
        }

        function setupDynamicInputs(buttonSelector, containerSelector, inputName, placeholder) {
            document.addEventListener('click', function(e) {
                if (e.target.matches(buttonSelector)) {
                    e.preventDefault();
                    const container = document.querySelector(containerSelector);
                    const currentInputs = container.querySelectorAll('input').length;
                    
                    // Giới hạn tối đa 10 items
                    if (currentInputs >= 10) {
                        showReviewNotification('Tối đa 10 mục cho mỗi danh sách', 'error');
                        return;
                    }
                    
                    const newInput = document.createElement('div');
                    newInput.className = 'input-group mb-2';
                    newInput.innerHTML = `
                        <input type="text" class="form-control" name="${inputName}" placeholder="${placeholder}" maxlength="100">
                        <button type="button" class="btn btn-danger btn-sm remove-input">-</button>
                    `;
                    container.appendChild(newInput);
                }
                
                if (e.target.matches('.remove-input')) {
                    e.preventDefault();
                    const container = e.target.closest('#pros-container, #cons-container');
                    const inputs = container.querySelectorAll('.input-group');
                    
                    // Đảm bảo luôn có ít nhất 1 input
                    if (inputs.length > 1) {
                        e.target.parentElement.remove();
                    }
                }
            });
        }

        function submitReview() {
            const form = document.getElementById('review-form');
            
            // Validate form trước khi submit
            if (!validateReviewForm()) {
                return;
            }
            
            const formData = new FormData(form);
            const submitBtn = document.getElementById('submit-review-btn');
            
            // Disable button to prevent double submission
            submitBtn.disabled = true;
            submitBtn.textContent = 'Đang gửi...';

            fetch('{{ route("client.reviews.submit") }}', {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content')
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    showReviewNotification(data.message, 'success');
                    
                    // Reset form completely
                    resetReviewForm();
                    
                    // Hide form after successful submission
                    // Thêm review mới vào DOM ngay lập tức
                    addNewReviewToDOM(data.review);
                    
                    // Hiển thị success message mà không ẩn form
                    const existingMsg = form.parentNode.querySelector('.review-success-msg');
                    if (existingMsg) existingMsg.remove();
                    
                    const successMsg = document.createElement('div');
                    successMsg.className = 'alert alert-success review-success-msg';
                    successMsg.innerHTML = '<i class="icon anm anm-check-cil me-2"></i>Cảm ơn bạn đã đánh giá! Đánh giá của bạn đã được đăng thành công.';
                    form.parentNode.insertBefore(successMsg, form);
                    
                    // Cập nhật order selection nếu cần
                    updateOrderSelection(data.review);
                    
                    // Auto remove success message sau 5 giây
                    setTimeout(() => {
                        if (successMsg && successMsg.parentNode) {
                            successMsg.remove();
                        }
                    }, 5000);
                    
                } else {
                    showReviewNotification(data.message, 'error');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                // showReviewNotification('Có lỗi xảy ra, vui lòng thử lại!', 'error');
            })
            .finally(() => {
                // Re-enable button
                submitBtn.disabled = false;
                submitBtn.textContent = 'Gửi đánh giá';
            });
        }

        function validateReviewForm() {
            const rating = document.getElementById('rating').value;
            const content = document.getElementById('review_content').value.trim();
            const orderSelect = document.getElementById('order_id');
            
            // Kiểm tra rating
            if (!rating || rating < 1 || rating > 5) {
                showReviewNotification('Vui lòng chọn số sao đánh giá', 'error');
                return false;
            }
            
            // Kiểm tra order (nếu có dropdown)
            if (orderSelect && orderSelect.tagName.toLowerCase() === 'select' && !orderSelect.value) {
                showReviewNotification('Vui lòng chọn đơn hàng', 'error');
                return false;
            }
            
            // Kiểm tra content
            if (content.length < 10) {
                showReviewNotification('Nội dung đánh giá phải có ít nhất 10 ký tự', 'error');
                return false;
            }
            
            if (content.length > 1000) {
                showReviewNotification('Nội dung đánh giá không được quá 1000 ký tự', 'error');
                return false;
            }
            
            return true;
        }

        function resetReviewForm() {
            const form = document.getElementById('review-form');
            
            // Reset form data
            form.reset();
            
            // Reset rating
            document.getElementById('rating').value = '';
            document.getElementById('rating-text').textContent = '';
            
            // Reset stars
            document.querySelectorAll('#review-rating i').forEach(icon => {
                icon.className = 'icon anm anm-star-o';
            });
            
            // Reset pros container - giữ lại 1 input đầu tiên
            const prosContainer = document.getElementById('pros-container');
            const prosInputs = prosContainer.querySelectorAll('.input-group');
            prosInputs.forEach((input, index) => {
                if (index === 0) {
                    input.querySelector('input').value = '';
                } else {
                    input.remove();
                }
            });
            
            // Reset cons container - giữ lại 1 input đầu tiên  
            const consContainer = document.getElementById('cons-container');
            const consInputs = consContainer.querySelectorAll('.input-group');
            consInputs.forEach((input, index) => {
                if (index === 0) {
                    input.querySelector('input').value = '';
                } else {
                    input.remove();
                }
            });
        }

        function addNewReviewToDOM(reviewData) {
            const reviewContainer = document.querySelector('.review-inner');
            if (!reviewContainer) return;

            // Tạo HTML cho review mới
            const newReviewHTML = createReviewHTML(reviewData);
            
            // Thêm vào đầu danh sách reviews
            reviewContainer.insertAdjacentHTML('afterbegin', newReviewHTML);
            
            // Thêm animation highlight cho review mới
            const newReview = reviewContainer.firstElementChild;
            newReview.style.backgroundColor = '#e8f5e8';
            newReview.style.border = '2px solid #28a745';
            newReview.style.borderRadius = '8px';
            newReview.style.padding = '15px';
            newReview.style.marginBottom = '20px';
            
            // Fade out highlight sau 3 giây
            setTimeout(() => {
                newReview.style.transition = 'all 1s ease';
                newReview.style.backgroundColor = 'transparent';
                newReview.style.border = 'none';
            }, 3000);

            // Cập nhật số lượng đánh giá nếu có
            updateReviewCount();
        }

        function createReviewHTML(review) {
            const starsHTML = generateStarsHTML(review.rating);
            const prosHTML = review.has_pros ? createProsConsHTML(review.pros, 'Ưu điểm') : '';
            const consHTML = review.has_cons ? createProsConsHTML(review.cons, 'Nhược điểm') : '';
            
            return `
                <div class="spr-review d-flex w-100 new-review">
                    <div class="spr-review-profile flex-shrink-0">
                        <img class="blur-up lazyload" 
                             src="{{ asset('assets/images/users/user-img1.jpg') }}" 
                             alt="" width="200" height="200" />
                    </div>
                    <div class="spr-review-content flex-grow-1">
                        <div class="d-flex justify-content-between flex-column mb-2">
                            <div class="title-review d-flex align-items-center justify-content-between">
                                <h5 class="spr-review-header-title text-transform-none mb-0">
                                    ${review.user_display_name}
                                    <small class="text-success fw-bold ms-2">[Mới đăng]</small>
                                </h5>
                                <span class="product-review spr-starratings m-0">
                                    <span class="reviewLink">${starsHTML}</span>
                                </span>
                            </div>
                        </div>
                        ${review.title ? `<b class="head-font">${review.title}</b>` : ''}
                        <p class="spr-review-body">${review.content}</p>
                        ${prosHTML}
                        ${consHTML}
                        <small class="text-muted">Đánh giá vào ${review.created_at}</small>
                    </div>
                </div>
            `;
        }

        function generateStarsHTML(rating) {
            let starsHTML = '';
            for (let i = 1; i <= 5; i++) {
                if (i <= rating) {
                    starsHTML += '<i class="icon anm anm-star"></i>';
                } else {
                    starsHTML += '<i class="icon anm anm-star-o"></i>';
                }
            }
            return starsHTML;
        }

        function createProsConsHTML(items, label) {
            if (!items || items.length === 0) return '';
            
            const className = label === 'Ưu điểm' ? 'text-success' : 'text-danger';
            const icon = label === 'Ưu điểm' ? '✓' : '✗';
            
            const itemsHTML = items.map(item => `<li class="${className}">${icon} ${item}</li>`).join('');
            return `
                <div class="review-pros-cons mb-2">
                    <strong class="${className}">${label}:</strong>
                    <ul class="mb-0 ps-3" style="list-style: none;">${itemsHTML}</ul>
                </div>
            `;
        }

        function updateReviewCount() {
            // Cập nhật số đếm reviews trong tabs và headers
            const reviewCountElements = document.querySelectorAll('[data-review-count]');
            reviewCountElements.forEach(element => {
                const currentCount = parseInt(element.textContent.match(/\d+/)?.[0] || 0);
                const newCount = currentCount + 1;
                element.textContent = element.textContent.replace(/\d+/, newCount);
            });

            // Cập nhật tab title nếu có
            const reviewTab = document.querySelector('li[rel="reviews"] a');
            if (reviewTab) {
                const currentText = reviewTab.textContent;
                const currentCount = parseInt(currentText.match(/\d+/)?.[0] || 0);
                const newCount = currentCount + 1;
                reviewTab.textContent = currentText.replace(/\d+/, newCount);
            }
        }

        function updateOrderSelection(reviewData) {
            const orderSelect = document.getElementById('order_id');
            if (!orderSelect || orderSelect.tagName.toLowerCase() !== 'select') return;

            // Lấy order_id đã được review từ response data
            const reviewedOrderId = reviewData.order_id;

            if (reviewedOrderId) {
                // Xóa option đã review khỏi dropdown
                const optionToRemove = orderSelect.querySelector(`option[value="${reviewedOrderId}"]`);
                if (optionToRemove) {
                    optionToRemove.remove();
                }

                // Reset selection
                orderSelect.selectedIndex = 0;

                // Kiểm tra nếu không còn order nào để review
                const remainingOptions = orderSelect.querySelectorAll('option[value!=""]');
                if (remainingOptions.length === 0) {
                    // Ẩn form và hiển thị message
                    const form = document.getElementById('review-form');
                    form.style.display = 'none';
                    
                    const noMoreOrdersMsg = document.createElement('div');
                    noMoreOrdersMsg.className = 'alert alert-info';
                    noMoreOrdersMsg.innerHTML = '<i class="icon anm anm-info-cil me-2"></i>Bạn đã đánh giá tất cả các đơn hàng có chứa sản phẩm này.';
                    form.parentNode.insertBefore(noMoreOrdersMsg, form);
                } else {
                    // Cập nhật placeholder
                    const defaultOption = orderSelect.querySelector('option[value=""]');
                    if (defaultOption && remainingOptions.length === 1) {
                        defaultOption.textContent = '-- Còn 1 đơn hàng có thể đánh giá --';
                    } else if (defaultOption) {
                        defaultOption.textContent = `-- Còn ${remainingOptions.length} đơn hàng có thể đánh giá --`;
                    }
                }
            }
        }

        function showReviewNotification(message, type = 'success') {
            // Remove existing notifications
            const existingNotifications = document.querySelectorAll('.review-notification');
            existingNotifications.forEach(notif => notif.remove());

            // Create notification
            const notification = document.createElement('div');
            notification.className = `review-notification alert alert-${type === 'success' ? 'success' : 'danger'} alert-dismissible fade show`;
            notification.style.cssText = `
                position: fixed;
                top: 20px;
                right: 20px;
                z-index: 9999;
                min-width: 300px;
                box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            `;
            
            notification.innerHTML = `
                <strong>${message}</strong>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            `;

            document.body.appendChild(notification);

            // Auto remove after 5 seconds
            setTimeout(() => {
                if (notification && notification.parentNode) {
                    notification.remove();
                }
            }, 5000);
        }
   </script>
@endsection