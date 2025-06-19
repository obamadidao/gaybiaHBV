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
<span class="brand-text fw-light">HBV BilliardShop</span>
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
<i class="nav-icon bi bi-speedometer2"></i>
<p>Trang chủ</p>
</a>
</li>

<li class="nav-item">
<a href="{{ route('admin.categories.index') }}" class="nav-link">
<i class="nav-icon bi bi-list-ul"></i>
<p>Danh mục</p>
</a>
</li>

<li class="nav-item">          
<a href="{{ route('admin.products.index') }}" class="nav-link">            
<i class="nav-icon bi bi-box"></i>       
<p>Sản phẩm</p>          
</a>        
</li>

<li class="nav-item">          
<a href="{{ route('admin.inventory.index') }}" class="nav-link">            
<i class="nav-icon bi bi-building"></i>           
<p>Kho hàng</p>          
</a>        
</li>

<li class="nav-item">
<a href="{{ route('admin.customers.index') }}" class="nav-link">
<i class="nav-icon bi bi-people"></i>
<p>Khách hàng</p>
</a>
</li>

<li class="nav-item">          
<a href="{{ route('admin.product-reviews.index') }}" class="nav-link">            
<i class="nav-icon bi bi-chat-square-text"></i>            
<p>Đánh giá</p>          
</a>        
</li>   

<li class="nav-item">          
<a href="{{ route('admin.orders.index') }}" class="nav-link">            
<i class="nav-icon bi bi-cart"></i>            
<p>Đơn hàng</p>          
</a>        
</li>     

<li class="nav-item">          
<a href="{{ route('admin.coupons.index') }}" class="nav-link">Add commentMore actions
            <i class="nav-icon bi bi-ticket-perforated"></i>            
            <p>Mã giảm giá</p>             
</a>        
</li>

        
<a href="{{ route('admin.banners.index') }}" class="nav-link">Add commentMore actions
            <i class="nav-icon bi bi-image"></i>            
            <p>Banner</p>         
          </a>        
        </li>


       

     


</ul>
<!--end::Sidebar Menu-->
</nav>
</div>
<!--end::Sidebar Wrapper-->