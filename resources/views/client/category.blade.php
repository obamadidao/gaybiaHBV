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
                <div class="breadcrumbs">
                    <a href="{{ route('client.index') }}" title="Back to the home page">Trang chủ</a>
                    @if(isset($query))
                    <span class="title"><i class="icon anm anm-angle-right-l"></i>Tìm kiếm</span>
                    <span class="main-title"><i class="icon anm anm-angle-right-l"></i>{{ $query }}</span>
                    @else
                    <span class="title"><i class="icon anm anm-angle-right-l"></i>Danh mục</span>
                    <span class="main-title"><i class="icon anm anm-angle-right-l"></i>{{ $category->name }}</span>
                    @endif
                </div>
                <!--End Breadcrumbs-->
            </div>
        </div>
    </div>
</div>
<!--End Page Header-->

<!--Main Content-->
<div class="container">
    @if(!isset($query) && $category->children->count() > 0)
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
    @endif

    @if(isset($query))
    <!--Search Info-->
    <div class="search-results-info mb-4">
        <div class="alert alert-info">
            <i class="fas fa-search me-2"></i>
            <strong>{{ $products->total() }}</strong> sản phẩm được tìm thấy cho từ khóa "<strong>{{ $query }}</strong>"
            @if($products->total() == 0)
            <br><small class="text-muted mt-2">Thử tìm kiếm với từ khóa khác hoặc <a href="{{ route('client.index') }}">xem tất cả sản phẩm</a></small>
            @endif
        </div>
    </div>
    <!--End Search Info-->
    @endif
    @if($products->count() > 0)
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

            <div class="col-8 col-sm-10 col-md-8 col-lg-8 text-right filters-toolbar-item d-flex justify-content-end order-0 order-sm-1">
                <div class="filters-item d-flex align-items-center">
                    <label class="mb-0 me-2 d-none d-lg-inline-block">Sắp xếp:</label>
                    <div class="select-box">
                        <select class="form-select" onchange="window.location.href=this.value">
                            @if(isset($query))
                            <option value="{{ route('client.search', ['query' => $query, 'sort' => 'relevance']) }}" {{ $sortBy == 'relevance' ? 'selected' : '' }}>Liên quan nhất</option>
                            <option value="{{ route('client.search', ['query' => $query, 'sort' => 'featured']) }}" {{ $sortBy == 'featured' ? 'selected' : '' }}>Nổi bật</option>
                            <option value="{{ route('client.search', ['query' => $query, 'sort' => 'name-asc']) }}" {{ $sortBy == 'name-asc' ? 'selected' : '' }}>Tên A-Z</option>
                            <option value="{{ route('client.search', ['query' => $query, 'sort' => 'name-desc']) }}" {{ $sortBy == 'name-desc' ? 'selected' : '' }}>Tên Z-A</option>
                            <option value="{{ route('client.search', ['query' => $query, 'sort' => 'price-asc']) }}" {{ $sortBy == 'price-asc' ? 'selected' : '' }}>Giá thấp đến cao</option>
                            <option value="{{ route('client.search', ['query' => $query, 'sort' => 'price-desc']) }}" {{ $sortBy == 'price-desc' ? 'selected' : '' }}>Giá cao đến thấp</option>
                            @else
                            <option value="{{ route('client.category', ['slug' => $category->slug, 'sort' => 'featured']) }}" {{ $sortBy == 'featured' ? 'selected' : '' }}>Mới nhất</option>
                            <option value="{{ route('client.category', ['slug' => $category->slug, 'sort' => 'name-asc']) }}" {{ $sortBy == 'name-asc' ? 'selected' : '' }}>Tên A-Z</option>
                            <option value="{{ route('client.category', ['slug' => $category->slug, 'sort' => 'name-desc']) }}" {{ $sortBy == 'name-desc' ? 'selected' : '' }}>Tên Z-A</option>
                            <option value="{{ route('client.category', ['slug' => $category->slug, 'sort' => 'price-asc']) }}" {{ $sortBy == 'price-asc' ? 'selected' : '' }}>Giá thấp đến cao</option>
                            <option value="{{ route('client.category', ['slug' => $category->slug, 'sort' => 'price-desc']) }}" {{ $sortBy == 'price-desc' ? 'selected' : '' }}>Giá cao đến thấp</option>
                            @endif
                        </select>
                    </div>
                </div>
            </div>

        </div>
    </div>
    <!--End Toolbar-->

    <div class="row mb-5">
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
                                <a href="{{ route('client.product', ['slug'=>$product->slug]) }}" class="product-img rounded-0"><img style="min-height: 250px;" class="rounded-0 blur-up lazyload" src="{{ $product->primaryImage->url }}" alt="{{ $product->name }}" title="{{ $product->name }}" width="625" height="808" /></a>
                                @if($product->primaryImage)
                                <a href="{{ route('client.product', ['slug'=>$product->slug]) }}" class="product-img rounded-0"><img style="min-height: 250px;" class="rounded-0 blur-up lazyload" src="{{ $product->primaryImage->url }}" alt="{{ $product->name }}" title="{{ $product->name }}" width="625" height="808" /></a>
                                @else
                                <a href="{{ route('client.product', ['slug'=>$product->slug]) }}" class="product-img rounded-0"><img style="min-height: 250px;" class="rounded-0 blur-up lazyload" src="{{ asset('assets/images/collection/category.jpg') }}" alt="{{ $product->name }}" title="{{ $product->name }}" width="625" height="808" /></a>
                                @endif
                                <!-- End Product Image -->
                                <!-- Product label -->
                                <div class="product-labels">
                                    @if($product->base_price !== $product->compare_price)
                                    <span class="lbl on-sale">Sale</span>
                                    @endif
                                    @if($product->is_featured)
                                    <span class="lbl pr-label2">HOT</span>
                                    @endif
                                </div>
                                <!-- End Product label -->
                                <!--Product Button-->
                                <div class="button-set style2">
                                    <a href="{{ route('client.product', ['slug'=>$product->slug]) }}" class="btn btn-primary">Mua ngay</a>
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
                                    <a href="{{ route('client.product', ['slug'=>$product->slug]) }}">{{$product->name}}</a>
                                </div>
                                <!-- End Product Name -->
                                <!-- Product Price -->
                                <div class="product-price">
                                    @if($product->base_price !== $product->compare_price)
                                    <span class="price old-price">{{number_format($product->compare_price, 0, ',', '.')}}đ</span><span class="price">{{number_format($product->base_price, 0, ',', '.')}}đ</span>
                                    @else
                                    <span class="price">{{number_format($product->base_price, 0, ',', '.')}}đ</span>
                                    @endif
                                </div>
                                <!-- End Product Price -->
                                <!-- Product Review -->
                                <div class="product-review">
                                    <i class="icon anm anm-star"></i><i class="icon anm anm-star"></i><i class="icon anm anm-star"></i><i class="icon anm anm-star"></i><i class="icon anm anm-star-o"></i>
                                    <span class="caption hidden ms-1">{{$product->reviews->count()}} đánh giá</span>
                                </div>
                                <!-- End Product Review -->
                                <!--End Sort Description-->
                                <!-- Product Button -->
                                <div class="button-action hidden">
                                    <div class="addtocart-btn">
                                        <form class="addtocart" action="{{ route('client.product', ['slug'=>$product->slug]) }}" method="post">
                                            <button type="submit" class="btn btn-md quick-shop quick-shop-modal">
                                                <i class="icon anm anm-cart-l me-2"></i><span class="text">Xem chi tiết</span>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <!-- End product details -->
                        </div>
                    </div>
                    @endforeach
                </div>

                <!-- Pagination -->
                <nav class="clearfix pagination-bottom">
                    <ul class="pagination justify-content-center">
                        {{ $products->links() }}
                        {{ $products->appends(request()->query())->links() }}
                    </ul>
                </nav>
                <!-- End Pagination -->
            </div>
            <!--End Product Grid-->
        </div>
        <!--End Products-->
    </div>
    @else
    <div class="row">
        <div class="col-12 col-sm-12 col-md-12 col-lg-12 main-col text-center">
            <div class="grid-products grid-view-items">
                <div class="row col-row product-options">
                    <div class="item col-item text-center">
                        <div class="product-box">
                            <div class="product-details text-center">
                                <div class="product-name text-center py-5">
                                    <h3 class="text-muted mb-3">Không có sản phẩm trong danh mục này</h3>
                                    <i class="fas fa-box-open fa-3x text-secondary mb-3"></i>
                                    <p class="text-secondary">Vui lòng quay lại sau hoặc xem các danh mục khác</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif
</div>
<!--End Main Content-->