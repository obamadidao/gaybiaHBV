@extends('layouts.admin.AdminLayout')

@section('content')
<div class="container-fluid">

    <!-- Header -->
    

    <!-- Alert Messages -->
    @if ($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <h6><i class="fas fa-exclamation-triangle me-2"></i>Có lỗi xảy ra:</h6>
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        
        <div class="row">
            <!-- Main Content -->
            <div class="col-lg-8">
                <!-- Basic Information -->
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h1 class="h3 mb-0 text-gray-800">Thêm sản phẩm mới</h1>
                            </div>
                            <a href="{{ route('admin.products.index') }}" class="btn btn-sm btn-secondary">
                                <i class="fas fa-arrow-left me-2"></i>Quay lại
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <label for="name" class="form-label">Tên sản phẩm <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                       id="name" name="name" value="{{ old('name') }}" required>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="sku" class="form-label">SKU</label>
                                <input type="text" class="form-control @error('sku') is-invalid @enderror" 
                                       id="sku" name="sku" value="{{ old('sku') }}" placeholder="Tự động tạo nếu để trống">
                                @error('sku')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="category_id" class="form-label">Danh mục <span class="text-danger">*</span></label>
                                <select class="form-select @error('category_id') is-invalid @enderror" 
                                        id="category_id" name="category_id" required>
                                    <option value="">Chọn danh mục</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                            {{ $category->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('category_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label for="brand" class="form-label">Thương hiệu</label>
                                <input type="text" class="form-control @error('brand') is-invalid @enderror" 
                                       id="brand" name="brand" value="{{ old('brand') }}">
                                @error('brand')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="model" class="form-label">Mẫu</label>
                                <input type="text" class="form-control @error('model') is-invalid @enderror" 
                                       id="model" name="model" value="{{ old('model') }}">
                                @error('model')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="material" class="form-label">Chất liệu</label>
                                <input type="text" class="form-control @error('material') is-invalid @enderror" 
                                       id="material" name="material" value="{{ old('material') }}">
                                @error('material')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="short_description" class="form-label">Mô tả ngắn</label>
                            <textarea class="form-control @error('short_description') is-invalid @enderror" 
                                      id="short_description" name="short_description" rows="2">{{ old('short_description') }}</textarea>
                            @error('short_description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label">Mô tả chi tiết</label>
                            <textarea class="form-control @error('description') is-invalid @enderror" 
                                      id="description" name="description" rows="5">{{ old('description') }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Pricing -->
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Thông tin giá</h6>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label for="base_price" class="form-label">Giá bán <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <input type="number" class="form-control @error('base_price') is-invalid @enderror" 
                                           id="base_price" name="base_price" value="{{ old('base_price') }}" 
                                           min="0" step="1000" required>
                                    <span class="input-group-text">VNĐ</span>
                                    @error('base_price')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="compare_price" class="form-label">Giá so sánh</label>
                                <div class="input-group">
                                    <input type="number" class="form-control @error('compare_price') is-invalid @enderror" 
                                           id="compare_price" name="compare_price" value="{{ old('compare_price') }}" 
                                           min="0" step="1000">
                                    <span class="input-group-text">VNĐ</span>
                                    @error('compare_price')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="cost_price" class="form-label">Giá vốn</label>
                                <div class="input-group">
                                    <input type="number" class="form-control @error('cost_price') is-invalid @enderror" 
                                           id="cost_price" name="cost_price" value="{{ old('cost_price') }}" 
                                           min="0" step="1000">
                                    <span class="input-group-text">VNĐ</span>
                                    @error('cost_price')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Inventory -->
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Quản lý tồn kho</h6>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="stock_quantity" class="form-label">Số lượng tồn kho <span class="text-danger">*</span></label>
                                <input type="number" class="form-control @error('stock_quantity') is-invalid @enderror" 
                                       id="stock_quantity" name="stock_quantity" value="{{ old('stock_quantity', 0) }}" 
                                       min="0" required>
                                @error('stock_quantity')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="min_stock" class="form-label">Tồn kho tối thiểu <span class="text-danger">*</span></label>
                                <input type="number" class="form-control @error('min_stock') is-invalid @enderror" 
                                       id="min_stock" name="min_stock" value="{{ old('min_stock', 1) }}" 
                                       min="0" required>
                                @error('min_stock')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <div class="form-check">
                                    <input type="hidden" name="track_quantity" value="0">
                                    <input class="form-check-input" type="checkbox" name="track_quantity" value="1" 
                                           id="track_quantity" {{ old('track_quantity', 1) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="track_quantity">
                                        Theo dõi tồn kho
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-4 mb-3">
                                <div class="form-check">
                                    <input type="hidden" name="is_digital" value="0">
                                    <input class="form-check-input" type="checkbox" name="is_digital" value="1" 
                                           id="is_digital" {{ old('is_digital') ? 'checked' : '' }}>
                                    <label class="form-check-label" for="is_digital">
                                        Sản phẩm số
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Physical Properties -->
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Thông số vật lý</h6>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-3 mb-3">
                                <label for="weight" class="form-label">Trọng lượng</label>
                                <div class="input-group">
                                    <input type="number" class="form-control @error('weight') is-invalid @enderror" 
                                           id="weight" name="weight" value="{{ old('weight') }}" 
                                           min="0" step="0.1">
                                    <span class="input-group-text">gram</span>
                                    @error('weight')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-3 mb-3">
                                <label for="length" class="form-label">Chiều dài</label>
                                <div class="input-group">
                                    <input type="number" class="form-control @error('length') is-invalid @enderror" 
                                           id="length" name="length" value="{{ old('length') }}" 
                                           min="0" step="0.1">
                                    <span class="input-group-text">cm</span>
                                    @error('length')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-3 mb-3">
                                <label for="width" class="form-label">Chiều rộng</label>
                                <div class="input-group">
                                    <input type="number" class="form-control @error('width') is-invalid @enderror" 
                                           id="width" name="width" value="{{ old('width') }}" 
                                           min="0" step="0.1">
                                    <span class="input-group-text">cm</span>
                                    @error('width')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-3 mb-3">
                                <label for="height" class="form-label">Chiều cao</label>
                                <div class="input-group">
                                    <input type="number" class="form-control @error('height') is-invalid @enderror" 
                                           id="height" name="height" value="{{ old('height') }}" 
                                           min="0" step="0.1">
                                    <span class="input-group-text">cm</span>
                                    @error('height')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Product Variants -->
                <div class="card shadow mb-4">
                    <div class="card-header py-3 d-flex justify-content-between align-items-center">
                        <h6 class="m-0 font-weight-bold text-primary">Biến thể sản phẩm</h6>
                        <button type="button" class="btn btn-sm btn-primary" onclick="addVariant()">
                            <i class="fas fa-plus me-1"></i>Thêm biến thể
                        </button>
                    </div>
                    <div class="card-body">
                        <div id="variants-container">
                            <p class="text-muted">Chưa có biến thể nào. Nhấn "Thêm biến thể" để bắt đầu.</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Sidebar -->
            <div class="col-lg-4">
                <!-- Status Settings -->
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Cài đặt trạng thái</h6>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <div class="form-check">
                                <input type="hidden" name="is_active" value="0">
                                <input class="form-check-input" type="checkbox" name="is_active" value="1" 
                                       id="is_active" {{ old('is_active', 1) ? 'checked' : '' }}>
                                <label class="form-check-label" for="is_active">
                                    <strong>Kích hoạt sản phẩm</strong>
                                </label>
                                <small class="form-text text-muted d-block">Sản phẩm sẽ hiển thị trên website</small>
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <div class="form-check">
                                <input type="hidden" name="is_featured" value="0">
                                <input class="form-check-input" type="checkbox" name="is_featured" value="1" 
                                       id="is_featured" {{ old('is_featured') ? 'checked' : '' }}>
                                <label class="form-check-label" for="is_featured">
                                    <strong>Sản phẩm nổi bật</strong>
                                </label>
                                <small class="form-text text-muted d-block">Hiển thị trong danh sách sản phẩm nổi bật</small>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Product Images -->
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Hình ảnh sản phẩm</h6>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label for="images" class="form-label">Chọn hình ảnh</label>
                            <input type="file" class="form-control @error('images.*') is-invalid @enderror" 
                                   id="images" name="images[]" multiple accept="image/*" onchange="previewImages(this)">
                            <small class="form-text text-muted">
                                Chọn nhiều hình ảnh (JPEG, PNG, JPG, GIF). Kích thước tối đa: 2MB mỗi ảnh.
                            </small>
                            @error('images.*')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div id="image-preview" class="row g-2">
                            <!-- Preview images will be added here -->
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Thao tác</h6>
                    </div>
                    <div class="card-body">
                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-2"></i>Lưu sản phẩm
                            </button>
                            <button type="submit" name="action" value="save_and_continue" class="btn btn-outline-primary">
                                <i class="fas fa-save me-2"></i>Lưu và tiếp tục chỉnh sửa
                            </button>
                            <a href="{{ route('admin.products.index') }}" class="btn btn-secondary">
                                <i class="fas fa-times me-2"></i>Hủy
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

<!-- Variant Template -->
<template id="variant-template">
    <div class="variant-item border rounded p-3 mb-3" data-index="__INDEX__">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h6 class="mb-0">Biến thể #<span class="variant-number">__NUMBER__</span></h6>
            <button type="button" class="btn btn-sm btn-outline-danger" onclick="removeVariant(this)">
                <i class="fas fa-trash"></i>
            </button>
        </div>
        
        <div class="row">
            <div class="col-md-6 mb-3">
                <label class="form-label">Loại biến thể</label>
                <select class="form-select" name="variants[__INDEX__][variant_type]" required>
                    <option value="">Chọn loại</option>
                    @foreach($variantTypes as $key => $value)
                        <option value="{{ $key }}">{{ $value }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-6 mb-3">
                <label class="form-label">Tên biến thể</label>
                <input type="text" class="form-control" name="variants[__INDEX__][variant_name]" 
                       placeholder="Ví dụ: Chất liệu chuôi">
            </div>
        </div>
        
        <div class="row">
            <div class="col-md-6 mb-3">
                <label class="form-label">Giá trị <span class="text-danger">*</span></label>
                <input type="text" class="form-control" name="variants[__INDEX__][variant_value]" 
                       placeholder="Ví dụ: Gỗ Ebony" required>
            </div>
            <div class="col-md-6 mb-3">
                <label class="form-label">SKU</label>
                <input type="text" class="form-control" name="variants[__INDEX__][sku]" 
                       placeholder="Mã SKU của biến thể">
            </div>
        </div>
        
        <div class="row">
            <div class="col-md-6 mb-3">
                <label class="form-label">Điều chỉnh giá</label>
                <div class="input-group">
                    <input type="number" class="form-control" name="variants[__INDEX__][price_adjustment]" 
                           placeholder="0" step="1000">
                    <span class="input-group-text">VNĐ</span>
                </div>
            </div>
            <div class="col-md-6 mb-3">
                <label class="form-label">Số lượng tồn kho</label>
                <input type="number" class="form-control" name="variants[__INDEX__][stock_quantity]" 
                       value="0" min="0">
            </div>
        </div>
        
        <div class="mb-3">
            <label class="form-label">Mô tả</label>
            <textarea class="form-control" name="variants[__INDEX__][description]" rows="2" 
                      placeholder="Mô tả chi tiết về biến thể này"></textarea>
        </div>
        
        <div class="form-check">
            <input type="hidden" name="variants[__INDEX__][is_active]" value="0">
            <input class="form-check-input" type="checkbox" name="variants[__INDEX__][is_active]" 
                   value="1" id="variant_active___INDEX__" checked>
            <label class="form-check-label" for="variant_active___INDEX__">
                Kích hoạt biến thể này
            </label>
        </div>
    </div>
</template>

@endsection

@push('scripts')
<script>
let variantIndex = 0;

// Add variant function
function addVariant() {
    const template = document.getElementById('variant-template').content.cloneNode(true);
    const container = document.getElementById('variants-container');
    
    // Replace placeholder with actual index
    const html = template.querySelector('.variant-item').outerHTML
        .replace(/__INDEX__/g, variantIndex)
        .replace(/__NUMBER__/g, variantIndex + 1);
    
    // If first variant, replace the "no variants" message
    if (container.children.length === 1 && container.children[0].tagName === 'P') {
        container.innerHTML = html;
    } else {
        container.insertAdjacentHTML('beforeend', html);
    }
    
    variantIndex++;
}

// Remove variant function
function removeVariant(button) {
    const variantItem = button.closest('.variant-item');
    variantItem.remove();
    
    // Update numbers
    updateVariantNumbers();
    
    // If no variants left, show message
    const container = document.getElementById('variants-container');
    if (container.children.length === 0) {
        container.innerHTML = '<p class="text-muted">Chưa có biến thể nào. Nhấn "Thêm biến thể" để bắt đầu.</p>';
    }
}

// Update variant numbers
function updateVariantNumbers() {
    document.querySelectorAll('.variant-number').forEach((span, index) => {
        span.textContent = index + 1;
    });
}

// Preview images function
function previewImages(input) {
    const preview = document.getElementById('image-preview');
    preview.innerHTML = '';
    
    if (input.files) {
        Array.from(input.files).forEach((file, index) => {
            const reader = new FileReader();
            
            reader.onload = function(e) {
                const col = document.createElement('div');
                col.className = 'col-6';
                
                col.innerHTML = `
                    <div class="position-relative">
                        <img src="${e.target.result}" class="img-fluid rounded shadow-sm" 
                             style="width: 100%; height: 120px; object-fit: cover;">
                        <div class="position-absolute bottom-0 start-0 end-0 bg-dark bg-opacity-75 text-white p-1 rounded-bottom">
                            <small>${file.name}</small>
                        </div>
                        ${index === 0 ? '<span class="position-absolute top-0 start-0 badge bg-primary">Chính</span>' : ''}
                    </div>
                `;
                
                preview.appendChild(col);
            };
            
            reader.readAsDataURL(file);
        });
    }
}

// Auto-generate SKU based on name
document.getElementById('name').addEventListener('input', function() {
    const name = this.value;
    const skuField = document.getElementById('sku');
    
    if (!skuField.value && name) {
        // Simple SKU generation from name
        const sku = name
            .toLowerCase()
            .replace(/[^a-z0-9\s]/g, '')
            .replace(/\s+/g, '-')
            .substring(0, 20);
        
        skuField.value = sku.toUpperCase();
    }
});

// Validate compare price
document.getElementById('compare_price').addEventListener('input', function() {
    const basePrice = parseFloat(document.getElementById('base_price').value) || 0;
    const comparePrice = parseFloat(this.value) || 0;
    
    if (comparePrice > 0 && comparePrice <= basePrice) {
        this.setCustomValidity('Giá so sánh phải lớn hơn giá bán');
    } else {
        this.setCustomValidity('');
    }
});

// Validate cost price
document.getElementById('cost_price').addEventListener('input', function() {
    const basePrice = parseFloat(document.getElementById('base_price').value) || 0;
    const costPrice = parseFloat(this.value) || 0;
    
    if (costPrice > 0 && costPrice >= basePrice) {
        this.setCustomValidity('Giá vốn nên nhỏ hơn giá bán');
    } else {
        this.setCustomValidity('');
    }
});
</script>
@endpush 