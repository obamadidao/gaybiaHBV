@@ -0,0 +1,308 @@
@extends('layouts.admin.AdminLayout')

@section('content')
<div class="container-fluid">

    <!-- Filter Card -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <div class="d-flex justify-content-between align-items-center mb-2">
                <div>
                    <h1 class="h3 mb-0 text-gray-800">Quản lý danh mục sản phẩm bida</h1>
                </div>
                <a href="{{ route('admin.categories.create') }}" class="btn btn-sm btn-primary">
                    <i class="fas fa-plus me-2"></i>Thêm danh mục mới
                </a>
            </div>
        </div>
        <div class="card-body">
            <form method="GET" action="{{ route('admin.categories.index') }}" class="row g-3">
                <div class="col-md-3">
                    <label for="search" class="form-label">Tìm kiếm</label>
                    <input type="text" class="form-control" id="search" name="search"
                        value="{{ request('search') }}" placeholder="Tên hoặc mô tả danh mục...">
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
                    <label for="level" class="form-label">Cấp độ</label>
                    <select class="form-select" id="level" name="level">
                        <option value="">Tất cả cấp</option>
                        <option value="0" {{ request('level') === '0' ? 'selected' : '' }}>Cấp 0 (Gốc)</option>
                        <option value="1" {{ request('level') === '1' ? 'selected' : '' }}>Cấp 1</option>
                        <option value="2" {{ request('level') === '2' ? 'selected' : '' }}>Cấp 2</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label for="parent_id" class="form-label">Danh mục cha</label>
                    <select class="form-select" id="parent_id" name="parent_id">
                        <option value="">Tất cả</option>
                        <option value="root" {{ request('parent_id') == 'root' ? 'selected' : '' }}>Danh mục gốc</option>
                        @foreach($parentCategories as $parent)
                        <option value="{{ $parent->id }}" {{ request('parent_id') == $parent->id ? 'selected' : '' }}>
                            {{ $parent->name }}
                        </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2 d-flex align-items-end">
                    <button type="submit" class="btn btn-outline-primary me-2">
                        <i class="fas fa-search"></i>
                    </button>
                    <a href="{{ route('admin.categories.index') }}" class="btn btn-outline-secondary">
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

    <!-- Categories Table -->
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">
                Danh sách danh mục ({{ $categories->total() }} danh mục)
            </h6>
            <div class="dropdown">
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
            @if($categories->count() > 0)
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th width="50">
                                <input type="checkbox" id="checkAll" class="form-check-input">
                            </th>
                            <th>Danh mục</th>
                            <th width="120">Hình ảnh</th>
                            <th width="150">Danh mục cha</th>
                            <th width="100" class="text-center">Cấp độ</th>
                            <th width="100" class="text-center">Thứ tự</th>
                            <th width="100" class="text-center">Trạng thái</th>
                            <th width="100" class="text-center">Nổi bật</th>
                            <th width="200" class="text-center">Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($categories as $category)
                        <tr>
                            <td>
                                <input type="checkbox" name="category_ids[]" value="{{ $category->id }}" class="form-check-input category-checkbox">
                            </td>
                            <td>
                                <div class="d-flex align-items-center">
                                    @if($category->level > 0)
                                    <span style="margin-left: {{ $category->level * 20 }}px" class="text-muted me-2">
                                        {!! str_repeat('&nbsp;&nbsp;&nbsp;&nbsp;', $category->level) !!}└─
                                    </span>
                                    @endif
                                    <div>
                                        <h6 class="mb-1">{{ $category->name }}</h6>
                                        @if($category->description)
                                        <small class="text-muted">{{ Str::limit($category->description, 60) }}</small>
                                        @endif
                                        <div class="mt-1">
                                            <small class="text-info">{{ $category->slug }}</small>
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td class="text-center">
                                @if($category->image)
                                <img src="{{ Storage::url($category->image) }}" alt="{{ $category->name }}" class="img-thumbnail" style="width: 60px; height: 60px; object-fit: cover;">
                                @else
                                <div class="bg-light d-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
                                    <i class="fas fa-image text-muted"></i>
                                </div>
                                @endif
                            </td>
                            <td>
                                @if($category->parent)
                                <span class="badge bg-secondary">{{ $category->parent->name }}</span>
                                @else
                                <span class="badge bg-primary">Danh mục gốc</span>
                                @endif
                            </td>
                            <td class="text-center">
                                <span class="badge bg-info">Cấp {{ $category->level }}</span>
                            </td>
                            <td class="text-center">
                                <span class="badge bg-dark">{{ $category->sort_order }}</span>
                            </td>
                            <td class="text-center">
                                <form action="{{ route('admin.categories.toggle-status', $category) }}" method="POST" style="display: inline;">
                                    @csrf
                                    <button type="submit" class="btn btn-sm {{ $category->is_active ? 'btn-success' : 'btn-secondary' }}" title="{{ $category->is_active ? 'Ẩn danh mục' : 'Kích hoạt danh mục' }}">
                                        <i class="fas {{ $category->is_active ? 'fa-eye' : 'fa-eye-slash' }}"></i>
                                    </button>
                                </form>
                            </td>
                            <td class="text-center">
                                @if($category->is_featured)
                                <span class="badge bg-warning">
                                    <i class="fas fa-star"></i>
                                </span>
                                @else
                                <span class="badge bg-light text-dark">
                                    <i class="far fa-star"></i>
                                </span>
                                @endif
                            </td>
                            <td class="text-center">
                                <div class="btn-group" role="group">
                                    <a href="{{ route('admin.categories.show', $category) }}" class="btn btn-sm btn-outline-info" title="Xem chi tiết">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('admin.categories.edit', $category) }}" class="btn btn-sm btn-outline-primary" title="Chỉnh sửa">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    @if($category->canDelete())
                                    <form action="{{ route('admin.categories.destroy', $category) }}" method="POST" style="display: inline;" onsubmit="return confirm('Bạn có chắc chắn muốn xóa danh mục này?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger" title="Xóa">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                    @else
                                    <button class="btn btn-sm btn-outline-secondary" disabled title="Không thể xóa vì có danh mục con">
                                        <i class="fas fa-lock"></i>
                                    </button>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="card-footer">
                {{ $categories->appends(request()->query())->links() }}
            </div>
            @else
            <div class="text-center py-5">
                <i class="fas fa-folder-open fa-3x text-muted mb-3"></i>
                <h5 class="text-muted">Không có danh mục nào</h5>
                <p class="text-muted">Hãy thêm danh mục đầu tiên cho cửa hàng bida của bạn</p>
                <a href="{{ route('admin.categories.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus me-2"></i>Thêm danh mục mới
                </a>
            </div>
            @endif
        </div>
    </div>
