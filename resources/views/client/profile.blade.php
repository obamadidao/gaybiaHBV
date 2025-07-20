@extends('layouts.client.ClientLayout')

@section('content')
<!--Page Header-->
<div class="page-header text-center">
<div class="container">
<div class="row">
<div class="col-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-content-between align-items-center">
<div class="page-title"><h1>Tài khoản</h1></div>
<!--Breadcrumbs-->
<div class="breadcrumbs"><a href="{{ route('client.index') }}" title="Back to the home page">Trang chủ</a><span class="title"><i class="icon anm anm-angle-right-l"></i>Tài khoản</span><span class="main-title fw-bold"><i class="icon anm anm-angle-right-l"></i>Thông tin tài khoản</span></div>
<!--End Breadcrumbs-->
</div>
</div>
</div>
</div>
<!--End Page Header-->

<!--Main Content-->
<div class="container mb-5">
<div class="row">
<div class="col-12 col-sm-12 col-md-12 col-lg-3 mb-4 mb-lg-0">
<!-- Dashboard sidebar -->
<div class="dashboard-sidebar bg-block">
<div class="profile-top text-center mb-4 px-3">
<div class="profile-image mb-3">
<img class="rounded-circle blur-up lazyload" data-src="{{ $customerProfile->avatar ? Storage::url($customerProfile->avatar) : 'assets/images/users/user-img3.jpg' }}" src="{{ $customerProfile->avatar ? Storage::url($customerProfile->avatar) : 'assets/images/users/user-img3.jpg' }}" alt="user" width="130" />
</div>
<div class="profile-detail">
<h3 class="mb-1">{{ $customerProfile->first_name }} {{ $customerProfile->last_name }}</h3>
<p class="text-muted">{{ $user->email }}</p>
</div>
</div>
<div class="dashboard-tab">
<ul class="nav nav-tabs flex-lg-column border-bottom-0" id="top-tab" role="tablist">
<li class="nav-item"><a href="#" data-bs-toggle="tab" data-bs-target="#info" class="nav-link active">Thông tin tài khoản</a></li>
<li class="nav-item"><a href="#" data-bs-toggle="tab" data-bs-target="#orders" class="nav-link">Đơn hàng</a></li>
<li class="nav-item"><a href="#" data-bs-toggle="tab" data-bs-target="#profile" class="nav-link">Thông tin cá nhân</a></li>
<li class="nav-item"><a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="nav-link">Đăng xuất</a></li>
<form id="logout-form" action="{{ route('client.logout-user') }}" method="POST" class="d-none">
@csrf
</form>
</ul>
</div>
</div>
<!-- End Dashboard sidebar -->
</div>
<div class="col-12 col-sm-12 col-md-12 col-lg-9">
<div class="dashboard-content tab-content h-100" id="top-tabContent">
<!-- Account Info -->
<div class="tab-pane fade h-100 show active" id="info">
<div class="account-info h-100">
<div class="welcome-msg mb-4">
<h2>Xin chào, <span class="text-primary">{{ $customerProfile->first_name }} {{ $customerProfile->last_name }}</span></h2>
<p>Từ trang tài khoản của bạn, bạn có thể xem tóm tắt hoạt động tài khoản gần đây và cập nhật thông tin tài khoản của mình. Chọn liên kết bên dưới để xem hoặc chỉnh sửa thông tin.</p>
</div>

<div class="row g-3 row-cols-lg-3 row-cols-md-3 row-cols-sm-3 row-cols-1 mb-4">
<div class="counter-box">
<div class="bg-block d-flex-center flex-nowrap">
<img class="blur-up lazyload" data-src="assets/images/icons/sale.png" src="assets/images/icons/sale.png" alt="icon" width="64" height="64" />
<div class="content">
                                            <h3 class="fs-5 mb-1 text-primary">238</h3>
                                            <h3 class="fs-5 mb-1 text-primary">{{ $orderStats['total_orders'] }}</h3>
<p>Tổng số đơn hàng</p>
</div>
</div>
</div>
<div class="counter-box">
<div class="bg-block d-flex-center flex-nowrap">
<img class="blur-up lazyload" data-src="assets/images/icons/homework.png" src="assets/images/icons/homework.png" alt="icon" width="64" height="64" />
<div class="content">
                                            <h3 class="fs-5 mb-1 text-primary">124</h3>
                                            <h3 class="fs-5 mb-1 text-primary">{{ $orderStats['processing_orders'] }}</h3>
<p>Đơn đang xử lý</p>
</div>
</div>
</div>
<div class="counter-box">
<div class="bg-block d-flex-center flex-nowrap">
<img class="blur-up lazyload" data-src="assets/images/icons/order.png" src="assets/images/icons/order.png" alt="icon" width="64" height="64" />
<div class="content">
                                            <h3 class="fs-5 mb-1 text-primary">102</h3>
                                            <h3 class="fs-5 mb-1 text-primary">{{ $orderStats['completed_orders'] }}</h3>
<p>Đơn hàng hoàn thành</p>
</div>
</div>
</div>
</div>
<div class="row g-3 row-cols-lg-1 row-cols-md-1 row-cols-sm-1 row-cols-1 mb-4">
<div class="counter-box">
<div class="bg-block d-flex-center flex-nowrap">
<img class="blur-up lazyload" data-src="assets/images/icons/sale.png" src="assets/images/icons/sale.png" alt="icon" width="64" height="64" />
<div class="content">
                                            <h3 class="fs-5 mb-1 text-primary">238</h3>
                                            <p>Tổng chi tiêu</p>
                                            <h3 class="fs-5 mb-1 text-primary">{{ number_format($orderStats['total_spent'], 0, ',', '.') }}</h3>
                                            <p>Tổng chi tiêu (VNĐ)</p>
</div>
</div>
</div>
</div>
</div>
</div>
<!-- End Account Info -->

<!-- My Orders -->
<div class="tab-pane fade h-100" id="orders">
<div class="orders-card mt-0 h-100">    
<div class="top-sec d-flex-justify-center justify-content-between mb-4">
<h2 class="mb-0">Đơn hàng của tôi
({{ $orders->count() }})
</h2>
</div>

<div class="table-bottom-brd table-responsive" style="max-height: 400px; overflow-y: auto;">
<table class="table align-middle text-center order-table">
<thead>
<tr class="table-head text-nowrap">
<th scope="col">Mã đơn hàng</th>
<th scope="col">Ngày đặt</th>
<th scope="col">Tổng tiền</th>
<th scope="col">Thanh toán</th>
<th scope="col">Trạng thái</th>
<th scope="col">Chi tiết</th>
</tr>
</thead>
<tbody>
@foreach ($orders as $order)
<tr>
<td><span class="id">#{{ substr($order->order_number, -7) }}</span></td>
<td><span class="name">{{ $order->created_at->format('d/m/Y') }}</span></td>
<td><span class="price fw-500">{{ number_format($order->total_amount, 0, ',', '.') }} VNĐ</span></td>
<td>
                                                    <span class="badge bg-{{ $order->status_badge_class }}">
                                                        {{ $order->status_text }}
                                                    <span class="badge {{ $order->payment_status === 'paid' ? 'bg-success' : 'bg-warning' }}">
                                                        {{ $order->payment_status === 'paid' ? 'Đã thanh toán' : 'Chưa thanh toán' }}
</span>
</td>
<td>
                                                    <span class="badge {{ $order->payment_status === 'paid' ? 'bg-success' : 'bg-warning' }}">
                                                        {{ $order->payment_status_text }}
                                                    <span class="badge bg-{{ $order->status === 'pending' ? 'warning' : ($order->status === 'processing' ? 'info' : ($order->status === 'shipped' ? 'primary' : ($order->status === 'delivered' ? 'success' : 'danger'))) }}">
                                                        {{ $order->status === 'pending' ? 'Chờ xử lý' : ($order->status === 'processing' ? 'Đang xử lý' : ($order->status === 'shipped' ? 'Đã gửi hàng' : ($order->status === 'delivered' ? 'Đã giao' : 'Đã hủy'))) }}
</span>
</td>
                                                <td><a href="" class="view"><i class="icon anm anm-eye btn-link fs-6"></i></a></td>
                                                <td><a href="#" onclick="viewOrderDetail({{ $order->id }})" class="view" title="Xem chi tiết"><i class="icon anm anm-eye btn-link fs-6"></i></a></td>
</tr>
@endforeach
</tbody>
</table>
</div>                                               
</div>
</div>
<!-- End My Orders -->

