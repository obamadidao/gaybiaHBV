@extends('layouts.admin.AdminLayout')

@section('content')
<div class="container-fluid">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0 text-gray-800">Quản lý kho hàng</h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active">Quản lý kho hàng</li>
                </ol>
            </nav>
        </div>
    </div>


    <!-- Alert Messages -->
    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif

    <!-- Filter -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h1 class="h3 mb-0 text-gray-800">Quản lý kho hàng</h1>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.inventory.index') }}" method="GET" class="row g-3">
                <div class="col-md-4">
                    <label class="form-label">Tìm kiếm</label>
                    <input type="text" name="search" class="form-control"
                        value="{{ request('search') }}"
                        placeholder="Tên sản phẩm, SKU sản phẩm hoặc SKU biến thể">
                </div>
                <div class="col-md-3">
                    <label class="form-label">Loại biến thể</label>
                    <select name="variant_type" class="form-select">
                        <option value="">Tất cả</option>
                        @foreach(App\Models\ProductVariant::VARIANT_TYPES as $key => $value)
                        <option value="{{ $key }}" {{ request('variant_type') == $key ? 'selected' : '' }}>{{ $value }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <label class="form-label">Giá từ</label>
                    <input type="number" name="price_from" class="form-control" value="{{ request('price_from') }}" placeholder="VNĐ">
                </div>
                <div class="col-md-2">
                    <label class="form-label">Giá đến</label>
                    <input type="number" name="price_to" class="form-control" value="{{ request('price_to') }}" placeholder="VNĐ">
                </div>
                <div class="col-md-1 d-flex align-items-end">
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="fas fa-search"></i> Tìm kiếm
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Variants List -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Danh sách biến thể</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="variantsTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Sản phẩm</th>
                            <th>SKU</th>
                            <th>Loại biến thể</th>
                            <th>Tên biến thể</th>
                            <th>Giá trị</th>
                            <th>SKU</th>
                            <th>Tồn kho</th>
                            <th>Giá bán</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($variants as $variant)
                        <tr>
                            <td>{{ $variant->id }}</td>
                            <td>
                                <div class="d-flex align-items-center">
                                    @if($variant->product->images->isNotEmpty())
                                    <img src="{{ asset('storage/' . $variant->product->images->first()->path) }}"
                                        class="img-thumbnail me-2" style="width: 50px; height: 50px; object-fit: cover;">
                                    @endif
                                    <div>
                                        <div class="fw-bold">{{ $variant->product->name }}</div>
                                        <small class="text-muted">{{ $variant->product->sku }}</small>
                                    </div>
                                </div>
                            </td>
                            <td>{{ $variant->sku ?: 'N/A' }}</td>

                            <td>{{ $variant->variant_type_name }}</td>
                            <td>{{ $variant->variant_name }}</td>
                            <td>{{ $variant->variant_value }}</td>
                            <td>{{ $variant->sku ?: 'N/A' }}</td>
                            <td>
                                {{ $variant->stock_quantity }}
                                @if($variant->stock_quantity <= $variant->min_stock)
                                    <span class="badge bg-danger">Thấp</span>
                                    @endif
                            </td>
                            <td>{{ number_format($variant->product->base_price + $variant->price_adjustment) }}đ</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        $('#variantsTable').DataTable({
            language: {
                url: '//cdn.datatables.net/plug-ins/1.13.7/i18n/vi.json'
            }
        });
    });
</script>