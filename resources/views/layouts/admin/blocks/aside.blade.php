<aside class="app-sidebar bg-body-secondary shadow" data-bs-theme="dark">
  <!--begin::Sidebar Brand-->
  <div class="sidebar-brand">
    <!--begin::Brand Link-->
    <a href="{{ route('home') }}" class="brand-link">
      <!--begin::Brand Image-->
      <img
        src="{{ asset('dist/assets/img/AdminLTELogo.png') }}"
        alt="AdminLTE Logo"
        class="brand-image opacity-75 shadow"
      />
      <!--end::Brand Image-->
      <!--begin::Brand Text-->
      <span class="brand-text fw-light">SHOP-BIDA</span>
      <!--end::Brand Text-->
    </a>
    <!--end::Brand Link-->
  </div>
  <!--end::Sidebar Brand-->
  <!--begin::Sidebar Wrapper-->
  <div class="sidebar-wrapper">
    <nav class="mt-2">
      <!--begin::Sidebar Menu-->
      <ul
        class="nav sidebar-menu flex-column"
        data-lte-toggle="treeview"
        role="menu"
        data-accordion="false"
      >
        <li class="nav-item">
          <a href="{{ route('admin.dashboard') }}" class="nav-link">
            <i class="nav-icon bi bi-palette"></i>
            <p>Trang chủ</p>
          </a>
        </li>

        <li class="nav-item">
          <a href="" class="nav-link">
            <i class="nav-icon bi bi-palette"></i>
            <p>Danh mục</p>
          </a>
        </li>

        <li class="nav-item">
          <a href="" class="nav-link">
            <i class="nav-icon bi bi-images"></i>
            <p>Banner</p>
          </a>
        </li>

        <li class="nav-item">
          <a href="" class="nav-link">
            <i class="nav-icon bi bi-palette"></i>
            <p>Sản phẩm</p>
          </a>
        </li>

        {{-- <li class="nav-item">
          <a href="#" class="nav-link">
            <i class="nav-icon bi bi-speedometer"></i>
            <p>
              Dashboard
              <i class="nav-arrow bi bi-chevron-right"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="../index.html" class="nav-link">
                <i class="nav-icon bi bi-circle"></i>
                <p>Dashboard v1</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="../index2.html" class="nav-link">
                <i class="nav-icon bi bi-circle"></i>
                <p>Dashboard v2</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="../index3.html" class="nav-link">
                <i class="nav-icon bi bi-circle"></i>
                <p>Dashboard v3</p>
              </a>
            </li>
          </ul>
        </li> --}}
        
        
      </ul>
      <!--end::Sidebar Menu-->
    </nav>
  </div>
  <!--end::Sidebar Wrapper-->
</aside>