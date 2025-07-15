<!DOCTYPE html>
<html class="no-js" lang="en">

<!-- Mirrored from www.annimexweb.com/items/hema/index5-tools-parts.html by HTTrack Website Copier/3.x [XR&CO'2014], Sun, 22 Jun 2025 15:17:43 GMT -->

<head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta http-equiv="x-ua-compatible" content="ie=edge">
        <meta name="description" content="description">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- Title Of Site -->
        <title>HBV Billiards</title>
        <!-- Favicon -->
        <link rel="shortcut icon" href="{{ asset('assets/images/favicon.png') }}" />
        <!-- Plugins CSS -->
        <link rel="stylesheet" href="{{ asset('assets/css/plugins.css') }}">
        <!-- Main Style CSS -->
        <link rel="stylesheet" href="{{ asset('assets/css/style-min.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/css/responsive.css') }}">
</head>

<body class="template-index index-demo5">
        <!--Page Wrapper-->
        <div class="page-wrapper">
                <!--Header-->
                @include('layouts.client.blocks.header')
                <!--End Header-->
                <!--Mobile Menu-->
                @include('layouts.client.blocks.navMobile')
                <!--End Mobile Menu-->

                <!-- Flash Messages -->
                @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show m-3" role="alert">
                        <strong>Thành công!</strong> {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                @endif

                @if (session('error'))
                <div class="alert alert-danger alert-dismissible fade show m-3" role="alert">
                        <strong>Lỗi!</strong> {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                @endif

                @if (session('warning'))
                <div class="alert alert-warning alert-dismissible fade show m-3" role="alert">
                        <strong>Cảnh báo!</strong> {{ session('warning') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                @endif

                @if (session('info'))
                <div class="alert alert-info alert-dismissible fade show m-3" role="alert">
                        <strong>Thông tin!</strong> {{ session('info') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                @endif

                <!-- Body Container -->
                @yield('content')
                <!-- End Body Container -->

                <!--Footer-->
                @include('layouts.client.blocks.footer')
                <!--End Footer-->

                <!--Scoll Top-->
                <div id="site-scroll"><i class="icon anm anm-arw-up"></i></div>
                <!--End Scoll Top-->

                <!--MiniCart Drawer-->
                @include('layouts.client.blocks.miniCart')
                <!--End MiniCart Drawer-->

                <!-- Including Jquery/Javascript -->
                <!-- Plugins JS -->
                <script src="{{ asset('assets/js/plugins.js') }}"></script>


                <script src="{{ asset('assets/js/vendor/jquery.elevatezoom.js') }}"></script>
                <script>
                        $(document).ready(function() {
                                /* Product Zoom */
                                function product_zoom() {
                                        $(".zoompro").elevateZoom({
                                                gallery: "gallery",
                                                galleryActiveClass: "active",
                                                zoomWindowWidth: 300,
                                                zoomWindowHeight: 100,
                                                scrollZoom: false,
                                                zoomType: "inner",
                                                cursor: "crosshair"
                                        });
                                }
                                product_zoom();
                        });
                </script>
  @stack('script')
                <!-- Main JS -->
                <script src="{{ asset('assets/js/main.js') }}"></script>

                <!-- Photoswipe Gallery JS -->
                <script src="{{ asset('assets/js/vendor/photoswipe.min.js') }}"></script>
                <script>
                        $(function() {
                                var $pswp = $('.pswp')[0],
                                        image = [],
                                        getItems = function() {
                                                var items = [];
                                                $('.lightboximages a').each(function() {
                                                        var $href = $(this).attr('href'),
                                                                $size = $(this).data('size').split('x'),
                                                                item = {
                                                                        src: $href,
                                                                        w: $size[0],
                                                                        h: $size[1]
                                                                };
                                                        items.push(item);
                                                });
                                                return items;
                                        };
                                var items = getItems();

                                $.each(items, function(index, value) {
                                        image[index] = new Image();
                                        image[index].src = value['src'];
                                });
                                $('.prlightbox').on('click', function(event) {
                                        event.preventDefault();

                                        var $index = $(".active-thumb").parent().attr('data-slick-index');
                                        $index++;
                                        $index = $index - 1;

                                        var options = {
                                                index: $index,
                                                bgOpacity: 0.7,
                                                showHideOpacity: true
                                        };
                                        var lightBox = new PhotoSwipe($pswp, PhotoSwipeUI_Default, items, options);
                                        lightBox.init();
                                });
                        });
                </script>
        </div>
        <!--End Page Wrapper-->
</body>

<!-- Mirrored from www.annimexweb.com/items/hema/index5-tools-parts.html by HTTrack Website Copier/3.x [XR&CO'2014], Sun, 22 Jun 2025 15:18:29 GMT -->