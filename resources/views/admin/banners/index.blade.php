@extends('layouts.admin.AdminLayout')

@section('content')
<div class="container-fluid">
    <!-- Header -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <div class="d-flex justify-content-between align-items-center">
                <h1 class="h3 mb-0 text-gray-800">Quản lý Banner</h1>
                <a href="{{ route('admin.banners.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus me-2"></i>Thêm banner mới
                </a>
            </div>
        </div>
        <div class="card-body">
            <form method="GET" action="{{ route('admin.banners.index') }}" class="row g-3">
                <div class="col-md-4">
                    <input type="text" class="form-control" name="search" 
                           value="{{ request('search') }}" placeholder="Tìm kiếm banner...">
                </div>
                <div class="col-md-2">
                    <select class="form-select" name="status">
                        <option value="">Tất cả trạng thái</option>
                        <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Hoạt động</option>
                        <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Tạm dừng</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-outline-primary">
                        <i class="fas fa-search"></i> Tìm kiếm
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Messages -->
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <!-- Table -->
    <div class="card shadow">
        <div class="card-header">
            <h6 class="m-0 font-weight-bold text-primary">Danh sách banner ({{ $banners->total() }} banner)</h6>
        </div>
        <div class="card-body">
            @if($banners->count() > 0)
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Banner</th>
                            <th>Hình ảnh</th>
                            <th>Link</th>
                            <th>Vị trí</th>
                            <th>Trạng thái</th>
                            <th>Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($banners as $banner)
                        <tr>
                            <td>
                                <h6>{{ $banner->title }}</h6>
                                @if($banner->description)
                                <small class="text-muted">{{ Str::limit($banner->description, 80) }}</small>
                                @endif
                            </td>
                            <td>
                                @if($banner->image_url)
                                <img src="{{ $banner->image_url }}" class="img-thumbnail" style="width: 80px; height: 50px; object-fit: cover;">
                                @else
                                <div class="bg-light" style="width: 80px; height: 50px; display: flex; align-items: center; justify-content: center;">
                                    <i class="fas fa-image text-muted"></i>
                                </div>
                                @endif
                            </td>
                            <td>
                                @if($banner->link)
                                <a href="{{ $banner->link }}" target="_blank" class="text-primary">
                                    {{ Str::limit($banner->link, 30) }}
                                </a>
                                @else
                                <span class="text-muted">Không có</span>
                                @endif
                            </td>
                            <td>{{ $banner->position }}</td>
                            <td>
                                <span class="badge {{ $banner->is_active ? 'bg-success' : 'bg-secondary' }}">
                                    {{ $banner->status_text }}
                                </span>
                            </td>
                            <td>
                                <div class="btn-group">
                                    <a href="{{ route('admin.banners.edit', $banner) }}" class="btn btn-sm btn-primary">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('admin.banners.toggle-status', $banner) }}" method="POST" style="display: inline;">
                                        @csrf
                                        <button type="submit" class="btn btn-sm {{ $banner->is_active ? 'btn-warning' : 'btn-success' }}">
                                            <i class="fas {{ $banner->is_active ? 'fa-eye-slash' : 'fa-eye' }}"></i>
                                        </button>
                                    </form>
                                    <form action="{{ route('admin.banners.destroy', $banner) }}" method="POST" style="display: inline;" 
                                          onsubmit="return confirm('Bạn có chắc muốn xóa banner này?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger">
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
            @else
            <div class="text-center py-5">
                <i class="fas fa-image fa-3x text-muted mb-3"></i>
                <h5>Chưa có banner nào</h5>
                <a href="{{ route('admin.banners.create') }}" class="btn btn-primary">Thêm banner đầu tiên</a>
            </div>
            @endif
        </div>
        
        @if($banners->hasPages())
        <div class="card-footer">
            {{ $banners->links() }}
        </div>
        @endif
    </div>
</div>
@endsection 