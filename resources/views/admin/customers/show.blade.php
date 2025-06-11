@extends('layouts.admin.AdminLayout')

@section('content')
<div class="container-fluid">

    <!-- Alert Messages -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="fas fa-exclamation-triangle me-2"></i>{{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0 text-gray-800"></h1>
            
        </div>
        <div>
            <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#editCustomerModal">
                <i class="fas fa-edit me-2"></i>Chỉnh sửa
            </button>
        </div>
    </div>

    <div class="row">
        <!-- Left Column - Customer Info -->
        <div class="col-xl-4">
            <!-- Profile Card -->
            <div class="card shadow mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h6 class="m-0 font-weight-bold text-primary">Thông tin cá nhân</h6>
                    @if($customer->customerProfile && $customer->customerProfile->is_verified)
                        <span class="badge bg-success ms-auto">
                            <i class="fas fa-check-circle me-1"></i>Đã xác thực
                        </span>
                    @else
                        <span class="badge bg-warning ms-auto">
                            <i class="fas fa-clock me-1"></i>Chưa xác thực
                        </span>
                    @endif
                </div>
                <div class="card-body text-center">
                    @if($customer->customerProfile && $customer->customerProfile->avatar)
                        <img src="{{ $customer->customerProfile->avatar }}" 
                             alt="{{ $customer->name }}" 
                             class="rounded-circle mb-3" 
                             style="width: 80px; height: 80px; object-fit: cover;">
                    @else
                        <div class="bg-primary rounded-circle d-flex align-items-center justify-content-center mx-auto mb-3" 
                             style="width: 80px; height: 80px;">
                            <span class="text-white fw-bold fs-2">
                                {{ substr($customer->name, 0, 1) }}
                            </span>
                        </div>
                    @endif
                    
                    <h5 class="mb-1">{{ $customer->display_name }}</h5>
                    <p class="text-muted mb-3">{{ $customer->email }}</p>
                    
                    @if($customer->customerProfile)
                        @php $profile = $customer->customerProfile; @endphp
                        
                        @if($profile->phone)
                            <div class="text-start mb-2">
                                <small class="text-muted">Số điện thoại:</small>
                                <div>{{ $profile->phone }}</div>
                            </div>
                        @endif
                        
                        @if($profile->date_of_birth)
                            <div class="text-start mb-2">
                                <small class="text-muted">Ngày sinh:</small>
                                <div>{{ $profile->date_of_birth->format('d/m/Y') }}</div>
                            </div>
                        @endif
                        
                        @if($profile->gender)
                            <div class="text-start mb-2">
                                <small class="text-muted">Giới tính:</small>
                                <div>
                                    @switch($profile->gender)
                                        @case('male')
                                            Nam
                                            @break
                                        @case('female')
                                            Nữ
                                            @break
                                        @default
                                            Khác
                                    @endswitch
                                </div>
                            </div>
                        @endif
                        
                        @if($profile->full_address)
                            <div class="text-start mb-2">
                                <small class="text-muted">Địa chỉ:</small>
                                <div>{{ $profile->full_address }}</div>
                            </div>
                        @endif
                        
                        <div class="text-start mb-2">
                            <small class="text-muted">Hoàn thiện profile:</small>
                            <div class="progress mt-1">
                                <div class="progress-bar" role="progressbar" 
                                     style="width: {{ $profile->getCompletionPercentage() }}%">
                                    {{ $profile->getCompletionPercentage() }}%
                                </div>
                            </div>
                        </div>
                    @endif
                    
                    <div class="text-start">
                        <small class="text-muted">Tham gia:</small>
                        <div>{{ $customer->created_at->format('d/m/Y H:i') }}</div>
                    </div>
                </div>
            </div>

            <!-- Statistics Card -->
            <div class="card shadow mb-4">
                <div class="card-header">
                    <h6 class="m-0 font-weight-bold text-primary">Thống kê</h6>
                </div>
                <div class="card-body">
                    <div class="row text-center">
                        <div class="col-6 mb-3">
                            <div class="text-primary fw-bold h4">{{ $stats['total_orders'] }}</div>
                            <small class="text-muted">Đơn hàng</small>
                        </div>
                        <div class="col-6 mb-3">
                            <div class="text-success fw-bold h4">{{ number_format($stats['total_spent'], 0, ',', '.') }}đ</div>
                            <small class="text-muted">Tổng chi tiêu</small>
                        </div>
                        <div class="col-6">
                            <div class="text-info fw-bold h4">{{ $stats['total_transactions'] }}</div>
                            <small class="text-muted">Giao dịch</small>
                        </div>
                        <div class="col-6">
                            <div class="text-warning fw-bold h4">{{ number_format($stats['avg_order_value'], 0, ',', '.') }}đ</div>
                            <small class="text-muted">Giá trị TB/đơn</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right Column - Orders & Transactions -->
        <div class="col-xl-8">
            <!-- Recent Orders -->
            <div class="card shadow mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h6 class="m-0 font-weight-bold text-primary">Đơn hàng gần đây</h6>
                    <a href="#" class="btn btn-sm btn-outline-primary ms-auto">Xem tất cả</a>
                </div>
                <div class="card-body">
                    @if($recentOrders->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-sm">
                                <thead>
                                    <tr>
                                        <th>Mã đơn</th>
                                        <th>Ngày đặt</th>
                                        <th>Sản phẩm</th>
                                        <th>Tổng tiền</th>
                                        <th>Trạng thái</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($recentOrders as $order)
                                    <tr>
                                        <td>
                                            <a href="#" class="text-decoration-none">{{ $order->order_number }}</a>
                                        </td>
                                        <td>{{ $order->created_at->format('d/m/Y') }}</td>
                                        <td>
                                            {{ $order->orderItems->count() }} sản phẩm
                                        </td>
                                        <td>{{ number_format($order->total_amount, 0, ',', '.') }}đ</td>
                                        <td>
                                            <span class="badge {{ $order->status_badge_class }}">
                                                {{ $order->status_text }}
                                            </span>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-3">
                            <i class="fas fa-shopping-cart fa-2x text-muted mb-2"></i>
                            <p class="text-muted">Khách hàng chưa có đơn hàng nào</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Recent Transactions -->
            <div class="card shadow mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h6 class="m-0 font-weight-bold text-primary">Giao dịch gần đây</h6>
                    <a href="#" class="btn btn-sm btn-outline-primary ms-auto">Xem tất cả</a>
                </div>
                <div class="card-body">
                    @if($recentTransactions->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-sm">
                                <thead>
                                    <tr>
                                        <th>Mã GD</th>
                                        <th>Ngày</th>
                                        <th>Loại</th>
                                        <th>Số tiền</th>
                                        <th>Trạng thái</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($recentTransactions as $transaction)
                                    <tr>
                                        <td>
                                            <a href="#" class="text-decoration-none">{{ $transaction->transaction_number }}</a>
                                        </td>
                                        <td>{{ $transaction->created_at->format('d/m/Y H:i') }}</td>
                                        <td>{{ $transaction->type_text }}</td>
                                        <td class="fw-bold 
                                            @if($transaction->type == 'payment') text-danger @else text-success @endif">
                                            @if($transaction->type == 'payment')-@else+@endif{{ number_format($transaction->amount, 0, ',', '.') }}đ
                                        </td>
                                        <td>
                                            <span class="badge {{ $transaction->status_badge_class }}">
                                                {{ $transaction->status_text }}
                                            </span>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-3">
                            <i class="fas fa-credit-card fa-2x text-muted mb-2"></i>
                            <p class="text-muted">Khách hàng chưa có giao dịch nào</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Edit Customer Modal -->
<div class="modal fade" id="editCustomerModal" tabindex="-1" aria-labelledby="editCustomerModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editCustomerModalLabel">Chỉnh sửa thông tin khách hàng</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('admin.customers.update', $customer) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="name" class="form-label">Tên hiển thị</label>
                            <input type="text" class="form-control" id="name" name="name" 
                                   value="{{ $customer->name }}" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" name="email" 
                                   value="{{ $customer->email }}" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="first_name" class="form-label">Họ</label>
                            <input type="text" class="form-control" id="first_name" name="first_name" 
                                   value="{{ $customer->customerProfile->first_name ?? '' }}">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="last_name" class="form-label">Tên</label>
                            <input type="text" class="form-control" id="last_name" name="last_name" 
                                   value="{{ $customer->customerProfile->last_name ?? '' }}">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="phone" class="form-label">Số điện thoại</label>
                            <input type="text" class="form-control" id="phone" name="phone" 
                                   value="{{ $customer->customerProfile->phone ?? '' }}">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="date_of_birth" class="form-label">Ngày sinh</label>
                            <input type="date" class="form-control" id="date_of_birth" name="date_of_birth" 
                                   value="{{ $customer->customerProfile && $customer->customerProfile->date_of_birth ? $customer->customerProfile->date_of_birth->format('Y-m-d') : '' }}">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="gender" class="form-label">Giới tính</label>
                            <select class="form-select" id="gender" name="gender">
                                <option value="">Chọn giới tính</option>
                                <option value="male" {{ ($customer->customerProfile->gender ?? '') == 'male' ? 'selected' : '' }}>Nam</option>
                                <option value="female" {{ ($customer->customerProfile->gender ?? '') == 'female' ? 'selected' : '' }}>Nữ</option>
                                <option value="other" {{ ($customer->customerProfile->gender ?? '') == 'other' ? 'selected' : '' }}>Khác</option>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="city" class="form-label">Thành phố</label>
                            <input type="text" class="form-control" id="city" name="city" 
                                   value="{{ $customer->customerProfile->city ?? '' }}">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="district" class="form-label">Quận/Huyện</label>
                            <input type="text" class="form-control" id="district" name="district" 
                                   value="{{ $customer->customerProfile->district ?? '' }}">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="ward" class="form-label">Phường/Xã</label>
                            <input type="text" class="form-control" id="ward" name="ward" 
                                   value="{{ $customer->customerProfile->ward ?? '' }}">
                        </div>
                        <div class="col-12 mb-3">
                            <label for="address" class="form-label">Địa chỉ chi tiết</label>
                            <textarea class="form-control" id="address" name="address" rows="3">{{ $customer->customerProfile->address ?? '' }}</textarea>
                        </div>
                        <div class="col-12 mb-3">
                            <label for="notes" class="form-label">Ghi chú</label>
                            <textarea class="form-control" id="notes" name="notes" rows="3">{{ $customer->customerProfile->notes ?? '' }}</textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                    <button type="submit" class="btn btn-primary">Lưu thay đổi</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection 