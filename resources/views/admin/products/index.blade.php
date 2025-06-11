@extends('layouts.admin.AdminLayout')

@section('content')
<div class="container-fluid">

    <!-- Filter Card -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <div class="d-flex justify-content-between align-items-center mb-2">
                <div>
                    <h1 class="h3 mb-0 text-gray-800">Quản lý sản phẩm bida</h1>
                </div>
                <a href="{{ route('admin.products.create') }}" class="btn btn-sm btn-primary">
                    <i class="fas fa-plus me-2"></i>Thêm sản phẩm mới
                </a>
            </div>
        </div>
        <div class="card-body">
            <form method="GET" action="{{ route('admin.products.index') }}" class="row g-3">
                <div class="col-md-3">
                    <label for="search" class="form-label">Tìm kiếm</label>
                    <input type="text" class="form-control" id="search" name="search" 
                           value="{{ request('search') }}" placeholder="Tên, SKU, mô tả...">
                </div>
                <div class="col-md-2">
                    <label for="category_id" class="form-label">Danh mục</label>
                    <select class="form-select" id="category_id" name="category_id">
                        <option value="">Tất cả</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <label for="brand" class="form-label">Thương hiệu</label>
                    <select class="form-select" id="brand" name="brand">
                        <option value="">Tất cả</option>
                        @foreach($brands as $brand)
                            <option value="{{ $brand }}" {{ request('brand') == $brand ? 'selected' : '' }}>
                                {{ $brand }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <label for="status" class="form-label">Trạng thái</label>
                    <select class="form-select" id="status" name="status">
                        <option value="">Tất cả</option>
                        <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Hoạt động</option>
                        <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Ẩn</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <label for="stock_status" class="form-label">Tồn kho</label>
                    <select class="form-select" id="stock_status" name="stock_status">
                        <option value="">Tất cả</option>
                        <option value="in_stock" {{ request('stock_status') == 'in_stock' ? 'selected' : '' }}>Còn hàng</option>
                        <option value="low_stock" {{ request('stock_status') == 'low_stock' ? 'selected' : '' }}>Sắp hết</option>
                        <option value="out_of_stock" {{ request('stock_status') == 'out_of_stock' ? 'selected' : '' }}>Hết hàng</option>
                    </select>
                </div>
                <div class="col-md-1 d-flex align-items-end">
                    <button type="submit" class="btn btn-outline-primary me-2">
                        <i class="fas fa-search"></i>
                    </button>
                    <a href="{{ route('admin.products.index') }}" class="btn btn-outline-secondary">
                        <i class="fas fa-undo"></i>
                    </a>
                </div>
            </form>
        </div>
    </div>

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

    <!-- Products Table -->
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">
                Danh sách sản phẩm ({{ $products->total() }} sản phẩm)
            </h6>
            <div class="dropdown ms-auto">
                <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false" id="bulkActionBtn" disabled>
                    Thao tác hàng loạt
                </button>
                <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="#" onclick="bulkAction('activate')">
                            <i class="fas fa-eye text-success me-2"></i>Kích hoạt
                        </a></li>
                    <li><a class="dropdown-item" href="#" onclick="bulkAction('deactivate')">
                            <i class="fas fa-eye-slash text-warning me-2"></i>Ẩn
                        </a></li>
                    <li><a class="dropdown-item" href="#" onclick="bulkAction('feature')">
                            <i class="fas fa-star text-warning me-2"></i>Đánh dấu nổi bật
                        </a></li>
                    <li><a class="dropdown-item" href="#" onclick="bulkAction('unfeature')">
                            <i class="far fa-star text-muted me-2"></i>Bỏ nổi bật
                        </a></li>
                    <li>
                        <hr class="dropdown-divider">
                    </li>
                    <li><a class="dropdown-item text-danger" href="#" onclick="bulkAction('delete')">
                            <i class="fas fa-trash me-2"></i>Xóa
                        </a></li>
                </ul>
            </div>
        </div>
        <div class="card-body p-0">
            @if($products->count() > 0)
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th width="50">
                                <input type="checkbox" id="checkAll" class="form-check-input">
                            </th>
                            <th>Sản phẩm</th>
                            <th width="120">Hình ảnh</th>
                            <th width="150">Danh mục</th>
                            <th width="120">Giá</th>
                            <th width="100" class="text-center">Tồn kho</th>
                            <th width="80" class="text-center">Biến thể</th>
                            <th width="80" class="text-center">Đánh giá</th>
                            <th width="100" class="text-center">Trạng thái</th>
                            <th width="200" class="text-center">Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($products as $product)
                        <tr>
                            <td>
                                <input type="checkbox" name="product_ids[]" value="{{ $product->id }}" class="form-check-input product-checkbox">
                            </td>
                            <td>
                                <div class="d-flex align-items-start">
                                    <div>
                                        <h6 class="mb-1">{{ $product->name }}</h6>
                                        @if($product->short_description)
                                        <small class="text-muted">{{ Str::limit($product->short_description, 80) }}</small>
                                        @endif
                                        <div class="mt-1">
                                            <small class="text-info">SKU: {{ $product->sku }}</small>
                                            @if($product->brand)
                                                <span class="badge bg-light text-dark ms-1">{{ $product->brand }}</span>
                                            @endif
                                            @if($product->is_featured)
                                                <span class="badge bg-warning ms-1">
                                                    <i class="fas fa-star"></i> Nổi bật
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td class="text-center">
                                @if($product->primaryImage)
                                <img src="{{ $product->primaryImage->url }}" alt="{{ $product->name }}" class="img-thumbnail" style="width: 60px; height: 60px; object-fit: cover;">
                                @else
                                <div class="bg-light d-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
                                    <i class="fas fa-image text-muted"></i>
                                </div>
                                @endif
                            </td>
                            <td>
                                <span class="badge bg-secondary">{{ $product->category->name }}</span>
                            </td>
                            <td>
                                <div>
                                    <strong>{{ $product->formatted_price }}</strong>
                                    @if($product->compare_price)
                                        <br><small class="text-muted text-decoration-line-through">{{ $product->formatted_compare_price }}</small>
                                    @endif
                                </div>
                            </td>
                            <td class="text-center">
                                @if($product->track_quantity)
                                    @if($product->stock_quantity <= 0)
                                        <span class="badge bg-danger">Hết hàng</span>
                                    @elseif($product->isLowStock())
                                        <span class="badge bg-warning">{{ $product->stock_quantity }}</span>
                                    @else
                                        <span class="badge bg-success">{{ $product->stock_quantity }}</span>
                                    @endif
                                @else
                                    <span class="badge bg-info">Không theo dõi</span>
                                @endif
                            </td>
                            <td class="text-center">
                                <span class="badge bg-primary">{{ $product->variants_count }}</span>
                            </td>
                            <td class="text-center">
                                <div>
                                    <span class="badge bg-success">{{ $product->approved_reviews_count }}</span>
                                    @if($product->approved_reviews_count > 0)
                                        <br><small class="text-warning">
                                            @for($i = 1; $i <= 5; $i++)
                                                @if($i <= $product->average_rating)
                                                    <i class="fas fa-star"></i>
                                                @else
                                                    <i class="far fa-star"></i>
                                                @endif
                                            @endfor
                                        </small>
                                    @endif
                                </div>
                            </td>
                            <td class="text-center">
                                <form action="{{ route('admin.products.toggle-status', $product) }}" method="POST" style="display: inline;">
                                    @csrf
                                    <button type="submit" class="btn btn-sm {{ $product->is_active ? 'btn-success' : 'btn-secondary' }}" title="{{ $product->is_active ? 'Ẩn sản phẩm' : 'Kích hoạt sản phẩm' }}">
                                        <i class="fas {{ $product->is_active ? 'fa-eye' : 'fa-eye-slash' }}"></i>
                                    </button>
                                </form>
                                <form action="{{ route('admin.products.toggle-featured', $product) }}" method="POST" style="display: inline;">
                                    @csrf
                                    <button type="submit" class="btn btn-sm {{ $product->is_featured ? 'btn-warning' : 'btn-outline-warning' }}" title="{{ $product->is_featured ? 'Bỏ nổi bật' : 'Đánh dấu nổi bật' }}">
                                        <i class="fas fa-star"></i>
                                    </button>
                                </form>
                            </td>
                            <td class="text-center">
                                <div class="btn-group" role="group">
                                    <a href="{{ route('admin.products.show', $product) }}" class="btn btn-sm btn-outline-info" title="Xem chi tiết">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('admin.products.edit', $product) }}" class="btn btn-sm btn-outline-primary" title="Chỉnh sửa">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    @if($product->reviews_count > 0)
                                    <a href="{{ route('admin.products.reviews', $product) }}" class="btn btn-sm btn-outline-success" title="Xem đánh giá">
                                        <i class="fas fa-comments"></i>
                                    </a>
                                    @endif
                                    <form action="{{ route('admin.products.destroy', $product) }}" method="POST" style="display: inline;" onsubmit="return confirm('Bạn có chắc chắn muốn xóa sản phẩm này?')">
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
            <div class="card-footer">
                {{ $products->appends(request()->query())->links() }}
            </div>
            @else
            <div class="text-center py-5">
                <i class="fas fa-box-open fa-3x text-muted mb-3"></i>
                <h5 class="text-muted">Không có sản phẩm nào</h5>
                <p class="text-muted">Hãy thêm sản phẩm đầu tiên cho cửa hàng bida của bạn</p>
                <a href="{{ route('admin.products.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus me-2"></i>Thêm sản phẩm mới
                </a>
            </div>
            @endif
        </div>
    </div>
