@extends('layouts.client.ClientLayout')

@section('content')
<!--Page Header-->
<div class="page-header text-center">
    <div class="container">
        <div class="row">
            <div class="col-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-content-between align-items-center">
                <div class="page-title">
                    <h1>
                        {{ $product->name }}
                    </h1>
                </div>
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
                            @if($product->compare_price && $product->base_price < $product->compare_price)
                                <span class="lbl on-sale">
                                    -{{ round((($product->compare_price - $product->base_price) / $product->compare_price) * 100) }}%
                                </span>
                                @endif
                                @if($product->is_featured)
                                <span class="lbl pr-label2">HOT</span>
                                @endif
                                @if($product->stock_quantity <= 0 && $product->track_quantity)
                                    <span class="lbl soldout">Hết hàng</span>
                                    @elseif($product->isLowStock())
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
                                <img style="min-height: 120px" class="blur-up lazyload"
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
                    <!-- Product Reviews -->
                    <div class="product-review d-flex-center mb-2">
                        <div class="reviewStar d-flex-center">
                            @for ($i = 1; $i <= 5; $i++)
                                @if ($i <=$reviewStats['average_rating'])
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
                                    <span class="d-flex-center stockLbl outstock text-uppercase text-danger">
                                    <i class="icon anm anm-times-cil"></i> Hết hàng
                                    </span>
                                    @elseif($product->isLowStock())
                                    <span class="d-flex-center stockLbl lowstock text-uppercase text-warning">
                                        <i class="icon anm anm-exclamation-cil"></i> Sắp hết ({{ $product->stock_quantity }} còn lại)
                                    </span>
                                    @else
                                    <span class="d-flex-center stockLbl instock text-uppercase text-success">
                                        <i class="icon anm anm-check-cil"></i> Còn hàng ({{ $product->stock_quantity }})
                                    </span>
                                    @endif
                                    @else
                                    <span class="d-flex-center stockLbl instock text-uppercase text-success">
                                        <i class="icon anm anm-check-cil"></i> Luôn có sẵn
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
                                                <span class="text-danger">Hết hàng</span>
                                                @elseif($product->isLowStock())
                                                <span class="text-warning">Sắp hết ({{ $product->stock_quantity }} còn lại)</span>
                                                @else
                                                <span class="text-success">Còn hàng ({{ $product->stock_quantity }})</span>
                                                @endif
                                                @else
                                                <span class="text-info">Luôn có sẵn</span>
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
                                                @if ($i <=$reviewStats['average_rating'])
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
                                                @if($j <=$i)
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
                                                            @if($i <=$review->rating)
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
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 spr-form-review-body form-group">
                                    <label class="spr-form-label" for="message">Body of Review <span class="spr-form-review-body-charactersremaining">(1500) characters remaining</span></label>
                                    <div class="spr-form-input">
                                        <textarea class="spr-form-input spr-form-input-textarea" id="message" name="message" rows="3"></textarea>
                                    </div>
                                </div>
                            </fieldset>
                            <div class="spr-form-actions clearfix">
                                <input type="submit" class="btn btn-primary spr-button spr-button-primary" value="Submit Review" />
                            </div>
                        </form>
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
                                @if($i <=$relatedProduct->stats['average_rating'])
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
<script>
    // Global variables
    let selectedVariants = {};
    const basePrice = {
        {
            $product - > base_price
        }
    };
    let currentTotalPrice = basePrice;

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

        // Update active state for variant options
        updateVariantActiveState(variantType, variantValue);

        // Recalculate total price
        updateTotalPrice();
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
                } else {
                    // Show error message
                    showNotification(data.message, 'error');
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
                <strong>${type === 'success' ? 'Thành công!' : 'Lỗi!'}</strong> ${message}
                <strong>${type === 'success' ? 'Thành công!' : 'Lỗi!'}</strong> Có vấn đề về giá hoặc sản phẩm, vui lòng liên hệ Admin}
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
        updateTotalPrice();
    });
</script>