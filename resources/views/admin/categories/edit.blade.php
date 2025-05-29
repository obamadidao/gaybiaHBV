@@ -0,0 +1,283 @@
@extends('layouts.admin.AdminLayout')

@section('content')
<div class="container-fluid">
    <!-- Header -->
    <form action="{{ route('admin.categories.update', $category) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="row">
            <!-- Main Form -->
            <div class="col-lg-8">
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <div>
                                <h1 class="h3 mb-0 text-gray-800">Chỉnh sửa danh mục sản phẩm: {{ $category->name }}</h1>
                            </div>
                            
                            <a href="{{ route('admin.categories.index') }}" class="btn btn-sm btn-secondary">
                                <i class="fas fa-arrow-left me-2"></i>Quay lại
                            </a>
                            
                            
                        </div>
                    </div>
                    <div class="card-body">
                        <!-- Name -->
                        <div class="mb-3">
                            <label for="name" class="form-label">Tên danh mục <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                   id="name" name="name" value="{{ old('name', $category->name) }}" 
                                   placeholder="Nhập tên danh mục bida...">
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Slug -->
                        <div class="mb-3">
                            <label for="slug" class="form-label">Slug (URL)</label>
                            <input type="text" class="form-control @error('slug') is-invalid @enderror" 
                                   id="slug" name="slug" value="{{ old('slug', $category->slug) }}" 
                                   placeholder="Tự động tạo từ tên danh mục">
                            <div class="form-text">Để trống để tự động tạo từ tên danh mục</div>
                            @error('slug')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Description -->
                        <div class="mb-3">
                            <label for="description" class="form-label">Mô tả</label>
                            <textarea class="form-control @error('description') is-invalid @enderror" 
                                      id="description" name="description" rows="4" 
                                      placeholder="Mô tả về danh mục sản phẩm bida...">{{ old('description', $category->description) }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Current Image -->
                        @if($category->image)
                            <div class="mb-3">
                                <label class="form-label">Hình ảnh hiện tại</label>
                                <div class="d-flex align-items-center">
                                    <img src="{{ Storage::url($category->image) }}" alt="{{ $category->name }}" 
                                         class="img-thumbnail me-3" style="width: 120px; height: 120px; object-fit: cover;">
                                    <div>
                                        <p class="mb-1 text-muted">{{ basename($category->image) }}</p>
                                        <small class="text-muted">Chọn hình ảnh mới để thay thế</small>
                                    </div>
                                </div>
                            </div>
                        @endif

                        <!-- Image -->
                        <div class="mb-3">
                            <label for="image" class="form-label">
                                {{ $category->image ? 'Thay đổi hình ảnh' : 'Hình ảnh' }}
                            </label>
                            <input type="file" class="form-control @error('image') is-invalid @enderror" 
                                   id="image" name="image" accept="image/*">
                            <div class="form-text">Chọn hình ảnh cho danh mục (JPG, PNG, GIF, tối đa 2MB)</div>
                            @error('image')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <!-- Preview -->
                            <div id="imagePreview" class="mt-2" style="display: none;">
                                <img id="preview" src="" alt="Preview" class="img-thumbnail" style="max-width: 200px;">
                            </div>
                        </div>
                    </div>
                </div>

                
            </div>

            <!-- Sidebar -->
            <div class="col-lg-4">
                <!-- Publish -->
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Xuất bản</h6>
                    </div>
                    <div class="card-body">
                        <!-- Status -->
                        <div class="mb-3">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" id="is_active" 
                                       name="is_active" value="1" {{ old('is_active', $category->is_active) ? 'checked' : '' }}>
                                <label class="form-check-label" for="is_active">
                                    Hoạt động
                                </label>
                            </div>
                        </div>

                        <!-- Featured -->
                        <div class="mb-3">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" id="is_featured" 
                                       name="is_featured" value="1" {{ old('is_featured', $category->is_featured) ? 'checked' : '' }}>
                                <label class="form-check-label" for="is_featured">
                                    Danh mục nổi bật
                                </label>
                            </div>
                        </div>

                        <!-- Submit Buttons -->
                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-2"></i>Cập nhật danh mục
                            </button>
                            <a href="{{ route('admin.categories.index') }}" class="btn btn-outline-secondary">
                                <i class="fas fa-times me-2"></i>Hủy bỏ
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Category Hierarchy -->
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Phân cấp danh mục</h6>
                    </div>
                    <div class="card-body">
                        <!-- Current Level Info -->
                        <div class="mb-3">
                            <label class="form-label">Thông tin hiện tại</label>
                            <div class="p-2 bg-light rounded">
                                <small class="text-muted">Cấp độ:</small> 
                                <span class="badge bg-info">Cấp {{ $category->level }}</span>
                                <br>
                                <small class="text-muted">Đường dẫn:</small> 
                                <span class="text-dark">{{ $category->full_path }}</span>
                            </div>
                        </div>

                        <!-- Parent Category -->
                        <div class="mb-3">
                            <label for="parent_id" class="form-label">Danh mục cha</label>
                            <select class="form-select @error('parent_id') is-invalid @enderror" 
                                    id="parent_id" name="parent_id">
                                <option value="">-- Danh mục gốc --</option>
                                @foreach($parentCategories as $parent)
                                    <option value="{{ $parent->id }}" 
                                            {{ old('parent_id', $category->parent_id) == $parent->id ? 'selected' : '' }}>
                                        {{ $parent->name }}
                                    </option>
                                @endforeach
                            </select>
                            <div class="form-text">Chọn danh mục cha (để trống nếu là danh mục gốc)</div>
                            @error('parent_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Sort Order -->
                        <div class="mb-3">
                            <label for="sort_order" class="form-label">Thứ tự sắp xếp</label>
                            <input type="number" class="form-control @error('sort_order') is-invalid @enderror" 
                                   id="sort_order" name="sort_order" value="{{ old('sort_order', $category->sort_order) }}" 
                                   min="0" step="1">
                            <div class="form-text">Số càng nhỏ hiển thị càng trước</div>
                            @error('sort_order')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        @if($category->children->count() > 0)
                            <div class="alert alert-warning small">
                                <i class="fas fa-exclamation-triangle me-2"></i>
                                <strong>Lưu ý:</strong> Danh mục này có {{ $category->children->count() }} danh mục con. 
                                Thay đổi danh mục cha có thể ảnh hưởng đến cấu trúc.
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Category Stats -->
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Thống kê</h6>
                    </div>
                    <div class="card-body">
                        <div class="row text-center">
                            <div class="col-6">
                                <div class="border-end">
                                    <h5 class="mb-0">{{ $category->children->count() }}</h5>
                                    <small class="text-muted">Danh mục con</small>
                                </div>
                            </div>
                            <div class="col-6">
                                <h5 class="mb-0">0</h5>
                                <small class="text-muted">Sản phẩm</small>
                            </div>
                        </div>
                        <hr>
                        <div class="text-center">
                            <small class="text-muted">
                                Tạo: {{ $category->created_at->format('d/m/Y H:i') }}<br>
                                Cập nhật: {{ $category->updated_at->format('d/m/Y H:i') }}
                            </small>
                        </div>
                    </div>
                </div>

                <!-- Tips -->
                <div class="card shadow mb-4 border-left-info">
                    <div class="card-body">
                        <h6 class="text-info"><i class="fas fa-info-circle me-2"></i>Gợi ý</h6>
                                                <ul class="small mb-0">                            <li>Thay đổi slug sẽ ảnh hưởng đến URL danh mục</li>                            <li>Kiểm tra lại cấu trúc danh mục sau khi thay đổi cha</li>                            <li>Hình ảnh mới sẽ thay thế hình ảnh cũ</li>                            <li>Thay đổi thứ tự sẽ ảnh hưởng đến hiển thị</li>                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

@endsection

@push('scripts')
<script>
$(document).ready(function() {
    // Auto generate slug from name (only if manually editing)
    let manualSlugEdit = false;
    
    $('#slug').on('input', function() {
        manualSlugEdit = true;
    });

    $('#name').on('input', function() {
        if (!manualSlugEdit) {
            const name = $(this).val();
            const slug = generateSlug(name);
            $('#slug').val(slug);
        }
    });

    // Image preview
    $('#image').on('change', function() {
        const file = this.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                $('#preview').attr('src', e.target.result);
                $('#imagePreview').show();
            };
            reader.readAsDataURL(file);
        } else {
            $('#imagePreview').hide();
        }
    });

    function generateSlug(text) {
        return text
            .toLowerCase()
            .replace(/[^\w\s-]/g, '') // Remove special characters
            .replace(/[\s_-]+/g, '-') // Replace spaces and underscores with hyphens
            .replace(/^-+|-+$/g, ''); // Remove leading/trailing hyphens
    }
});
</script>
@endpush 