</div>

<!-- Bulk Action Form -->
<form id="bulkActionForm" action="{{ route('admin.products.bulk-action') }}" method="POST" style="display: none;">
    @csrf
    <input type="hidden" name="action" id="bulkActionType">
    <div id="bulkProductIds"></div>
</form>

@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        // Check all functionality
        $('#checkAll').change(function() {
            $('.product-checkbox').prop('checked', this.checked);
            toggleBulkActionButton();
        });

        // Individual checkbox change
        $('.product-checkbox').change(function() {
            if ($('.product-checkbox:checked').length === $('.product-checkbox').length) {
                $('#checkAll').prop('checked', true);
            } else {
                $('#checkAll').prop('checked', false);
            }
            toggleBulkActionButton();
        });

        function toggleBulkActionButton() {
            const checkedCount = $('.product-checkbox:checked').length;
            $('#bulkActionBtn').prop('disabled', checkedCount === 0);
        }
    });

    function bulkAction(action) {
        const checkedIds = $('.product-checkbox:checked').map(function() {
            return this.value;
        }).get();

        if (checkedIds.length === 0) {
            alert('Vui lòng chọn ít nhất một sản phẩm!');
            return;
        }

        let confirmMessage = '';
        switch (action) {
            case 'delete':
                confirmMessage = `Bạn có chắc chắn muốn xóa ${checkedIds.length} sản phẩm đã chọn?`;
                break;
            case 'activate':
                confirmMessage = `Bạn có chắc chắn muốn kích hoạt ${checkedIds.length} sản phẩm đã chọn?`;
                break;
            case 'deactivate':
                confirmMessage = `Bạn có chắc chắn muốn ẩn ${checkedIds.length} sản phẩm đã chọn?`;
                break;
            case 'feature':
                confirmMessage = `Bạn có chắc chắn muốn đánh dấu nổi bật ${checkedIds.length} sản phẩm đã chọn?`;
                break;
            case 'unfeature':
                confirmMessage = `Bạn có chắc chắn muốn bỏ đánh dấu nổi bật ${checkedIds.length} sản phẩm đã chọn?`;
                break;
        }

        if (confirm(confirmMessage)) {
            $('#bulkActionType').val(action);
            $('#bulkProductIds').empty();

            checkedIds.forEach(function(id) {
                $('#bulkProductIds').append(`<input type="hidden" name="product_ids[]" value="${id}">`);
            });

            $('#bulkActionForm').submit();
        }
    }
</script>
@endpush 