@@ -0,0 +1,258 @@
@extends('layouts.admin.AdminLayout')

@section('content')
<div class="container-fluid">
    <!-- Header -->
    

    <div class="row">
        <!-- Main Content -->
        <div class="col-lg-8">
            <!-- Basic Information -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <div>
                            <h1 class="h3 mb-0 text-gray-800">Chi tiết danh mục: {{ $category->name }}</h1>
                        </div>
                        <div>
                            <a href="{{ route('admin.categories.edit', $category) }}" class="btn btn-sm btn-primary me-2">
                                <i class="fas fa-edit me-2"></i>Chỉnh sửa
                            </a>
                            <a href="{{ route('admin.categories.index') }}" class="btn btn-sm btn-secondary">
                                <i class="fas fa-arrow-left me-2"></i>Quay lại
                            </a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-8">
                            <table class="table table-borderless">
                                <tbody>
                                    <tr>
                                        <th width="150">Tên danh mục:</th>
                                        <td>
                                            <strong>{{ $category->name }}</strong>
                                            @if($category->is_featured)
                                                <span class="badge bg-warning ms-2">
                                                    <i class="fas fa-star"></i> Nổi bật
                                                </span>
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Slug:</th>
                                        <td>
                                            <code>{{ $category->slug }}</code>
                                            <a href="#" class="ms-2 text-muted" title="Copy URL">
                                                <i class="fas fa-copy"></i>
                                            </a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Mô tả:</th>
                                        <td>{{ $category->description ?: 'Chưa có mô tả' }}</td>
                                    </tr>
                                    <tr>
                                        <th>Trạng thái:</th>
                                        <td>
                                            @if($category->is_active)
                                                <span class="badge bg-success">
                                                    <i class="fas fa-eye"></i> Hoạt động
                                                </span>
                                            @else
                                                <span class="badge bg-secondary">
                                                    <i class="fas fa-eye-slash"></i> Ẩn
                                                </span>
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Thứ tự:</th>
                                        <td>{{ $category->sort_order }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="col-md-4 text-center">
                            @if($category->image)
                                <img src="{{ Storage::url($category->image) }}" alt="{{ $category->name }}" 
                                     class="img-fluid rounded shadow" style="max-height: 200px;">
                            @else
                                <div class="bg-light d-flex align-items-center justify-content-center rounded" 
                                     style="height: 200px;">
                                    <i class="fas fa-image fa-3x text-muted"></i>
                                </div>
                                <p class="text-muted mt-2">Chưa có hình ảnh</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Category Hierarchy -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Cấu trúc phân cấp</h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <h6>Thông tin cấp bậc</h6>
                            <ul class="list-unstyled">
                                <li><strong>Cấp độ:</strong> <span class="badge bg-info">Cấp {{ $category->level }}</span></li>
                                <li><strong>Đường dẫn:</strong> {{ $category->full_path }}</li>
                                @if($category->parent)
                                    <li><strong>Danh mục cha:</strong> 
                                        <a href="{{ route('admin.categories.show', $category->parent) }}" class="text-decoration-none">
                                            {{ $category->parent->name }}
                                        </a>
                                    </li>
                                @else
                                    <li><strong>Loại:</strong> <span class="badge bg-primary">Danh mục gốc</span></li>
                                @endif
                            </ul>
                        </div>
                        <div class="col-md-6">
                            <h6>Danh mục con ({{ $category->children->count() }})</h6>
                            @if($category->children->count() > 0)
                                <ul class="list-group list-group-flush">
                                    @foreach($category->children->take(5) as $child)
                                        <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                                            <a href="{{ route('admin.categories.show', $child) }}" class="text-decoration-none">
                                                {{ $child->name }}
                                            </a>
                                            <div>
                                                @if($child->is_active)
                                                    <span class="badge bg-success">Hoạt động</span>
                                                @else
                                                    <span class="badge bg-secondary">Ẩn</span>
                                                @endif
                                            </div>
                                        </li>
                                    @endforeach
                                    @if($category->children->count() > 5)
                                        <li class="list-group-item px-0">
                                            <a href="{{ route('admin.categories.index', ['parent_id' => $category->id]) }}" 
                                               class="text-muted">
                                                Xem thêm {{ $category->children->count() - 5 }} danh mục con...
                                            </a>
                                        </li>
                                    @endif
                                </ul>
                            @else
                                <p class="text-muted">Chưa có danh mục con nào</p>
                                <a href="{{ route('admin.categories.create', ['parent_id' => $category->id]) }}" 
                                   class="btn btn-sm btn-outline-primary">
                                    <i class="fas fa-plus me-1"></i>Thêm danh mục con
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            
        </div>

        <!-- Sidebar -->
        <div class="col-lg-4">
            <!-- Quick Stats -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Thống kê nhanh</h6>
                </div>
                <div class="card-body">
                    <div class="row text-center">
                        <div class="col-6">
                            <div class="border-end">
                                <h4 class="mb-1 text-primary">{{ $category->children->count() }}</h4>
                                <small class="text-muted">Danh mục con</small>
                            </div>
                        </div>
                        <div class="col-6">
                            <h4 class="mb-1 text-success">0</h4>
                            <small class="text-muted">Sản phẩm</small>
                        </div>
                    </div>
                    <hr>
                    <div class="text-center">
                        <h4 class="mb-1 text-info">{{ $category->getAllChildrenIds() ? count($category->getAllChildrenIds()) - 1 : 0 }}</h4>
                        <small class="text-muted">Tổng danh mục con (tất cả cấp)</small>
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Thao tác nhanh</h6>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <a href="{{ route('admin.categories.edit', $category) }}" class="btn btn-primary">
                            <i class="fas fa-edit me-2"></i>Chỉnh sửa danh mục
                        </a>
                        
                        <form action="{{ route('admin.categories.toggle-status', $category) }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-{{ $category->is_active ? 'warning' : 'success' }} w-100">
                                <i class="fas fa-{{ $category->is_active ? 'eye-slash' : 'eye' }} me-2"></i>
                                {{ $category->is_active ? 'Ẩn danh mục' : 'Kích hoạt danh mục' }}
                            </button>
                        </form>

                        <a href="{{ route('admin.categories.create', ['parent_id' => $category->id]) }}" 
                           class="btn btn-outline-primary">
                            <i class="fas fa-plus me-2"></i>Thêm danh mục con
                        </a>

                        @if($category->canDelete())
                            <form action="{{ route('admin.categories.destroy', $category) }}" method="POST" 
                                  onsubmit="return confirm('Bạn có chắc chắn muốn xóa danh mục này?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-outline-danger w-100">
                                    <i class="fas fa-trash me-2"></i>Xóa danh mục
                                </button>
                            </form>
                        @else
                            <button class="btn btn-outline-secondary w-100" disabled>
                                <i class="fas fa-lock me-2"></i>Không thể xóa (có danh mục con)
                            </button>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Category Details -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Chi tiết</h6>
                </div>
                <div class="card-body">
                    <small class="text-muted">
                        <strong>Tạo lúc:</strong><br>
                        {{ $category->created_at->format('d/m/Y H:i:s') }}<br>
                        <em>{{ $category->created_at->diffForHumans() }}</em>
                    </small>
                    <hr>
                    <small class="text-muted">
                        <strong>Cập nhật lần cuối:</strong><br>
                        {{ $category->updated_at->format('d/m/Y H:i:s') }}<br>
                        <em>{{ $category->updated_at->diffForHumans() }}</em>
                    </small>
                    <hr>
                    <small class="text-muted">
                        <strong>ID:</strong> {{ $category->id }}<br>
                        <strong>Slug:</strong> <code>{{ $category->slug }}</code>
                    </small>
                </div>
            </div>

        </div>
    </div>
</div>

@endsection 