</div>

<!-- Bulk Action Form -->
<form id="bulkActionForm" action="{{ route('admin.categories.bulk-action') }}" method="POST" style="display: none;">
    @csrf
    <input type="hidden" name="action" id="bulkActionType">
    <div id="bulkCategoryIds"></div>
</form>

@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        // Check all functionality
        $('#checkAll').change(function() {
            $('.category-checkbox').prop('checked', this.checked);
            toggleBulkActionButton();
        });

        // Individual checkbox change
        $('.category-checkbox').change(function() {
            if ($('.category-checkbox:checked').length === $('.category-checkbox').length) {
                $('#checkAll').prop('checked', true);
            } else {
                $('#checkAll').prop('checked', false);
            }
            toggleBulkActionButton();
        });

        function toggleBulkActionButton() {
            const checkedCount = $('.category-checkbox:checked').length;
            $('#bulkActionBtn').prop('disabled', checkedCount === 0);
        }
    });

    function bulkAction(action) {
        const checkedIds = $('.category-checkbox:checked').map(function() {
            return this.value;
        }).get();

        if (checkedIds.length === 0) {
            alert('Vui lòng chọn ít nhất một danh mục!');
            return;
        }

        let confirmMessage = '';
        switch (action) {
            case 'delete':
                confirmMessage = `Bạn có chắc chắn muốn xóa ${checkedIds.length} danh mục đã chọn?`;
                break;
            case 'activate':
                confirmMessage = `Bạn có chắc chắn muốn kích hoạt ${checkedIds.length} danh mục đã chọn?`;
                break;
            case 'deactivate':
                confirmMessage = `Bạn có chắc chắn muốn ẩn ${checkedIds.length} danh mục đã chọn?`;
                break;
        }

        if (confirm(confirmMessage)) {
            $('#bulkActionType').val(action);
            $('#bulkCategoryIds').empty();

            checkedIds.forEach(function(id) {
                $('#bulkCategoryIds').append(`<input type="hidden" name="category_ids[]" value="${id}">`);
            });

            $('#bulkActionForm').submit();
        }
    }
</script>
@endpush