<!-- Profile -->
<div class="tab-pane fade h-100" id="profile">
<div class="profile-card mt-0 h-100">                                   
<div class="top-sec d-flex-justify-center justify-content-between mb-4">
<h2 class="mb-0">Thông tin tài khoản</h2>
<button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#editProfileModal"><i class="icon anm anm-plus-r me-1"></i> Chỉnh sửa</button>                                         
</div>
<div class="profile-book-section mb-4">
<div class="details d-flex align-items-center mb-2">
<div class="left">
<h6 class="mb-0 body-font fw-500">Họ tên: </h6>
</div>
<div class="right">
<p>{{ $customerProfile->first_name }} {{ $customerProfile->last_name }}</p>
</div>
</div>
<div class="details d-flex align-items-center mb-2">
<div class="left">
<h6 class="mb-0 body-font fw-500">Email: </h6>
</div>
<div class="right">
<p>{{ $user->email }}</p>
</div>
</div>
<div class="details d-flex align-items-center mb-2">
<div class="left">
<h6 class="mb-0 body-font fw-500">Số điện thoại: </h6>
</div>
<div class="right">
<p>{{ $customerProfile->phone }}</p>
</div>
</div>
<div class="details d-flex align-items-center mb-2">
<div class="left">
<h6 class="mb-0 body-font fw-500">Quốc gia: </h6>
</div>
<div class="right">
<p>{{ $customerProfile->country }}</p>
</div>
</div>
<div class="details d-flex align-items-center mb-2">
<div class="left">
<h6 class="mb-0 body-font fw-500">Địa chỉ: </h6>
</div>
<div class="right">
<p>{{ $customerProfile->full_address }}</p>
</div>
</div>
<div class="details d-flex align-items-center mb-2">
<div class="left">
<h6 class="mb-0 body-font fw-500">Ngày tạo: </h6>
</div>
<div class="right">
<p>{{ $customerProfile->created_at }}</p>
</div>
</div>
<div class="details d-flex align-items-center mb-2">
<div class="left">
<h6 class="mb-0 body-font fw-500">Ngày cập nhật: </h6>
</div>
<div class="right">
<p>{{ $customerProfile->updated_at }}</p>
</div>
</div>
</div>  

<!-- Edit Profile Modal -->
<div class="modal fade" id="editProfileModal" tabindex="-1" aria-labelledby="editProfileModalLabel" aria-hidden="true">
<div class="modal-dialog modal-dialog-centered">
<div class="modal-content">
<div class="modal-header">
<h2 class="modal-title" id="editProfileModalLabel">Chỉnh sửa thông tin</h2>
<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
<div class="modal-body">
<form class="edit-profile-from" method="post" action="{{ route('client.update-profile-user') }}" enctype="multipart/form-data">
@csrf
@method('PUT')
<div class="form-row">
<div class="form-group col-lg-12 col-md-12 col-sm-12 col-12 mb-4">
<div class="profileImg img-thumbnail shadow bg-white rounded-circle d-flex-justify-center position-relative mx-auto">
<img src="{{ $customerProfile->avatar ? Storage::url($customerProfile->avatar) : 'assets/images/users/user-img3.jpg' }}" class="rounded-circle" alt="profile" width="200" height="200" id="previewImage"/>
<div class="thumb-edit">
<label for="profileUpload" class="d-flex-center justify-content-center position-absolute top-0 start-100 translate-middle p-2 rounded-circle shadow btn btn-secondary mt-3" data-bs-toggle="tooltip" data-bs-placement="top" title="Chỉnh sửa"><i class="icon anm anm-pencil-ar an-1x"></i></label>
<input type="file" id="profileUpload" name="avatar" class="image-upload d-none" onchange="previewFile(this)"/>
</div>
</div>

</div>
<div class="form-group col-lg-6 col-md-6 col-sm-12 col-12">
<label for="first_name">Họ</label>
<input name="first_name" value="{{ $customerProfile->first_name }}" id="first_name" type="text" class="form-control" />
</div>
<div class="form-group col-lg-6 col-md-6 col-sm-12 col-12">
<label for="last_name">Tên</label>
<input name="last_name" value="{{ $customerProfile->last_name }}" id="last_name" type="text" class="form-control" />
</div>
<div class="form-group col-lg-6 col-md-6 col-sm-12 col-12">
<label for="phone">Số điện thoại</label>
<input name="phone" value="{{ $customerProfile->phone }}" id="phone" type="text" class="form-control" />
</div>
<div class="form-group col-lg-6 col-md-6 col-sm-12 col-12">
<label for="country">Quốc gia</label>
<input name="country" value="{{ $customerProfile->country }}" id="country" type="text" class="form-control" />
</div>
<div class="form-group col-lg-6 col-md-6 col-sm-12 col-12">
<label for="city">Tỉnh/Thành phố</label>
<select name="city" class="form-control" required>
<option value="">Chọn tỉnh/thành phố</option>
<option value="Tuyên Quang" {{ $customerProfile->city == 'Tuyên Quang' ? 'selected' : '' }}>Tuyên Quang</option>
<option value="Lào Cai" {{ $customerProfile->city == 'Lào Cai' ? 'selected' : '' }}>Lào Cai</option>
<option value="Thái Nguyên" {{ $customerProfile->city == 'Thái Nguyên' ? 'selected' : '' }}>Thái Nguyên</option>
<option value="Phú Thọ" {{ $customerProfile->city == 'Phú Thọ' ? 'selected' : '' }}>Phú Thọ</option>
<option value="Bắc Ninh" {{ $customerProfile->city == 'Bắc Ninh' ? 'selected' : '' }}>Bắc Ninh</option>
<option value="Hưng Yên" {{ $customerProfile->city == 'Hưng Yên' ? 'selected' : '' }}>Hưng Yên</option>
<option value="Thành phố Hải Phòng" {{ $customerProfile->city == 'Thành phố Hải Phòng' ? 'selected' : '' }}>Thành phố Hải Phòng</option>
<option value="Ninh Bình" {{ $customerProfile->city == 'Ninh Bình' ? 'selected' : '' }}>Ninh Bình</option>
<option value="Quảng Trị" {{ $customerProfile->city == 'Quảng Trị' ? 'selected' : '' }}>Quảng Trị</option>
<option value="Thành phố Đà Nẵng" {{ $customerProfile->city == 'Thành phố Đà Nẵng' ? 'selected' : '' }}>Thành phố Đà Nẵng</option>
<option value="Quảng Ngãi" {{ $customerProfile->city == 'Quảng Ngãi' ? 'selected' : '' }}>Quảng Ngãi</option>
<option value="Gia Lai" {{ $customerProfile->city == 'Gia Lai' ? 'selected' : '' }}>Gia Lai</option>
<option value="Khánh Hoà" {{ $customerProfile->city == 'Khánh Hoà' ? 'selected' : '' }}>Khánh Hoà</option>
<option value="Lâm Đồng" {{ $customerProfile->city == 'Lâm Đồng' ? 'selected' : '' }}>Lâm Đồng</option>
<option value="Đắk Lắk" {{ $customerProfile->city == 'Đắk Lắk' ? 'selected' : '' }}>Đắk Lắk</option>
<option value="Thành phố Hồ Chí Minh" {{ $customerProfile->city == 'Thành phố Hồ Chí Minh' ? 'selected' : '' }}>Thành phố Hồ Chí Minh</option>
<option value="Đồng Nai" {{ $customerProfile->city == 'Đồng Nai' ? 'selected' : '' }}>Đồng Nai</option>
<option value="Tây Ninh" {{ $customerProfile->city == 'Tây Ninh' ? 'selected' : '' }}>Tây Ninh</option>
<option value="Thành phố Cần Thơ" {{ $customerProfile->city == 'Thành phố Cần Thơ' ? 'selected' : '' }}>Thành phố Cần Thơ</option>
<option value="Vĩnh Long" {{ $customerProfile->city == 'Vĩnh Long' ? 'selected' : '' }}>Vĩnh Long</option>
<option value="Đồng Tháp" {{ $customerProfile->city == 'Đồng Tháp' ? 'selected' : '' }}>Đồng Tháp</option>
<option value="Cà Mau" {{ $customerProfile->city == 'Cà Mau' ? 'selected' : '' }}>Cà Mau</option>
<option value="An Giang" {{ $customerProfile->city == 'An Giang' ? 'selected' : '' }}>An Giang</option>
<option value="Thành phố Hà Nội" {{ $customerProfile->city == 'Thành phố Hà Nội' ? 'selected' : '' }}>Thành phố Hà Nội</option>
<option value="Thành phố Huế" {{ $customerProfile->city == 'Thành phố Huế' ? 'selected' : '' }}>Thành phố Huế</option>
<option value="Lai Châu" {{ $customerProfile->city == 'Lai Châu' ? 'selected' : '' }}>Lai Châu</option>
<option value="Điện Biên" {{ $customerProfile->city == 'Điện Biên' ? 'selected' : '' }}>Điện Biên</option>
<option value="Sơn La" {{ $customerProfile->city == 'Sơn La' ? 'selected' : '' }}>Sơn La</option>
<option value="Lạng Sơn" {{ $customerProfile->city == 'Lạng Sơn' ? 'selected' : '' }}>Lạng Sơn</option>
<option value="Quảng Ninh" {{ $customerProfile->city == 'Quảng Ninh' ? 'selected' : '' }}>Quảng Ninh</option>
<option value="Thanh Hoá" {{ $customerProfile->city == 'Thanh Hoá' ? 'selected' : '' }}>Thanh Hoá</option>
<option value="Nghệ An" {{ $customerProfile->city == 'Nghệ An' ? 'selected' : '' }}>Nghệ An</option>
<option value="Hà Tĩnh" {{ $customerProfile->city == 'Hà Tĩnh' ? 'selected' : '' }}>Hà Tĩnh</option>
<option value="Cao Bằng" {{ $customerProfile->city == 'Cao Bằng' ? 'selected' : '' }}>Cao Bằng</option>
</select>
</div>
<div class="form-group col-lg-6 col-md-6 col-sm-12 col-12">
<label for="ward">Phường/Xã</label>
<input name="ward" value="{{ $customerProfile->ward }}" id="ward" type="text" class="form-control" />
</div>
<div class="form-group col-12">
<label for="address">Địa chỉ</label>
<input name="address" value="{{ $customerProfile->address }}" id="address" type="text" class="form-control" />
</div>
</div>
<div class="modal-footer justify-content-center">
<button type="submit" class="btn btn-primary m-0"><span>Lưu thông tin</span></button>
</div>
</form>
</div>
</div>
</div>
</div>
<!-- End Edit Profile Modal -->

