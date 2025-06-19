@extends('layouts.admin.AdminLayout')

@section('content')
<div class="container-fluid">
    <form action="{{ route('admin.banners.update', $banner) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="row">
            <!-- Main Form -->
            <div class="col-lg-8">
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <div class="d-flex justify-content-between align-items-center">
                            <h1 class="h3 mb-0 text-gray-800">Chỉnh sửa Banner</h1>
                            <a href="{{ route('admin.banners.index') }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left me-2"></i>Quay lại
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        <!-- Title -->
                        <div class="mb-3">
                            <label for="title" class="form-label">Tiêu đề Banner <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('title') is-invalid @enderror" 
                                   id="title" name="title" value="{{ old('title', $banner->title) }}" 
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
                                      placeholder="Mô tả chi tiết về banner...">{{ old('description', $banner->description) }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Current Image -->
                        @if($banner->image_url)
                            <div class="mb-3">
                                <label class="form-label">Hình ảnh hiện tại</label>
                                <div class="border rounded p-3">
                                    <img src="{{ $banner->image_url }}" alt="{{ $banner->title }}" 
                                         class="img-fluid" style="max-height: 200px;">
                                </div>
                            </div>
                        @endif

                        <!-- Image URL -->
                        <div class="mb-3">
                            <label for="image_url" class="form-label">URL Hình ảnh <span class="text-danger">*</span></label>
                            <input type="url" class="form-control @error('image_url') is-invalid @enderror" 
                                   id="image_url" name="image_url" value="{{ old('image_url', $banner->image_url) }}" 
                                   placeholder="https://example.com/banner-image.jpg">
                            <div class="form-text">Nhập đường dẫn URL của hình ảnh banner</div>
                            @error('image_url')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Link -->
                        <div class="mb-3">
                            <label for="link" class="form-label">Liên kết</label>
                            <input type="url" class="form-control @error('link') is-invalid @enderror" 
                                   id="link" name="link" value="{{ old('link', $banner->link) }}" 
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
                                       name="is_active" value="1" {{ old('is_active', $banner->is_active) ? 'checked' : '' }}>
                                <label class="form-check-label" for="is_active">
                                    Hoạt động
                                </label>
                            </div>
                            <div class="form-text">Banner sẽ hiển thị trên website khi được kích hoạt</div>
                        </div>

                        <!-- Position -->
                        <div class="mb-3">
                            <label for="position" class="form-label">Vị trí hiển thị</label>
                            <input type="number" class="form-control @error('position') is-invalid @enderror" 
                                   id="position" name="position" value="{{ old('position', $banner->position) }}" 
                                   min="0" step="1">
                            <div class="form-text">Số càng nhỏ hiển thị càng trước</div>
                            @error('position')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Submit Buttons -->
                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-2"></i>Cập nhật Banner
                            </button>
                            <a href="{{ route('admin.banners.index') }}" class="btn btn-outline-secondary">
                                <i class="fas fa-times me-2"></i>Hủy bỏ
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Thông tin banner -->
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Thông tin Banner</h6>
                    </div>
                    <div class="card-body">
                        <p><strong>Trạng thái:</strong> 
                            <span class="badge {{ $banner->is_active ? 'bg-success' : 'bg-secondary' }}">
                                {{ $banner->status_text }}
                            </span>
                        </p>
                        <p><strong>Vị trí:</strong> {{ $banner->position }}</p>
                        <p><strong>Ngày tạo:</strong> {{ $banner->created_at->format('d/m/Y H:i') }}</p>
                        <p><strong>Cập nhật:</strong> {{ $banner->updated_at->format('d/m/Y H:i') }}</p>
                        @if($banner->hasLink())
                        <p><strong>Link:</strong> 
                            <a href="{{ $banner->link }}" target="_blank" class="text-primary">
                                {{ Str::limit($banner->link, 30) }}
                            </a>
                        </p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection 