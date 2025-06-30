<!DOCTYPE html>
<html class="no-js" lang="en">
    
<!-- Mirrored from www.annimexweb.com/items/hema/index5-tools-parts.html by HTTrack Website Copier/3.x [XR&CO'2014], Sun, 22 Jun 2025 15:17:43 GMT -->
<head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta http-equiv="x-ua-compatible" content="ie=edge">
        <meta name="description" content="description">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- Title Of Site -->
        <title>Home 05 Tools &amp; Parts - Hema Multipurpose eCommerce Bootstrap 5 Html Template</title>
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
            <!-- Main JS -->
            <script src="{{ asset('assets/js/main.js') }}"></script>

        </div>
        <!--End Page Wrapper-->
    </body>

<!-- Mirrored from www.annimexweb.com/items/hema/index5-tools-parts.html by HTTrack Website Copier/3.x [XR&CO'2014], Sun, 22 Jun 2025 15:18:29 GMT -->
</html>