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

    <!-- Filter Card -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h1 class="h3 mb-0 text-gray-800">Quản lý khách hàng</h1>
                </div>
                <div>
                    <button class="btn btn-info" onclick="exportCustomers()">
                        <i class="fas fa-download me-2"></i>Xuất Excel
                    </button>
                </div>
            </div>
        </div>
        <div class="card-body">
            <form method="GET" action="{{ route('admin.customers.index') }}">
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label for="search" class="form-label">Tìm kiếm</label>
                        <input type="text" class="form-control" id="search" name="search" 
                               value="{{ request('search') }}" placeholder="Tên, email, số điện thoại...">
                    </div>
                    <div class="col-md-3 mb-3">
                        <label for="is_verified" class="form-label">Trạng thái xác thực</label>
                        <select class="form-select" id="is_verified" name="is_verified">
                            <option value="">Tất cả</option>
                            <option value="1" {{ request('is_verified') == '1' ? 'selected' : '' }}>Đã xác thực</option>
                            <option value="0" {{ request('is_verified') == '0' ? 'selected' : '' }}>Chưa xác thực</option>
                        </select>
                    </div>
                    <div class="col-md-3 mb-3">
                        <label for="city" class="form-label">Thành phố</label>
                        <select class="form-select" id="city" name="city">
                            <option value="">Tất cả thành phố</option>
                            @foreach($cities as $city)
                                <option value="{{ $city }}" {{ request('city') == $city ? 'selected' : '' }}>
                                    {{ $city }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2 mb-3 d-flex align-items-end">
                        <button type="submit" class="btn btn-primary me-2">
                            <i class="fas fa-search"></i> Lọc
                        </button>
                        <a href="{{ route('admin.customers.index') }}" class="btn btn-outline-secondary">
                            <i class="fas fa-undo"></i>
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Customers Card -->
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">
                Danh sách khách hàng ({{ $customers->total() }})
            </h6>
        </div>
        <div class="card-body">
            @if($customers->count() > 0)
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th width="50">ID</th>
                                <th>Thông tin khách hàng</th>
                                <th width="120">Số đơn hàng</th>
                                <th width="120">Tổng chi tiêu</th>
                                <th width="120">Trạng thái</th>
                                <th width="120">Ngày tham gia</th>
                                <th width="150">Thao tác</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($customers as $customer)
                            <tr>
                                <td>{{ $customer->id }}</td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="me-3">
                                            @if($customer->customerProfile && $customer->customerProfile->avatar)
                                                <img src="{{ $customer->customerProfile->avatar }}" 
                                                     alt="{{ $customer->name }}" 
                                                     class="rounded-circle" 
                                                     style="width: 40px; height: 40px; object-fit: cover;">
                                            @else
                                                <div class="bg-primary rounded-circle d-flex align-items-center justify-content-center" 
                                                     style="width: 40px; height: 40px;">
                                                    <small class="text-white fw-bold">
                                                        {{ substr($customer->name, 0, 1) }}
                                                    </small>
                                                </div>
                                            @endif
                                        </div>
                                        <div>
                                            <div class="fw-bold">{{ $customer->display_name }}</div>
                                            <small class="text-muted">{{ $customer->email }}</small>
                                            @if($customer->customerProfile && $customer->customerProfile->phone)
                                                <br><small class="text-muted">{{ $customer->customerProfile->phone }}</small>
                                            @endif
                                        </div>
                                    </div>
                                </td>
                                <td class="text-center">
                                    <span class="badge bg-info">{{ $customer->orders_count }}</span>
                                </td>
                                <td class="text-end">
                                    {{ number_format($customer->orders->where('payment_status', 'paid')->sum('total_amount'), 0, ',', '.') }} đ
                                </td>
                                <td>
                                    @if($customer->customerProfile && $customer->customerProfile->is_verified)
                                        <span class="badge bg-success">
                                            <i class="fas fa-check-circle me-1"></i>Đã xác thực
                                        </span>
                                    @else
                                        <span class="badge bg-warning">
                                            <i class="fas fa-clock me-1"></i>Chưa xác thực
                                        </span>
                                    @endif
                                </td>
                                <td>
                                    <small>{{ $customer->created_at->format('d/m/Y') }}</small>
                                </td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <a href="{{ route('admin.customers.show', $customer) }}" 
                                           class="btn btn-sm btn-info" title="Xem chi tiết">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        
                                        @if($customer->customerProfile && !$customer->customerProfile->is_verified)
                                            <form action="{{ route('admin.customers.verify', $customer) }}" 
                                                  method="POST" style="display: inline;">
                                                @csrf
                                                <button type="submit" class="btn btn-sm btn-success" title="Xác thực">
                                                    <i class="fas fa-check"></i>
                                                </button>
                                            </form>
                                        @else
                                            <form action="{{ route('admin.customers.unverify', $customer) }}" 
                                                  method="POST" style="display: inline;">
                                                @csrf
                                                <button type="submit" class="btn btn-sm btn-warning" title="Hủy xác thực">
                                                    <i class="fas fa-times"></i>
                                                </button>
                                            </form>
                                        @endif
                                        
                                        <form action="{{ route('admin.customers.destroy', $customer) }}" 
                                              method="POST" style="display: inline;" 
                                              onsubmit="return confirm('Bạn có chắc chắn muốn xóa khách hàng này?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger" title="Xóa">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                
                <!-- Pagination -->
                <div class="d-flex justify-content-between align-items-center mt-3">
                    <div>
                        <small class="text-muted">
                            Hiển thị {{ $customers->firstItem() }} đến {{ $customers->lastItem() }} 
                            trong tổng số {{ $customers->total() }} khách hàng
                        </small>
                    </div>
                    <div>
                        {{ $customers->withQueryString()->links() }}
                    </div>
                </div>
            @else
                <div class="text-center py-4">
                    <i class="fas fa-users fa-3x text-muted mb-3"></i>
                    <h5 class="text-muted">Không có khách hàng nào</h5>
                    <p class="text-muted">Chưa có khách hàng nào được tìm thấy với bộ lọc hiện tại.</p>
                </div>
            @endif
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
function exportCustomers() {
    // TODO: Implement export functionality
    alert('Chức năng xuất Excel sẽ được phát triển sau');
}
</script>
@endpush 