<div class="top-sec d-flex-justify-center justify-content-between mb-4">
<h2 class="mb-0">Thông tin đăng nhập</h2>
<button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#editLoginModal"><i class="icon anm anm-plus-r me-1"></i> Chỉnh sửa</button>                                         
</div>
<div class="profile-login-section">
<div class="details d-flex align-items-center mb-2">
<div class="left">
<h6 class="mb-0 body-font fw-500">Email: </h6>
</div>
<div class="right">
<p>{{ $user->email }}</p>
</div>
</div>
<div class="details d-flex align-items-center mb-2">
<div class="left">
<h6 class="mb-0 body-font fw-500">Số điện thoại: </h6>
</div>
<div class="right">
<p>{{ $customerProfile->phone }}</p>
</div>
</div>
<div class="details d-flex align-items-center mb-2">
<div class="left">
<h6 class="mb-0 body-font fw-500">Mật khẩu</h6>
</div>
<div class="right">
<p>xxxxxxx</p>
</div>
</div>
</div>

<!-- Edit Login details Modal -->
<div class="modal fade" id="editLoginModal" tabindex="-1" aria-labelledby="editLoginModalLabel" aria-hidden="true">
<div class="modal-dialog modal-dialog-centered">
<div class="modal-content">
<div class="modal-header">
<h2 class="modal-title" id="editLoginModalLabel">Chỉnh sửa thông tin đăng nhập</h2>
<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
<div class="modal-body">
<form class="edit-Loginprofile-from" method="post" action="{{ route('client.update-profile-password') }}">
@csrf
@method('PUT')
<div class="form-row row-cols-lg-1 row-cols-md-1 row-cols-sm-1 row-cols-1">
<div class="form-group">
<label for="email">Email <span class="required">*</span></label>
<input name="email" placeholder="Email" value="{{ $user->email }}" id="email" type="email" class="@error('email') is-invalid @enderror" required />
@error('email')
<div class="invalid-feedback">{{ $message }}</div>
@enderror
</div>
<div class="form-group">
<label for="current_password">Mật khẩu hiện tại <span class="required">*</span></label>
<input name="current_password" placeholder="Mật khẩu hiện tại" id="current_password" type="password" class="@error('current_password') is-invalid @enderror" required />
@error('current_password')
<div class="invalid-feedback">{{ $message }}</div>
@enderror
</div>
<div class="form-group">
<label for="password">Mật khẩu mới</label>
<input name="password" placeholder="Mật khẩu mới" id="password" type="password" class="@error('password') is-invalid @enderror" minlength="8" maxlength="20" pattern="^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d!@#$%^&*()_+\-=\[\]{};:\'&quot;,.<>?\/\\|]{8,20}$" />
<small class="form-text text-muted">Mật khẩu phải có từ 8-20 ký tự, chứa chữ cái và số, không chứa khoảng trắng và ký tự đặc biệt.</small>
@error('password')
<div class="invalid-feedback">{{ $message }}</div>
@enderror
</div>
<div class="form-group mb-0">
<label for="password_confirmation">Xác nhận mật khẩu mới</label>
<input name="password_confirmation" placeholder="Xác nhận mật khẩu mới" id="password_confirmation" type="password" class="@error('password_confirmation') is-invalid @enderror" />
<small class="form-text text-muted">Để xác nhận, hãy nhập lại mật khẩu mới.</small>
@error('password_confirmation')
<div class="invalid-feedback">{{ $message }}</div>
@enderror
</div>
</div>
</div>
<div class="modal-footer justify-content-center">
<button type="submit" class="btn btn-primary m-0"><span>Lưu thông tin</span></button>
</div>
</form>
</div>
</div>
</div>
<!-- End Edit Login details Modal -->
</div>
</div>
<!-- End Profile -->
</div>
</div>
</div>
</div>
<!--End Main Content-->

    <!-- Order Detail Modal -->
    <div class="modal fade" id="orderDetailModal" tabindex="-1" aria-labelledby="orderDetailModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="orderDetailModalLabel">Chi tiết đơn hàng</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="orderDetailContent">
                    <div class="text-center py-5">
                        <div class="spinner-border text-primary" role="status">
                            <span class="visually-hidden">Đang tải...</span>
                        </div>
                        <div class="mt-2">Đang tải thông tin đơn hàng...</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Order Detail Modal -->
