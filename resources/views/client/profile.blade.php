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
                            <li class="nav-item"><a href="{{ route('client.logout-user') }}" class="nav-link">Đăng xuất</a> </li>
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
                                            <p>Tổng số đơn hàng</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="counter-box">
                                    <div class="bg-block d-flex-center flex-nowrap">
                                        <img class="blur-up lazyload" data-src="assets/images/icons/homework.png" src="assets/images/icons/homework.png" alt="icon" width="64" height="64" />
                                        <div class="content">
                                            <h3 class="fs-5 mb-1 text-primary">124</h3>
                                            <p>Đơn đang xử lý</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="counter-box">
                                    <div class="bg-block d-flex-center flex-nowrap">
                                        <img class="blur-up lazyload" data-src="assets/images/icons/order.png" src="assets/images/icons/order.png" alt="icon" width="64" height="64" />
                                        <div class="content">
                                            <h3 class="fs-5 mb-1 text-primary">102</h3>
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
                                <h2 class="mb-0">My Orders</h2>
                            </div>

                            <div class="table-bottom-brd table-responsive">
                                <table class="table align-middle text-center order-table">
                                    <thead>
                                        <tr class="table-head text-nowrap">
                                            <th scope="col">image</th>
                                            <th scope="col">Order Id</th>
                                            <th scope="col">Product Details</th>
                                            <th scope="col">Price</th>
                                            <th scope="col">Status</th>
                                            <th scope="col">View</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td><img class="blur-up lazyload" data-src="assets/images/products/product1-120x170.jpg" src="assets/images/products/product1-120x170.jpg" width="50" alt="product" title="product" /></td>
                                            <td><span class="id">#12301</span></td>
                                            <td><span class="name">Oxford Cuban Shirt</span></td>
                                            <td><span class="price fw-500">$99.00</span></td>
                                            <td><span class="badge rounded-pill bg-success custom-badge">Shipped</span></td>
                                            <td><a href="product-layout1.html" class="view"><i class="icon anm anm-eye btn-link fs-6"></i></a></td>
                                        </tr>
                                        <tr>
                                            <td><img class="blur-up lazyload" data-src="assets/images/products/product2-120x170.jpg" src="assets/images/products/product2-120x170.jpg" width="50" alt="product" title="product" /></td>
                                            <td><span class="id">#12302</span></td>
                                            <td><span class="name">Cuff Beanie Cap</span></td>
                                            <td><span class="price fw-500">$128.00</span></td>
                                            <td><span class="badge rounded-pill bg-danger custom-badge">Pending</span></td>
                                            <td><a href="product-layout2.html" class="view"><i class="icon anm anm-eye btn-link fs-6"></i></a></td>
                                        </tr>
                                        <tr>
                                            <td><img class="blur-up lazyload" data-src="assets/images/products/product3-120x170.jpg" src="assets/images/products/product3-120x170.jpg" width="50" alt="product" title="product" /></td>
                                            <td><span class="id">#12303</span></td>
                                            <td><span class="name">Flannel Collar Shirt</span></td>
                                            <td><span class="price fw-500">$114.00</span></td>
                                            <td><span class="badge rounded-pill bg-dark custom-badge">Processing</span></td>
                                            <td><a href="product-layout3.html" class="view"><i class="icon anm anm-eye btn-link fs-6"></i></a></td>
                                        </tr>
                                        <tr>
                                            <td><img class="blur-up lazyload" data-src="assets/images/products/product4-120x170.jpg" src="assets/images/products/product4-120x170.jpg" width="50" alt="product" title="product" /></td>
                                            <td><span class="id">#12304</span></td>
                                            <td><span class="name">Cotton Hooded Hoodie</span></td>
                                            <td><span class="price fw-500">$198.00</span></td>
                                            <td><span class="badge rounded-pill bg-secondary custom-badge">Canceled</span></td>
                                            <td><a href="product-layout4.html" class="view"><i class="icon anm anm-eye btn-link fs-6"></i></a></td>
                                        </tr>
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
                                            <h2 class="modal-title" id="editLoginModalLabel">Edit Login details</h2>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <form class="edit-Loginprofile-from" method="post" action="#"> 
                                                <div class="form-row row-cols-lg-1 row-cols-md-1 row-cols-sm-1 row-cols-1">
                                                    <div class="form-group">
                                                        <label for="editLogin-Emailaddress" class="d-none">Email address <span class="required">*</span></label>
                                                        <input name="editLogin-Emailaddress" placeholder="Email address" value="" id="editLogin-Emailaddress" type="email" />
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="editLogin-Phonenumber" class="d-none">Phone number <span class="required">*</span></label>
                                                        <input name="editLogin-Phonenumber" placeholder="Phone number" value="" id="editLogin-Phonenumber" type="text" />
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="editLogin-Password" class="d-none">Current Password <span class="required">*</span></label>
                                                        <input name="editLogin-Password" placeholder="Current Password" value="" id="editLogin-Password" type="password" />
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="editLogin-NewPassword" class="d-none">New Password <span class="required">*</span></label>
                                                        <input name="editLogin-NewPassword" placeholder="New Password" value="" id="editLogin-NewPassword" type="password" />
                                                        <small class="form-text text-muted">Your password must be 8-20 characters long, contain letters and numbers, and must not contain spaces, special characters.</small>
                                                    </div>
                                                    <div class="form-group mb-0">
                                                        <label for="editLogin-Verify" class="d-none">Verify <span class="required">*</span></label>
                                                        <input name="editLogin-Verify" placeholder="Verify" value="" id="editLogin-Verify" type="text" />
                                                        <small class="form-text text-muted">To confirm, type the new password again.</small>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                        <div class="modal-footer justify-content-center">
                                            <button type="submit" class="btn btn-primary m-0"><span>Save changes</span></button>
                                        </div>
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
    </script>
@endpush