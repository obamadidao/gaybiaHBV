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
                            <img class="rounded-circle blur-up lazyload" data-src="assets/images/users/user-img3.jpg" src="assets/images/users/user-img3.jpg" alt="user" width="130" />
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
                                <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#editProfileModal"><i class="icon anm anm-plus-r me-1"></i> Edit</button>                                         
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
                                            <h2 class="modal-title" id="editProfileModalLabel">Edit Profile details</h2>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <form class="edit-profile-from" method="post" action="#"> 
                                                <div class="form-row">
                                                    <div class="form-group col-lg-12 col-md-12 col-sm-12 col-12 mb-4">
                                                        <div class="profileImg img-thumbnail shadow bg-white rounded-circle d-flex-justify-center position-relative mx-auto">
                                                            <img src="assets/images/users/user-img3.jpg" class="rounded-circle" alt="profile" width="200" height="200" />
                                                            <div class="thumb-edit">
                                                                <label for="profileUpload" class="d-flex-center justify-content-center position-absolute top-0 start-100 translate-middle p-2 rounded-circle shadow btn btn-secondary mt-3" data-bs-toggle="tooltip" data-bs-placement="top" title="Edit"><i class="icon anm anm-pencil-ar an-1x"></i></label>
                                                                <input type="file" id="profileUpload" class="image-upload d-none" />
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group col-lg-6 col-md-6 col-sm-12 col-12">
                                                        <label for="editProfile-Companyname" class="d-none">Company name</label>
                                                        <input name="editProfile-Companyname" placeholder="Company name" value="" id="editProfile-Companyname" type="text" />
                                                    </div>
                                                    <div class="form-group col-lg-6 col-md-6 col-sm-12 col-12">
                                                        <label for="editProfile-Emailaddress" class="d-none">Email address</label>
                                                        <input name="editProfile-Emailaddress" placeholder="Email address" value="" id="editProfile-Emailaddress" type="email" />
                                                    </div>
                                                    <div class="form-group col-lg-6 col-md-6 col-sm-12 col-12">
                                                        <label for="editProfile-Phonenumber" class="d-none">Phone number</label>
                                                        <input name="editProfile-Phonenumber" placeholder="Phone number" value="" id="editProfile-Phonenumber" type="text" />
                                                    </div>
                                                    <div class="form-group col-lg-6 col-md-6 col-sm-12 col-12">
                                                        <label for="editProfile-zone" class="d-none">City / State <span class="required">*</span></label>
                                                        <select name="editProfile_zone_id" id="editProfile-zone">
                                                            <option value="">Select Region / State</option>
                                                            <option value="AL">Alabama</option>
                                                            <option value="AK">Alaska</option>
                                                            <option value="AZ">Arizona</option>
                                                            <option value="AR">Arkansas</option>
                                                            <option value="CA">California</option>
                                                            <option value="CO">Colorado</option>
                                                            <option value="CT">Connecticut</option>
                                                            <option value="DE">Delaware</option>
                                                        </select>
                                                    </div>
                                                    <div class="form-group col-lg-6 col-md-6 col-sm-12 col-12">
                                                        <label for="editProfile-country" class="d-none">Country / Region <span class="required">*</span></label>
                                                        <select name="editProfile_country_id" id="editProfile-country">
                                                            <option value="">Select Country / Region</option>
                                                            <option value="AI" label="Anguilla">Anguilla</option>
                                                            <option value="AG" label="Antigua and Barbuda">Antigua and Barbuda</option>
                                                            <option value="AR" label="Argentina">Argentina</option>
                                                            <option value="AW" label="Aruba">Aruba</option>
                                                            <option value="BS" label="Bahamas">Bahamas</option>
                                                            <option value="BB" label="Barbados">Barbados</option>
                                                            <option value="BZ" label="Belize">Belize</option>
                                                            <option value="BM" label="Bermuda">Bermuda</option>
                                                            <option value="BO" label="Bolivia">Bolivia</option>
                                                            <option value="BR" label="Brazil">Brazil</option>
                                                        </select>
                                                    </div>
                                                    <div class="form-group col-lg-6 col-md-6 col-sm-12 col-12">
                                                        <label for="editProfile-Streetaddress" class="d-none">Street address</label>
                                                        <input name="editProfile-Streetaddress" placeholder="Street address" value="" id="editProfile-Streetaddress" type="text" />
                                                    </div>
                                                    <div class="form-group col-lg-6 col-md-6 col-sm-12 col-12">
                                                        <label for="editProfile-Zipcode" class="d-none">Zip code</label>
                                                        <input name="editProfile-Zipcode" placeholder="Zip code" value="" id="editProfile-Zipcode" type="text" />
                                                    </div>
                                                    <div class="form-group col-lg-6 col-md-6 col-sm-12 col-12">
                                                        <label for="editProfile-Category" class="d-none">Category</label>
                                                        <input name="editProfile-Category" placeholder="Phone number" value="" id="editProfile-Category" type="text" />
                                                    </div>
                                                    <div class="form-group col-lg-6 col-md-6 col-sm-12 col-12 mb-md-0">
                                                        <label for="editProfile-YearEstablished" class="d-none">Year Established</label>
                                                        <input name="editProfile-YearEstablished" placeholder="YearEstablished" value="" id="editProfile-YearEstablished" type="text" />
                                                    </div>
                                                    <div class="form-group col-lg-6 col-md-6 col-sm-12 col-12 mb-0">
                                                        <label for="editProfile-TotalEmployees" class="d-none">Zip code</label>
                                                        <input name="editProfile-TotalEmployees" placeholder="Zip code" value="" id="editProfile-TotalEmployees" type="text" />
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                        <div class="modal-footer justify-content-center">
                                            <button type="submit" class="btn btn-primary m-0"><span>Save Profile</span></button>
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