@endsection

@push('script')
<script>
       function previewFile(input) {
           var file = input.files[0];
           if(file) {
               var reader = new FileReader();
               reader.onload = function(e) {
                   document.getElementById('previewImage').src = e.target.result;
               }
               reader.readAsDataURL(file);
           }
       }

        // Xem chi tiết đơn hàng
        function viewOrderDetail(orderId) {
            const modal = new bootstrap.Modal(document.getElementById('orderDetailModal'));
            const modalContent = document.getElementById('orderDetailContent');
            
            // Reset modal content về loading state
            modalContent.innerHTML = `
                <div class="text-center py-5">
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Đang tải...</span>
                    </div>
                    <div class="mt-2">Đang tải thông tin đơn hàng...</div>
                </div>
            `;
            
            // Mở modal
            modal.show();
            
            // Load dữ liệu qua AJAX
            fetch(`/api/order/${orderId}/detail`)
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        renderOrderDetail(data.order);
                    } else {
                        modalContent.innerHTML = `
                            <div class="alert alert-danger text-center">
                                <i class="fas fa-exclamation-triangle"></i>
                                ${data.message || 'Không thể tải thông tin đơn hàng'}
                            </div>
                        `;
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    modalContent.innerHTML = `
                        <div class="alert alert-danger text-center">
                            <i class="fas fa-exclamation-triangle"></i>
                            Có lỗi xảy ra khi tải thông tin đơn hàng
                        </div>
                    `;
                });
        }

        function renderOrderDetail(order) {
            const modalContent = document.getElementById('orderDetailContent');
            
            // Update modal title
            document.getElementById('orderDetailModalLabel').textContent = `Chi tiết đơn hàng #${order.order_number}`;
            
            // Render order items
            let orderItemsHtml = '';
            order.order_items.forEach(item => {
                orderItemsHtml += `
                    <tr>
                        <td class="text-start">
                            <div class="d-flex align-items-center">
                                <div class="me-3">
                                    ${item.product_image ? 
                                        `<img src="/storage/${item.product_image}" alt="${item.product_name}" width="50" height="50" class="rounded">` :
                                        `<img src="/assets/images/empty-img.gif" alt="No Image" width="50" height="50" class="rounded">`
                                    }
                                </div>
                                <div>
                                    <h6 class="mb-1">${item.product_name}</h6>
                                    ${item.variant_name ? `<small class="text-muted">${item.variant_name}</small>` : ''}
                                </div>
                            </div>
                        </td>
                        <td class="text-center">${formatCurrency(item.unit_price)}</td>
                        <td class="text-center">${item.quantity}</td>
                        <td class="text-end">${formatCurrency(item.total_price)}</td>
                    </tr>
                `;
            });

            modalContent.innerHTML = `
                <div class="row">
                    <!-- Order Information -->
                    <div class="col-md-6 mb-4">
                        <div class="card h-100">
                            <div class="card-header">
                                <h5 class="mb-0">Thông tin đơn hàng</h5>
                            </div>
                            <div class="card-body">
                                <div class="row mb-2">
                                    <div class="col-5"><strong>Mã đơn hàng:</strong></div>
                                    <div class="col-7">#${order.order_number}</div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col-5"><strong>Ngày đặt:</strong></div>
                                    <div class="col-7">${order.created_at}</div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col-5"><strong>Trạng thái:</strong></div>
                                    <div class="col-7">
                                        <span class="badge bg-${order.status_badge_class}">${order.status_text}</span>
                                    </div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col-5"><strong>Thanh toán:</strong></div>
                                    <div class="col-7">${order.payment_method_text}</div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col-5"><strong>TT thanh toán:</strong></div>
                                    <div class="col-7">
                                        <span class="badge ${order.payment_status === 'paid' ? 'bg-success' : 'bg-warning'}">${order.payment_status_text}</span>
                                    </div>
                                </div>
                                ${order.coupon_code ? `
                                <div class="row mb-2">
                                    <div class="col-5"><strong>Mã giảm giá:</strong></div>
                                    <div class="col-7">${order.coupon_code}</div>
                                </div>
                                ` : ''}
                                ${order.notes ? `
                                <div class="row mb-2">
                                    <div class="col-5"><strong>Ghi chú:</strong></div>
                                    <div class="col-7">${order.notes}</div>
                                </div>
                                ` : ''}
                            </div>
                        </div>
                    </div>

                    <!-- Shipping Information -->
                    <div class="col-md-6 mb-4">
                        <div class="card h-100">
                            <div class="card-header">
                                <h5 class="mb-0">Thông tin giao hàng</h5>
                            </div>
                            <div class="card-body">
                                <div class="row mb-2">
                                    <div class="col-4"><strong>Người nhận:</strong></div>
                                    <div class="col-8">${order.shipping_address.name || 'N/A'}</div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col-4"><strong>Số điện thoại:</strong></div>
                                    <div class="col-8">${order.shipping_address.phone || 'N/A'}</div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col-4"><strong>Địa chỉ:</strong></div>
                                    <div class="col-8">${order.shipping_address.address || 'N/A'}</div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col-4"><strong>Phường/Xã:</strong></div>
                                    <div class="col-8">${order.shipping_address.ward || 'N/A'}</div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col-4"><strong>Tỉnh/TP:</strong></div>
                                    <div class="col-8">${order.shipping_address.city || 'N/A'}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Order Items -->
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="mb-0">Sản phẩm đã đặt</h5>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th class="text-start">Sản phẩm</th>
                                                <th class="text-center">Đơn giá</th>
                                                <th class="text-center">Số lượng</th>
                                                <th class="text-end">Thành tiền</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            ${orderItemsHtml}
                                        </tbody>
                                    </table>
                                </div>
                                
                                <!-- Order Summary -->
                                <div class="row justify-content-end">
                                    <div class="col-md-6">
                                        <table class="table">
                                            <tbody>
                                                <tr>
                                                    <td><strong>Tạm tính:</strong></td>
                                                    <td class="text-end">${formatCurrency(order.subtotal)}</td>
                                                </tr>
                                                ${order.discount_amount > 0 ? `
                                                <tr>
                                                    <td><strong>Giảm giá:</strong></td>
                                                    <td class="text-end text-success">-${formatCurrency(order.discount_amount)}</td>
                                                </tr>
                                                ` : ''}
                                                <tr class="table-active">
                                                    <td><strong>Tổng cộng:</strong></td>
                                                    <td class="text-end"><strong class="text-danger">${formatCurrency(order.total_amount)}</strong></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            `;
        }

        function formatCurrency(amount) {
            return new Intl.NumberFormat('vi-VN').format(amount) + ' VNĐ';
        }
   </script>
@endpush