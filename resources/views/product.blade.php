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
                        <div class="zoompro-span"><img id="zoompro" class="zoompro" src="{{ asset('assets/images/products/product2.jpg') }}" data-zoom-image="{{ asset('assets/images/products/product2.jpg') }}" alt="product" width="625" height="808" /></div>
                        <div class="zoompro-span"><img id="zoompro" class="zoompro" src="{{ $product->primaryImage->url }}" data-zoom-image="{{ $product->primaryImage->url }}" alt="product" width="625" height="808" /></div>
                        <!-- End Product Image -->
                        <!-- Product Label -->
                        <div class="product-labels"><span class="lbl pr-label1">New</span><span class="lbl on-sale">Sale</span></div>
                        <!-- End Product Label -->
                        <!-- End Product Buttons -->
                        <div class="product-buttons">
                            <a href="#" class="btn prlightbox" data-bs-toggle="tooltip" data-bs-placement="top" title="Zoom Image"><i class="icon anm anm-expand-l-arrows"></i></a>
                            <div class="product-labels">
                                @if($product->base_price !== $product->compare_price)
                                <span class="lbl on-sale">Sale</span>
                                @endif
                                @if($product->is_featured)
                                <span class="lbl pr-label2">HOT</span>
                                @endif
                            </div>
                            <!-- End Product Buttons -->
                            <!-- End Product Label -->

                        </div>
                        <!-- End Product Main -->

                        <!-- Product Thumb -->
                        <div class="product-thumb product-horizontal-thumb mt-3">
                            <div id="gallery" class="product-thumb-horizontal">
                                <a data-image="{{ asset('assets/images/products/product2.jpg') }}" data-zoom-image="{{ asset('assets/images/products/product2.jpg') }}" class="slick-slide slick-cloned active">
                                    <img class="blur-up lazyload" data-src="assets/images/products/product2.jpg" src="assets/images/products/product2.jpg" alt="product" width="625" height="808" />
                                </a>
                                <a data-image="{{ asset('assets/images/products/product2-1.jpg') }}" data-zoom-image="{{ asset('assets/images/products/product2-1.jpg') }}" class="slick-slide slick-cloned">
                                    <img class="blur-up lazyload" data-src="{{ asset('assets/images/products/product2-1.jpg') }}" src="{{ asset('assets/images/products/product2-1.jpg') }}" alt="product" width="625" height="808" />
                                </a>
                                <a data-image="{{ asset('assets/images/products/product2-2.jpg') }}" data-zoom-image="{{ asset('assets/images/products/product2-2.jpg') }}" class="slick-slide slick-cloned">
                                    <img class="blur-up lazyload" data-src="{{ asset('assets/images/products/product2-2.jpg') }}" src="{{ asset('assets/images/products/product2-2.jpg') }}" alt="product" width="625" height="808" />
                                </a>
                                <a data-image="{{ asset('assets/images/products/product2-3.jpg') }}" data-zoom-image="{{ asset('assets/images/products/product2-3.jpg') }}" class="slick-slide slick-cloned">
                                    <img class="blur-up lazyload" data-src="{{ asset('assets/images/products/product2-3.jpg') }}" src="{{ asset('assets/images/products/product2-3.jpg') }}" alt="product" width="625" height="808" />
                                </a>
                                <a data-image="{{ asset('assets/images/products/product2-4.jpg') }}" data-zoom-image="{{ asset('assets/images/products/product2-4.jpg') }}" class="slick-slide slick-cloned">
                                    <img class="blur-up lazyload" data-src="{{ asset('assets/images/products/product2-4.jpg') }}" src="{{ asset('assets/images/products/product2-4.jpg') }}" alt="product" width="625" height="808" />
                                </a>
                                <a data-image="{{ asset('assets/images/products/product2-5.jpg') }}" data-zoom-image="{{ asset('assets/images/products/product2-5.jpg') }}" class="slick-slide slick-cloned">
                                    <img class="blur-up lazyload" data-src="{{ asset('assets/images/products/product2-5.jpg') }}" src="{{ asset('assets/images/products/product2-5.jpg') }}" alt="product" width="625" height="808" />
                                </a>
                                @foreach ($product->images as $image)
                                <a data-image="{{ $image->url }}" data-zoom-image="{{ $image->url }}" class="slick-slide slick-cloned active">
                                    <img class="blur-up lazyload" data-src="{{ $image->url }}" src="{{ $image->url }}" alt="product" width="625" height="808" />
                                </a>
                                @endforeach
                            </div>
                        </div>
                        <!-- End Product Thumb -->

                        <!-- Product Gallery -->
                        <div class="lightboximages">
                            <a href="{{ asset('assets/images/products/product2.jpg') }}" data-size="1000x1280"></a>
                            <a href="{{ asset('assets/images/products/product2-1.jpg') }}" data-size="1000x1280"></a>
                            <a href="{{ asset('assets/images/products/product2-2.jpg') }}" data-size="1000x1280"></a>
                            <a href="{{ asset('assets/images/products/product2-3.jpg') }}" data-size="1000x1280"></a>
                            <a href="{{ asset('assets/images/products/product2-4.jpg') }}" data-size="1000x1280"></a>
                            <a href="{{ asset('assets/images/products/product2-5.jpg') }}" data-size="1000x1280"></a>
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
                            <div class="reviewStar d-flex-center"><i class="icon anm anm-star"></i><i class="icon anm anm-star"></i><i class="icon anm anm-star"></i><i class="icon anm anm-star"></i><i class="icon anm anm-star-o"></i><span class="caption ms-2">24 Reviews</span></div>
                            <a class="reviewLink d-flex-center" href="#reviews">Write a Review</a>
                        </div>
                        <!-- End Product Reviews -->
                        <!-- Product Price -->
                        <div class="product-price d-flex-center my-3">
                            <span class="price old-price">$699.00</span><span class="price">$499.00</span>
                            <span class="discount-badge"><span class="devider mx-2">|</span><span>Save: </span><span class="save-amount"><b class="money text-primary">$36.00</b></span><span class="off ms-1">(<span>15</span>%)</span> off</span>
                        </div>
                        <!-- End Product Price -->
                        <!-- Sort Description -->
                        <div class="sort-description">
                            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip</p>
                        </div>
                        <!-- End Sort Description -->
                    </div>
                    <!-- End Product Details -->

                    <!-- Product Form -->
                    <form method="post" action="#" class="product-form product-form-border hidedropdown">
                        <!-- Swatches -->
                        <div class="product-swatches-option">
                            <!-- Swatches Color -->
                            <div class="product-item swatches-image w-100 mb-4 swatch-0 option1" data-option-index="0">
                                <label class="label d-flex align-items-center">Color:<span class="slVariant ms-1 fw-bold">Blue</span></label>
                                <ul class="variants-clr swatches d-flex-center pt-1 clearfix">
                                    <li class="swatch x-large radius available blue"><span class="swatchLbl" data-bs-toggle="tooltip" data-bs-placement="top" title="Blue"></span></li>
                                    <li class="swatch x-large radius available purple"><span class="swatchLbl" data-bs-toggle="tooltip" data-bs-placement="top" title="Purple"></span></li>
                                    <li class="swatch x-large radius available green"><span class="swatchLbl" data-bs-toggle="tooltip" data-bs-placement="top" title="Green"></span></li>
                                    <li class="swatch x-large radius soldout yellow"><span class="swatchLbl" data-bs-toggle="tooltip" data-bs-placement="top" title="Yellow"></span></li>
                                </ul>
                            </div>
                            <!-- End Swatches Color -->
                            <!-- Swatches Size -->
                            <div class="product-item swatches-size w-100 mb-4 swatch-1 option2" data-option-index="1">
                                <label class="label d-flex align-items-center">Size:<span class="slVariant ms-1 fw-bold">S</span> <a href="#sizechart-modal" class="text-link sizelink text-muted size-chart-modal" data-bs-toggle="modal" data-bs-target="#sizechart_modal">Size Guide</a></label>
                                <ul class="variants-size size-swatches d-flex-center pt-1 clearfix">
                                    <li class="swatch x-large radius soldout"><span class="swatchLbl" data-bs-toggle="tooltip" data-bs-placement="top" title="XS">XS</span></li>
                                    <li class="swatch x-large radius available active"><span class="swatchLbl" data-bs-toggle="tooltip" data-bs-placement="top" title="S">S</span></li>
                                    <li class="swatch x-large radius available"><span class="swatchLbl" data-bs-toggle="tooltip" data-bs-placement="top" title="M">M</span></li>
                                    <li class="swatch x-large radius available"><span class="swatchLbl" data-bs-toggle="tooltip" data-bs-placement="top" title="L">L</span></li>
                                    <li class="swatch x-large radius available"><span class="swatchLbl" data-bs-toggle="tooltip" data-bs-placement="top" title="XL">XL</span></li>
                                </ul>
                            </div>
                            <!-- End Swatches Size -->
                        </div>
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
                                    <span class="d-flex-center stockLbl instock text-uppercase"><i class="icon anm anm-check-cil"></i> In stock</span>
                                </div>
                            </div>
                            <!-- End Product Quantity -->

                            <!-- Product Add -->
                            <div class="product-form-submit addcart fl-1 ms-0 mt-3">
                                <button type="submit" name="add" class="btn btn-secondary product-form-cart-submit"><span>Add to cart</span></button>
                            </div>
                            <!-- Product Add -->
                            <!-- Product Buy -->
                            <div class="product-form-submit buyit fl-1 ms-3 mt-3">
                                <button type="submit" class="btn btn-primary proceed-to-checkout"><span>Buy it now</span></button>
                            </div>
                            <!-- End Product Buy -->
                        </div>
                        <!-- End Product Action -->

                        <!-- Product Info link -->
                        <p class="infolinks d-flex-center justify-content-between">
                            <a class="text-link wishlist" href="wishlist-style1.html"><i class="icon anm anm-heart-l me-2"></i> <span>Add to Wishlist</span></a>
                            <a class="text-link compare" href="compare-style1.html"><i class="icon anm anm-sync-ar me-2"></i> <span>Add to Compare</span></a>
                            <a href="#shippingInfo-modal" class="text-link shippingInfo" data-bs-toggle="modal" data-bs-target="#shippingInfo_modal"><i class="icon anm anm-paper-l-plane me-2"></i> <span>Delivery &amp; Returns</span></a>
                            <a href="#productInquiry-modal" class="text-link emaillink me-0" data-bs-toggle="modal" data-bs-target="#productInquiry_modal"><i class="icon anm anm-question-cil me-2"></i> <span>Enquiry</span></a>
                        </p>
                        <!-- End Product Info link -->
                    </form>
                    <!-- End Product Form -->

                    <!-- Product Info -->
                    <div class="product-info">
                        <p class="product-vendor">Vendor:<span class="text"><a href="#">Levis</a></span></p>
                        <p class="product-type">Product Type:<span class="text">Shorts</span></p>
                        <p class="product-sku">SKU:<span class="text">RF104123</span></p>
                        <p class="product-cat">Category: <span><a href="#">Fashion</a>, <a href="#">Tops</a>, <a href="#">Women</a>, <a href="#">New Arrivals</a></span></p>
                        <p class="product-tags mb-3">Tags: <span><a href="#">$10 - $100</a>, <a href="#">Green</a>, <a href="#">XL</a>, <a href="#">Sale</a>, <a href="#">Women</a></span></p>
                    </div>
                    <!-- End Product Info -->

                    <!-- Product Info -->
                    <div class="userViewMsg featureText" data-user="20" data-time="11000"><i class="icon anm anm-eye-r"></i><b class="uersView">21</b> People are Looking for this Product</div>
                    <div class="shippingMsg featureText"><i class="icon anm anm-clock-r"></i>Estimated Delivery Between <b id="fromDate">Wed, May 1</b> and <b id="toDate">Tue, May 7</b>.</div>
                    <div class="freeShipMsg featureText" data-price="199"><i class="icon anm anm-truck-r"></i>Spent <b class="freeShip"><span class="money" data-currency-usd="$199.00" data-currency="USD">$199.00</span></b> More for Free shipping</div>
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
        <div class="tabs-listing section pb-0">
            <ul class="product-tabs style2 list-unstyled d-flex-wrap d-flex-justify-center d-none d-md-flex">
                <li rel="description" class="active"><a class="tablink">Description</a></li>
                <li rel="additionalInformation"><a class="tablink">Additional Information</a></li>
                <li rel="size-chart"><a class="tablink">Size Chart</a></li>
                <li rel="shipping-return"><a class="tablink">Shipping &amp; Return</a></li>
                <li rel="reviews"><a class="tablink">Reviews</a></li>
            </ul>

            <div class="tab-container">
                <!--Description-->
                <h3 class="tabs-ac-style d-md-none active" rel="description">Description</h3>
                <div id="description" class="tab-content">
                    <div class="product-description">
                        <div class="row">
                            <div class="col-12 col-sm-12 col-md-12 col-lg-12 mb-0 mb-md-0">
                                <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. the majority have suffered alteration in some form randomised words which don't look even slightly believable.</p>
                                <h4 class="mb-3">Features</h4>
                                <ul class="checkmark-info">
                                    <li>High quality fabric, very comfortable to touch and wear.</li>
                                    <li>This cardigan sweater is cute for no reason,perfect for travel and casual.</li>
                                    <li>It can tie in front-is forgiving to you belly or tie behind.</li>
                                    <li>Light weight and perfect for layering.</li>
                                </ul>
                                <h4 class="mb-3">Fabric</h4>
                                <p>All the Lorem Ipsum generators on the Internet tend to repeat predefined chunks as necessary, making this the first true generator on the Internet. It uses a dictionary of over 200 Latin words. There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, or randomised words which don't look even slightly believable. If you are going to use a passage.</p>
                            </div>
                        </div>
                    </div>
                </div>
                <!--End Description-->

                <!--Additional Information-->
                <h3 class="tabs-ac-style d-md-none" rel="additionalInformation">Additional Information</h3>
                <div id="additionalInformation" class="tab-content">
                    <div class="product-description">
                        <div class="row">
                            <div class="col-12 col-sm-12 col-md-12 col-lg-12 mb-4 mb-md-0">
                                <div class="table-responsive">
                                    <table class="table table-bordered align-middle table-part mb-0">
                                        <tr>
                                            <th>Color</th>
                                            <td>Black, White, Blue, Red, Gray</td>
                                        </tr>
                                        <tr>
                                            <th>Product Dimensions</th>
                                            <td>15 x 15 x 3 cm; 250 Grams</td>
                                        </tr>
                                        <tr>
                                            <th>Date First Available</th>
                                            <td>14 May 2023</td>
                                        </tr>
                                        <tr>
                                            <th>Manufacturer</th>
                                            <td>Fashion and Retail Limited</td>
                                        </tr>
                                        <tr>
                                            <th>Department</th>
                                            <td>Men Shirt</td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!--End Additional Information-->

                <!--Size Chart-->
                <h3 class="tabs-ac-style d-md-none" rel="size-chart">Size Chart</h3>
                <div id="size-chart" class="tab-content">
                    <h4 class="mb-2">Ready to Wear Clothing</h4>
                    <p class="mb-4">This is a standardised guide to give you an idea of what size you will need, however some brands may vary from these conversions.</p>
                    <div class="size-chart-tbl table-responsive px-1">
                        <table class="table-bordered align-middle mb-0">
                            <thead>
                                <tr>
                                    <th>Size</th>
                                    <th>XXS - XS</th>
                                    <th>XS - S</th>
                                    <th>S - M</th>
                                    <th>M - L</th>
                                    <th>L - XL</th>
                                    <th>XL - XXL</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <th>UK</th>
                                    <td>6</td>
                                    <td>8</td>
                                    <td>10</td>
                                    <td>12</td>
                                    <td>14</td>
                                    <td>16</td>
                                </tr>
                                <tr>
                                    <th>US</th>
                                    <td>2</td>
                                    <td>4</td>
                                    <td>6</td>
                                    <td>8</td>
                                    <td>10</td>
                                    <td>12</td>
                                </tr>
                                <tr>
                                    <th>Italy (IT)</th>
                                    <td>38</td>
                                    <td>40</td>
                                    <td>42</td>
                                    <td>44</td>
                                    <td>46</td>
                                    <td>48</td>
                                </tr>
                                <tr>
                                    <th>France (FR/EU)</th>
                                    <td>34</td>
                                    <td>36</td>
                                    <td>38</td>
                                    <td>40</td>
                                    <td>42</td>
                                    <td>44</td>
                                </tr>
                                <tr>
                                    <th>Denmark</th>
                                    <td>32</td>
                                    <td>34</td>
                                    <td>36</td>
                                    <td>38</td>
                                    <td>40</td>
                                    <td>42</td>
                                </tr>
                                <tr>
                                    <th>Russia</th>
                                    <td>40</td>
                                    <td>42</td>
                                    <td>44</td>
                                    <td>46</td>
                                    <td>48</td>
                                    <td>50</td>
                                </tr>
                                <tr>
                                    <th>Germany</th>
                                    <td>32</td>
                                    <td>34</td>
                                    <td>36</td>
                                    <td>38</td>
                                    <td>40</td>
                                    <td>42</td>
                                </tr>
                                <tr>
                                    <th>Japan</th>
                                    <td>5</td>
                                    <td>7</td>
                                    <td>9</td>
                                    <td>11</td>
                                    <td>13</td>
                                    <td>15</td>
                                </tr>
                                <tr>
                                    <th>Australia</th>
                                    <td>6</td>
                                    <td>8</td>
                                    <td>10</td>
                                    <td>12</td>
                                    <td>14</td>
                                    <td>16</td>
                                </tr>
                                <tr>
                                    <th>Korea</th>
                                    <td>33</td>
                                    <td>44</td>
                                    <td>55</td>
                                    <td>66</td>
                                    <td>77</td>
                                    <td>88</td>
                                </tr>
                                <tr>
                                    <th>China</th>
                                    <td>160/84</td>
                                    <td>165/86</td>
                                    <td>170/88</td>
                                    <td>175/90</td>
                                    <td>180/92</td>
                                    <td>185/94</td>
                                </tr>
                                <tr>
                                    <th>Jeans</th>
                                    <td>24-25</td>
                                    <td>26-27</td>
                                    <td>27-28</td>
                                    <td>29-30</td>
                                    <td>31-32</td>
                                    <td>32-33</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <!--End Size Chart-->

                <!--Shipping &amp; Return-->
                <h3 class="tabs-ac-style d-md-none" rel="shipping-return">Shipping &amp; Return</h3>
                <div id="shipping-return" class="tab-content">
                    <h4 class="pb-1">Shipping &amp; Return</h4>
                    <ul class="checkmark-info">
                        <li>Dispatch: Within 24 Hours</li>
                        <li>1 Year Brand Warranty</li>
                        <li>Free shipping across all products on a minimum purchase of $50.</li>
                        <li>International delivery time - 7-10 business days</li>
                        <li>Cash on delivery might be available</li>
                        <li>Easy 30 days returns and exchanges</li>
                    </ul>
                    <h4 class="pt-1">Free and Easy Returns</h4>
                    <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged.</p>
                    <h4 class="pt-1">Special Financing</h4>
                    <p>There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, or randomised words which don't look even slightly believable. If you are going to use a passage.</p>
                </div>
                <!--End Shipping &amp; Return-->

                <!--Review-->
                <h3 class="tabs-ac-style d-md-none" rel="reviews">Review</h3>
                <div id="reviews" class="tab-content">
                    <div class="row">
                        <div class="col-12 col-sm-12 col-md-12 col-lg-6 mb-4">
                            <div class="ratings-main">
                                <div class="avg-rating d-flex-center mb-3">
                                    <h4 class="avg-mark">5.0</h4>
                                    <div class="avg-content ms-3">
                                        <p class="text-rating">Average Rating</p>
                                        <div class="ratings-full product-review">
                                            <a class="reviewLink d-flex-center" href="#reviews"><i class="icon anm anm-star"></i><i class="icon anm anm-star"></i><i class="icon anm anm-star"></i><i class="icon anm anm-star"></i><i class="icon anm anm-star-o"></i><span class="caption ms-2">24 Ratings</span></a>
                                        </div>
                                    </div>
                                </div>

                                <div class="ratings-list">
                                    <div class="ratings-container d-flex align-items-center mt-1">
                                        <div class="ratings-full product-review m-0">
                                            <a class="reviewLink d-flex align-items-center" href="#reviews"><i class="icon anm anm-star"></i><i class="icon anm anm-star"></i><i class="icon anm anm-star"></i><i class="icon anm anm-star"></i><i class="icon anm anm-star-o"></i></a>
                                        </div>
                                        <div class="progress">
                                            <div class="progress-bar" role="progressbar" aria-valuenow="99" aria-valuemin="0" aria-valuemax="100" style="width:99%;"></div>
                                        </div>
                                        <div class="progress-value">99%</div>
                                    </div>
                                    <div class="ratings-container d-flex align-items-center mt-1">
                                        <div class="ratings-full product-review m-0">
                                            <a class="reviewLink d-flex align-items-center" href="#reviews"><i class="icon anm anm-star"></i><i class="icon anm anm-star"></i><i class="icon anm anm-star"></i><i class="icon anm anm-star"></i><i class="icon anm anm-star-o"></i></a>
                                        </div>
                                        <div class="progress">
                                            <div class="progress-bar" role="progressbar" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100" style="width:75%;"></div>
                                        </div>
                                        <div class="progress-value">75%</div>
                                    </div>
                                    <div class="ratings-container d-flex align-items-center mt-1">
                                        <div class="ratings-full product-review m-0">
                                            <a class="reviewLink d-flex align-items-center" href="#reviews"><i class="icon anm anm-star"></i><i class="icon anm anm-star"></i><i class="icon anm anm-star"></i><i class="icon anm anm-star-o"></i><i class="icon anm anm-star-o"></i></a>
                                        </div>
                                        <div class="progress">
                                            <div class="progress-bar" role="progressbar" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100" style="width:50%;"></div>
                                        </div>
                                        <div class="progress-value">50%</div>
                                    </div>
                                    <div class="ratings-container d-flex align-items-center mt-1">
                                        <div class="ratings-full product-review m-0">
                                            <a class="reviewLink d-flex align-items-center" href="#reviews"><i class="icon anm anm-star"></i><i class="icon anm anm-star"></i><i class="icon anm anm-star-o"></i><i class="icon anm anm-star-o"></i><i class="icon anm anm-star-o"></i></a>
                                        </div>
                                        <div class="progress">
                                            <div class="progress-bar" role="progressbar" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100" style="width:25%;"></div>
                                        </div>
                                        <div class="progress-value">25%</div>
                                    </div>
                                    <div class="ratings-container d-flex align-items-center mt-1">
                                        <div class="ratings-full product-review m-0">
                                            <a class="reviewLink d-flex align-items-center" href="#reviews"><i class="icon anm anm-star"></i><i class="icon anm anm-star-o"></i><i class="icon anm anm-star-o"></i><i class="icon anm anm-star-o"></i><i class="icon anm anm-star-o"></i></a>
                                        </div>
                                        <div class="progress">
                                            <div class="progress-bar" role="progressbar" aria-valuenow="5" aria-valuemin="0" aria-valuemax="100" style="width:5%;"></div>
                                        </div>
                                        <div class="progress-value">05%</div>
                                    </div>
                                </div>
                            </div>
                            <hr />
                            <div class="spr-reviews">
                                <h3 class="spr-form-title">Customer Reviews</h3>
                                <div class="review-inner">
                                    <div class="spr-review d-flex w-100">
                                        <div class="spr-review-profile flex-shrink-0">
                                            <img class="blur-up lazyload" data-src="assets/images/users/user-img1.jpg" src="assets/images/users/user-img3.jpg" alt="" width="200" height="200" />
                                        </div>
                                        <div class="spr-review-content flex-grow-1">
                                            <div class="d-flex justify-content-between flex-column mb-2">
                                                <div class="title-review d-flex align-items-center justify-content-between">
                                                    <h5 class="spr-review-header-title text-transform-none mb-0">Eleanor Pena</h5>
                                                    <span class="product-review spr-starratings m-0"><span class="reviewLink"><i class="icon anm anm-star"></i><i class="icon anm anm-star"></i><i class="icon anm anm-star"></i><i class="icon anm anm-star"></i><i class="icon anm anm-star"></i></span></span>
                                                </div>
                                            </div>
                                            <b class="head-font">Good and High quality</b>
                                            <p class="spr-review-body">There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour.</p>
                                        </div>
                                    </div>
                                    <div class="spr-review d-flex w-100">
                                        <div class="spr-review-profile flex-shrink-0">
                                            <img class="blur-up lazyload" data-src="assets/images/users/testimonial1.jpg" src="assets/images/users/testimonial3.jpg" alt="" width="200" height="200" />
                                        </div>
                                        <div class="spr-review-content flex-grow-1">
                                            <div class="d-flex justify-content-between flex-column mb-2">
                                                <div class="title-review d-flex align-items-center justify-content-between">
                                                    <h5 class="spr-review-header-title text-transform-none mb-0">Courtney Henry</h5>
                                                    <span class="product-review spr-starratings m-0"><span class="reviewLink"><i class="icon anm anm-star"></i><i class="icon anm anm-star"></i><i class="icon anm anm-star"></i><i class="icon anm anm-star-o"></i><i class="icon anm anm-star-o"></i></span></span>
                                                </div>
                                            </div>
                                            <b class="head-font">Feature Availability</b>
                                            <p class="spr-review-body">The standard chunk of Lorem Ipsum used since the 1500s is reproduced below for those interested. Sections 1.10.32 and 1.10.33</p>
                                        </div>
                                    </div>
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
    <!--Recently Viewed Products-->
    <section class="section product-slider pb-0">
        <div class="container">
            <div class="section-header">
                <p class="mb-1 mt-0">Explore Similar</p>
                <h2>You may also like this products</h2>
            </div>
            <!--Product Grid-->
            <div class="product-slider-4items gp10 arwOut5 grid-products">
                <div class="item col-item">
                    <div class="product-box">
                        <!-- Start Product Image -->
                        <div class="product-image">
                            <!-- Start Product Image -->
                            <a href="product-layout1.html" class="product-img">
                                <!-- Image -->
                                <img class="primary blur-up lazyload" data-src="assets/images/products/product10.jpg" src="assets/images/products/product10.jpg" alt="Product" title="Product" width="625" height="808" />
                                <!-- End Image -->
                                <!-- Hover Image -->
                                <img class="hover blur-up lazyload" data-src="assets/images/products/product10-1.jpg" src="assets/images/products/product10-1.jpg" alt="Product" title="Product" width="625" height="808" />
                                <!-- End Hover Image -->
                            </a>
                            <!-- End Product Image -->
                            <!--Product Button-->
                            <div class="button-set style1">
                                <!--Cart Button-->
                                <a href="#addtocart-modal" class="btn-icon addtocart add-to-cart-modal" data-bs-toggle="modal" data-bs-target="#addtocart_modal">
                                    <span class="icon-wrap d-flex-justify-center h-100 w-100" data-bs-toggle="tooltip" data-bs-placement="left" title="Add to Cart"><i class="icon anm anm-cart-l"></i><span class="text">Add to Cart</span></span>
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
                            <!-- Product Name -->
                            <div class="product-name">
                                <a href="product-layout1.html">Silver Color Couple Rings</a>
                            </div>
                            <!-- End Product Name -->
                            <!-- Product Price -->
                            <div class="product-price">
                                <span class="price">$199.00</span>
                            </div>
                            <!-- End Product Price -->
                            <!-- Product Review -->
                            <div class="product-review">
                                <i class="icon anm anm-star"></i><i class="icon anm anm-star"></i><i class="icon anm anm-star"></i><i class="icon anm anm-star"></i><i class="icon anm anm-star"></i>
                                <span class="caption hidden ms-1">7 Reviews</span>
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
                                <img class="primary blur-up lazyload" data-src="assets/images/products/product6.jpg" src="assets/images/products/product6.jpg" alt="Product" title="Product" width="625" height="808" />
                                <!-- End Image -->
                                <!-- Hover Image -->
                                <img class="hover blur-up lazyload" data-src="assets/images/products/product6-1.jpg" src="assets/images/products/product6-1.jpg" alt="Product" title="Product" width="625" height="808" />
                                <!-- End Hover Image -->
                            </a>
                            <!-- End Product Image -->
                            <!-- Product label -->
                            <div class="product-labels"><span class="lbl on-sale">Sold out</span></div>
                            <!-- End Product label -->
                            <!--Product Button-->
                            <div class="button-set style1">
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
                            <!-- Product Name -->
                            <div class="product-name">
                                <a href="product-layout1.html">Floral Cuff Blouse</a>
                            </div>
                            <!-- End Product Name -->
                            <!-- Product Price -->
                            <div class="product-price">
                                <span class="price">$199.00</span>
                            </div>
                            <!-- End Product Price -->
                            <!-- Product Review -->
                            <div class="product-review">
                                <i class="icon anm anm-star"></i><i class="icon anm anm-star"></i><i class="icon anm anm-star"></i><i class="icon anm anm-star-o"></i><i class="icon anm anm-star-o"></i>
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
                                <img class="primary blur-up lazyload" data-src="assets/images/products/product7.jpg" src="assets/images/products/product7.jpg" alt="Product" title="Product" width="625" height="808" />
                                <!-- End Image -->
                                <!-- Hover Image -->
                                <img class="hover blur-up lazyload" data-src="assets/images/products/product7-1.jpg" src="assets/images/products/product7-1.jpg" alt="Product" title="Product" width="625" height="808" />
                                <!-- End Hover Image -->
                            </a>
                            <!-- End Product Image -->
                            <!--Product Button-->
                            <div class="button-set style1">
                                <!--Cart Button-->
                                <a href="#addtocart-modal" class="btn-icon addtocart add-to-cart-modal" data-bs-toggle="modal" data-bs-target="#addtocart_modal">
                                    <span class="icon-wrap d-flex-justify-center h-100 w-100" data-bs-toggle="tooltip" data-bs-placement="left" title="Add to Cart"><i class="icon anm anm-cart-l"></i><span class="text">Add to Cart</span></span>
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
                            <!-- Product Name -->
                            <div class="product-name">
                                <a href="product-layout1.html">High-Waisted Pant</a>
                            </div>
                            <!-- End Product Name -->
                            <!-- Product Price -->
                            <div class="product-price">
                                <span class="price">$159.00</span>
                            </div>
                            <!-- End Product Price -->
                            <!-- Product Review -->
                            <div class="product-review">
                                <i class="icon anm anm-star"></i><i class="icon anm anm-star"></i><i class="icon anm anm-star-o"></i><i class="icon anm anm-star-o"></i><i class="icon anm anm-star-o"></i>
                                <span class="caption hidden ms-1">18 Reviews</span>
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
                                <img class="primary blur-up lazyload" data-src="assets/images/products/product8.jpg" src="assets/images/products/product8.jpg" alt="Product" title="Product" width="625" height="808" />
                                <!-- End Image -->
                                <!-- Hover Image -->
                                <img class="hover blur-up lazyload" data-src="assets/images/products/product8-1.jpg" src="assets/images/products/product8-1.jpg" alt="Product" title="Product" width="625" height="808" />
                                <!-- End Hover Image -->
                            </a>
                            <!-- End Product Image -->
                            <!--Product Button-->
                            <div class="button-set style1">
                                <!--Cart Button-->
                                <a href="#addtocart-modal" class="btn-icon addtocart add-to-cart-modal" data-bs-toggle="modal" data-bs-target="#addtocart_modal">
                                    <span class="icon-wrap d-flex-justify-center h-100 w-100" data-bs-toggle="tooltip" data-bs-placement="left" title="Add to Cart"><i class="icon anm anm-cart-l"></i><span class="text">Add to Cart</span></span>
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
                            <!-- Product Name -->
                            <div class="product-name">
                                <a href="product-layout1.html">Lace Trainers Shoes</a>
                            </div>
                            <!-- End Product Name -->
                            <!-- Product Price -->
                            <div class="product-price">
                                <span class="price">$134.00</span>
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
                                <img class="primary blur-up lazyload" data-src="assets/images/products/product9.jpg" src="assets/images/products/product9.jpg" alt="Product" title="Product" width="625" height="808" />
                                <!-- End Image -->
                                <!-- Hover Image -->
                                <img class="hover blur-up lazyload" data-src="assets/images/products/product9-1.jpg" src="assets/images/products/product9-1.jpg" alt="Product" title="Product" width="625" height="808" />
                                <!-- End Hover Image -->
                            </a>
                            <!-- End Product Image -->
                            <!-- Product label -->
                            <div class="product-labels"><span class="lbl pr-label4">Popular</span></div>
                            <!-- End Product label -->
                            <!--Product Button-->
                            <div class="button-set style1">
                                <!--Cart Button-->
                                <a href="#addtocart-modal" class="btn-icon addtocart add-to-cart-modal" data-bs-toggle="modal" data-bs-target="#addtocart_modal">
                                    <span class="icon-wrap d-flex-justify-center h-100 w-100" data-bs-toggle="tooltip" data-bs-placement="left" title="Add to Cart"><i class="icon anm anm-cart-l"></i><span class="text">Add to Cart</span></span>
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
                            <!-- Product Name -->
                            <div class="product-name">
                                <a href="product-layout1.html">Portable Auto Foam Lance</a>
                            </div>
                            <!-- End Product Name -->
                            <!-- Product Price -->
                            <div class="product-price">
                                <span class="price">$199.00</span>
                            </div>
                            <!-- End Product Price -->
                            <!-- Product Review -->
                            <div class="product-review">
                                <i class="icon anm anm-star"></i><i class="icon anm anm-star"></i><i class="icon anm anm-star"></i><i class="icon anm anm-star-o"></i><i class="icon anm anm-star-o"></i>
                                <span class="caption hidden ms-1">19 Reviews</span>
                            </div>
                            <!-- End Product Review -->
                        </div>
                        <!-- End product details -->
                    </div>
                </div>
            </div>
            <!--End Product Grid-->
        </div>
    </section>
    <!--End Recently Viewed Products-->