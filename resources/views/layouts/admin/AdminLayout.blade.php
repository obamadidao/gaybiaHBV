<!doctype html>
<html lang="en">
<!--begin::Head-->
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>HBV BilliardShop</title>
<!--begin::Primary Meta Tags-->
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<meta name="title" content="HBV BilliardShop" />
<meta name="author" content="HBV BilliardShop" />
<meta
name="description"
content="HBV BilliardShop"
/>
<meta
name="keywords"
content="bootstrap 5, bootstrap, bootstrap 5 admin dashboard, bootstrap 5 dashboard, bootstrap 5 charts, bootstrap 5 calendar, bootstrap 5 datepicker, bootstrap 5 tables, bootstrap 5 datatable, vanilla js datatable, colorlibhq, colorlibhq dashboard, colorlibhq admin dashboard"
/>
<!--end::Primary Meta Tags-->
<!--begin::Fonts-->
<link
rel="stylesheet"
href="https://cdn.jsdelivr.net/npm/@fontsource/source-sans-3@5.0.12/index.css"
integrity="sha256-tXJfXfp6Ewt1ilPzLDtQnJV4hclT9XuaZUKyUvmyr+Q="
crossorigin="anonymous"
/>
<!--end::Fonts-->
<!--begin::Third Party Plugin(OverlayScrollbars)-->
<link
rel="stylesheet"
href="https://cdn.jsdelivr.net/npm/overlayscrollbars@2.10.1/styles/overlayscrollbars.min.css"
integrity="sha256-tZHrRjVqNSRyWg2wbppGnT833E/Ys0DHWGwT04GiqQg="
crossorigin="anonymous"
/>
<!--end::Third Party Plugin(OverlayScrollbars)-->
<!--begin::Third Party Plugin(Bootstrap Icons)-->
<link
rel="stylesheet"
href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css"
integrity="sha256-9kPW/n5nn53j4WMRYAxe9c1rCY96Oogo/MKSVdKzPmI="
crossorigin="anonymous"
/>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
<!--end::Third Party Plugin(Bootstrap Icons)-->
<!--begin::Required Plugin(AdminLTE)-->
<link rel="stylesheet" href="{{ asset('dist/css/adminlte.css') }}" />
<!--end::Required Plugin(AdminLTE)-->

<!--begin::Scripts-->
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<!--end::Scripts-->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css">
@stack('styles')
</head>
<!--end::Head-->
<!--begin::Body-->
<body class="layout-fixed sidebar-expand-lg bg-body-tertiary">
<!--begin::App Wrapper-->
<div class="app-wrapper">
<!--begin::Header-->
@include('layouts.admin.blocks.header')
<!--end::Header-->
<!--begin::Sidebar-->
@include('layouts.admin.blocks.aside')
<!--end::Sidebar-->
<!--begin::App Main-->
<main class="app-main">
<!--begin::App Content Header-->
<div class="app-content-header">
<!--begin::Container-->
<div class="container-fluid">
<!--begin::Row-->
<div class="row">
<div class="col-sm-6"><h3 class="mb-0">@yield('title-page')</h3></div>
</div>
<!--end::Row-->
</div>
<!--end::Container-->
</div>
<!--end::App Content Header-->
<!--begin::App Content-->
<div class="app-content">
<!--begin::Container-->
<div class="container-fluid">
<!--begin::Row-->
@yield('content')
<!--end::Row-->
</div>
<!--end::Container-->
</div>
<!--end::App Content-->
</main>
<!--end::App Main-->
<!--begin::Footer-->
@include('layouts.admin.blocks.footer')
<!--end::Footer-->
</div>
<!--end::App Wrapper-->

<!--begin::Script-->
<script src="https://cdn.jsdelivr.net/npm/overlayscrollbars@2.10.1/browser/overlayscrollbars.browser.es6.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"></script>
<script src="{{ asset('dist/js/adminlte.js') }}"></script>
<script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>
<!--end::Script-->
    <script src="https://cdn.jsdelivr.net/npm/chart.js@2.9.4/dist/Chart.min.js"></script>

@stack('scripts')

    <script src="https://cdn.jsdelivr.net/npm/chart.js@2.9.4/dist/Chart.min.js"></script>
</body>
<!--end::Body-->
</html>