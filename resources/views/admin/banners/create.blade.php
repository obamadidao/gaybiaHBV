@extends('layouts.admin.AdminLayout')

@section('content')
<div class="container-fluid">
    <form action="{{ route('admin.banners.store') }}" method="POST">
        @csrf
        <div class="row">
            <!-- Main Form -->
            <div class="col-lg-8">
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <div class="d-flex justify-content-between align-items-center">
                            <h1 class="h3 mb-0 text-gray-800">Thêm Banner Mới</h1>
                            <a href="{{ route('admin.banners.index') }}" class="btn btn-sm btn-secondary">
                                <i class="fas fa-arrow-left me-2"></i>Quay lại
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        <!-- Title -->
                        <div class="mb-3">
                            <label for="title" class="form-label">Tiêu đề Banner <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('title') is-invalid @enderror" 
                                   id="title" name="title" value="{{ old('title') }}" 
                                   placeholder="Nhập tiêu đề banner...">
                            @error('title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Description -->
                        <div class="mb-3">
                            <label for="description" class="form-label">Mô tả</label>
                            <textarea class="form-control @error('description') is-invalid @enderror" 
                                      id="description" name="description" rows="4" 
                                      placeholder="Mô tả chi tiết về banner...">{{ old('description') }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Image URL -->
                        <div class="mb-3">
                            <label for="image_url" class="form-label">URL Hình ảnh <span class="text-danger">*</span></label>
                            <input type="url" class="form-control @error('image_url') is-invalid @enderror" 
                                   id="image_url" name="image_url" value="{{ old('image_url') }}" 
                                   placeholder="https://example.com/banner-image.jpg">
                            <div class="form-text">Nhập đường dẫn URL của hình ảnh banner</div>
                            @error('image_url')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            
                            <!-- Image Preview -->
                            <div id="imagePreview" class="mt-3" style="display: none;">
                                <label class="form-label">Xem trước:</label>
                                <div class="border rounded p-2">
                                    <img id="previewImg" src="" alt="Preview" class="img-fluid" style="max-height: 200px;">
                                </div>
                            </div>
                        </div>

                        <!-- Link -->
                        <div class="mb-3">
                            <label for="link" class="form-label">Liên kết</label>
                            <input type="url" class="form-control @error('link') is-invalid @enderror" 
                                   id="link" name="link" value="{{ old('link') }}" 
                                   placeholder="https://example.com/target-page">
                            <div class="form-text">URL trang đích khi click vào banner (tùy chọn)</div>
                            @error('link')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="col-lg-4">
                <!-- Xuất bản -->
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Xuất bản</h6>
                    </div>
                    <div class="card-body">
                        <!-- Trạng thái -->
                        <div class="mb-3">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" id="is_active" 
                                       name="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }}>
                                <label class="form-check-label" for="is_active">
                                    Hoạt động
                                </label>
                            </div>
                            <div class="form-text">Banner sẽ hiển thị trên website khi được kích hoạt</div>
                        </div>

                        <!-- Submit Buttons -->
                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-2"></i>Tạo Banner
                            </button>
                            <a href="{{ route('admin.banners.index') }}" class="btn btn-outline-secondary">
                                <i class="fas fa-times me-2"></i>Hủy bỏ
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Cài đặt -->
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Cài đặt Banner</h6>
                    </div>
                    <div class="card-body">
                        <!-- Position -->
                        <div class="mb-3">
                            <label for="position" class="form-label">Vị trí hiển thị</label>
                            <input type="number" class="form-control @error('position') is-invalid @enderror" 
                                   id="position" name="position" value="{{ old('position', 0) }}" 
                                   min="0" step="1">
                            <div class="form-text">Số càng nhỏ hiển thị càng trước (0 = đầu tiên)</div>
                            @error('position')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Hướng dẫn -->
                <div class="card shadow mb-4 border-left-info">
                    <div class="card-body">
                        <h6 class="text-info"><i class="fas fa-info-circle me-2"></i>Hướng dẫn</h6>
                        <ul class="small mb-0">
                            <li>Tiêu đề nên ngắn gọn và thu hút</li>
                            <li>Hình ảnh nên có chất lượng tốt và kích thước phù hợp</li>
                            <li>Link có thể để trống nếu banner chỉ mang tính thông báo</li>
                            <li>Vị trí số 0 sẽ hiển thị đầu tiên</li>
                            <li>Banner có thể bật/tắt bất kỳ lúc nào</li>
                        </ul>
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
    // Image preview functionality
    $('#image_url').on('input', function() {
        const imageUrl = $(this).val();
        if (imageUrl && isValidUrl(imageUrl)) {
            // Test if image loads successfully
            const img = new Image();
            img.onload = function() {
                $('#previewImg').attr('src', imageUrl);
                $('#imagePreview').show();
            };
            img.onerror = function() {
                $('#imagePreview').hide();
            };
            img.src = imageUrl;
        } else {
            $('#imagePreview').hide();
        }
    });

    function isValidUrl(string) {
        try {
            new URL(string);
            return true;
        } catch (_) {
            return false;
        }
    }
});
</script>
@endpush 