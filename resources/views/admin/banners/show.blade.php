@extends('layouts.admin.AdminLayout')

@section('content')
<div class="container-fluid">
    <div class="row">
        <!-- Main Content -->
        <div class="col-lg-8">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <h1 class="h3 mb-0 text-gray-800">Chi tiết Banner</h1>
                        <div>
                            <a href="{{ route('admin.banners.edit', $banner) }}" class="btn btn-primary me-2">
                                <i class="fas fa-edit me-2"></i>Chỉnh sửa
                            </a>
                            <a href="{{ route('admin.banners.index') }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left me-2"></i>Quay lại
                            </a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <!-- Banner Info -->
                    <div class="row mb-4">
                        <div class="col-md-8">
                            <h2>{{ $banner->title }}</h2>
                            @if($banner->description)
                                <p class="text-muted">{{ $banner->description }}</p>
                            @endif
                        </div>
                        <div class="col-md-4 text-end">
                            <span class="badge {{ $banner->is_active ? 'bg-success' : 'bg-secondary' }} fs-6">
                                {{ $banner->status_text }}
                            </span>
                        </div>
                    </div>

                    <!-- Banner Image -->
                    @if($banner->image_url)
                        <div class="mb-4">
                            <h5>Hình ảnh Banner</h5>
                            <div class="border rounded p-3 text-center">
                                <img src="{{ $banner->image_url }}" alt="{{ $banner->title }}" 
                                     class="img-fluid" style="max-width: 100%; max-height: 400px;">
                            </div>
                        </div>
                    @endif

                    <!-- Banner Link -->
                    @if($banner->hasLink())
                        <div class="mb-4">
                            <h5>Liên kết</h5>
                            <p>
                                <a href="{{ $banner->link }}" target="_blank" class="text-primary">
                                    {{ $banner->link }}
                                    <i class="fas fa-external-link-alt ms-2"></i>
                                </a>
                            </p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="col-lg-4">
            <!-- Quick Actions -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Thao tác nhanh</h6>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <a href="{{ route('admin.banners.edit', $banner) }}" class="btn btn-primary">
                            <i class="fas fa-edit me-2"></i>Chỉnh sửa Banner
                        </a>
                        
                        <form action="{{ route('admin.banners.toggle-status', $banner) }}" method="POST">
                            @csrf
                            <button type="submit" class="btn {{ $banner->is_active ? 'btn-warning' : 'btn-success' }} w-100">
                                <i class="fas {{ $banner->is_active ? 'fa-eye-slash' : 'fa-eye' }} me-2"></i>
                                {{ $banner->is_active ? 'Tạm dừng' : 'Kích hoạt' }}
                            </button>
                        </form>

                        <form action="{{ route('admin.banners.destroy', $banner) }}" method="POST" 
                              onsubmit="return confirm('Bạn có chắc muốn xóa banner này?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger w-100">
                                <i class="fas fa-trash me-2"></i>Xóa Banner
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Banner Details -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Thông tin chi tiết</h6>
                </div>
                <div class="card-body">
                    <table class="table table-borderless table-sm">
                        <tr>
                            <td><strong>ID:</strong></td>
                            <td>{{ $banner->id }}</td>
                        </tr>
                        <tr>
                            <td><strong>Vị trí:</strong></td>
                            <td><span class="badge bg-dark">{{ $banner->position }}</span></td>
                        </tr>
                        <tr>
                            <td><strong>Trạng thái:</strong></td>
                            <td>
                                <span class="badge {{ $banner->is_active ? 'bg-success' : 'bg-secondary' }}">
                                    {{ $banner->status_text }}
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <td><strong>Ngày tạo:</strong></td>
                            <td>{{ $banner->created_at->format('d/m/Y H:i') }}</td>
                        </tr>
                        <tr>
                            <td><strong>Cập nhật lần cuối:</strong></td>
                            <td>{{ $banner->updated_at->format('d/m/Y H:i') }}</td>
                        </tr>
                        <tr>
                            <td><strong>Có liên kết:</strong></td>
                            <td>
                                @if($banner->hasLink())
                                    <i class="fas fa-check text-success"></i> Có
                                @else
                                    <i class="fas fa-times text-muted"></i> Không
                                @endif
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 