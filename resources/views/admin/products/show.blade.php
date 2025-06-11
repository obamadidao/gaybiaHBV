@extends('layouts.admin.AdminLayout')

@section('content')
<div class="container-fluid">

    <!-- Alert Messages -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="row">
        <!-- Product Info -->
        <div class="col-lg-8">
            <!-- Basic Info Card -->
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex justify-content-between align-items-center">
                    <h4 class="m-0 font-weight-bold text-primary">Thông tin cơ bản</h4>
                    <div>
                        @if($product->is_featured)
                            <span class="badge bg-warning">
                                <i class="fas fa-star"></i> Nổi bật
                            </span>
                        @endif
                        <span class="badge {{ $product->is_active ? 'bg-success' : 'bg-secondary' }}">
                            {{ $product->is_active ? 'Hoạt động' : 'Ẩn' }}
                        </span>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <h4 class="mb-3">{{ $product->name }}</h4>
                            
                            @if($product->short_description)
                            <div class="mb-3">
                                <h6 class="text-muted">Mô tả ngắn:</h6>
                                <p>{{ $product->short_description }}</p>
                            </div>
                            @endif

                            @if($product->description)
                            <div class="mb-3">
                                <h6 class="text-muted">Mô tả chi tiết:</h6>
                                <div class="border p-3 rounded">
                                    {!! nl2br(e($product->description)) !!}
                                </div>
                            </div>
                            @endif
                        </div>
                        <div class="col-md-6">
                            <table class="table table-borderless">
                                <tr>
                                    <th width="150">SKU:</th>
                                    <td><span class="badge bg-info">{{ $product->sku }}</span></td>
                                </tr>
                                <tr>
                                    <th>Danh mục:</th>
                                    <td><span class="badge bg-secondary">{{ $product->category->name }}</span></td>
                                </tr>
                                @if($product->brand)
                                <tr>
                                    <th>Thương hiệu:</th>
                                    <td>{{ $product->brand }}</td>
                                </tr>
                                @endif
                                @if($product->model)
                                <tr>
                                    <th>Mẫu:</th>
                                    <td>{{ $product->model }}</td>
                                </tr>
                                @endif
                                @if($product->material)
                                <tr>
                                    <th>Chất liệu:</th>
                                    <td>{{ $product->material }}</td>
                                </tr>
                                @endif
                                <tr>
                                    <th>Ngày tạo:</th>
                                    <td>{{ $product->created_at->format('d/m/Y H:i') }}</td>
                                </tr>
                                <tr>
                                    <th>Cập nhật:</th>
                                    <td>{{ $product->updated_at->format('d/m/Y H:i') }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Pricing Card -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Thông tin giá</h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4">
                            <h6 class="text-muted">Giá bán:</h6>
                            <h4 class="text-success">{{ $product->formatted_price }}</h4>
                        </div>
                        @if($product->compare_price)
                        <div class="col-md-4">
                            <h6 class="text-muted">Giá so sánh:</h6>
                            <h5 class="text-muted text-decoration-line-through">{{ $product->formatted_compare_price }}</h5>
                        </div>
                        @endif
                        @if($product->cost_price)
                        <div class="col-md-4">
                            <h6 class="text-muted">Giá vốn:</h6>
                            <h5 class="text-warning">{{ number_format($product->cost_price, 0, ',', '.') }} VNĐ</h5>
                        </div>
                        @endif
                    </div>
                    
                    @if($product->variants->count() > 0)
                    <div class="mt-3">
                        <small class="text-muted">
                            <i class="fas fa-info-circle"></i>
                            Giá có thể thay đổi tùy theo biến thể được chọn
                        </small>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Inventory Card -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Quản lý tồn kho</h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3">
                            <h6 class="text-muted">Số lượng hiện tại:</h6>
                            @if($product->track_quantity)
                                @if($product->stock_quantity <= 0)
                                    <h4 class="text-danger">{{ $product->stock_quantity }}</h4>
                                    <small class="text-danger">Hết hàng</small>
                                @elseif($product->isLowStock())
                                    <h4 class="text-warning">{{ $product->stock_quantity }}</h4>
                                    <small class="text-warning">Sắp hết hàng</small>
                                @else
                                    <h4 class="text-success">{{ $product->stock_quantity }}</h4>
                                    <small class="text-success">Còn hàng</small>
                                @endif
                            @else
                                <h4 class="text-info">∞</h4>
                                <small class="text-info">Không theo dõi</small>
                            @endif
                        </div>
                        @if($product->track_quantity)
                        <div class="col-md-3">
                            <h6 class="text-muted">Tồn kho tối thiểu:</h6>
                            <h5>{{ $product->min_stock }}</h5>
                        </div>
                        @endif
                        <div class="col-md-3">
                            <h6 class="text-muted">Theo dõi tồn kho:</h6>
                            <span class="badge {{ $product->track_quantity ? 'bg-success' : 'bg-secondary' }}">
                                {{ $product->track_quantity ? 'Có' : 'Không' }}
                            </span>
                        </div>
                        <div class="col-md-3">
                            <h6 class="text-muted">Sản phẩm số:</h6>
                            <span class="badge {{ $product->is_digital ? 'bg-info' : 'bg-secondary' }}">
                                {{ $product->is_digital ? 'Có' : 'Không' }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Physical Properties Card -->
            @if($product->weight || $product->length || $product->width || $product->height)
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Thông số vật lý</h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        @if($product->weight)
                        <div class="col-md-3">
                            <h6 class="text-muted">Trọng lượng:</h6>
                            <p>{{ $product->weight }} gram</p>
                        </div>
                        @endif
                        @if($product->length)
                        <div class="col-md-3">
                            <h6 class="text-muted">Chiều dài:</h6>
                            <p>{{ $product->length }} cm</p>
                        </div>
                        @endif
                        @if($product->width)
                        <div class="col-md-3">
                            <h6 class="text-muted">Chiều rộng:</h6>
                            <p>{{ $product->width }} cm</p>
                        </div>
                        @endif
                        @if($product->height)
                        <div class="col-md-3">
                            <h6 class="text-muted">Chiều cao:</h6>
                            <p>{{ $product->height }} cm</p>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
            @endif

            <!-- Product Variants -->
            @if($product->variants->count() > 0)
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">
                        Biến thể sản phẩm ({{ $product->variants->count() }})
                    </h6>
                </div>
                <div class="card-body">
                    @php
                        $variantsByType = $product->variants->groupBy('variant_type');
                    @endphp

                    @foreach($variantsByType as $type => $variants)
                    <div class="mb-4">
                        <h6 class="text-secondary mb-3">
                            <i class="fas fa-tag me-2"></i>{{ $variants->first()->variant_type_name }}
                        </h6>
                        <div class="table-responsive">
                            <table class="table table-sm table-hover">
                                <thead class="table-light">
                                    <tr>
                                        <th>Giá trị</th>
                                        <th>Mô tả</th>
                                        <th width="120">Điều chỉnh giá</th>
                                        <th width="100">Tồn kho</th>
                                        <th width="80">Trạng thái</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($variants as $variant)
                                    <tr>
                                        <td>
                                            <strong>{{ $variant->variant_value }}</strong>
                                            @if($variant->sku)
                                                <br><small class="text-muted">SKU: {{ $variant->sku }}</small>
                                            @endif
                                        </td>
                                        <td>{{ $variant->description ?: '-' }}</td>
                                        <td class="text-center">
                                            @if($variant->price_adjustment != 0)
                                                <span class="badge {{ $variant->price_adjustment > 0 ? 'bg-success' : 'bg-danger' }}">
                                                    {{ $variant->formatted_price_adjustment }}
                                                </span>
                                            @else
                                                <span class="text-muted">-</span>
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            @if($variant->stock_quantity <= 0)
                                                <span class="badge bg-danger">{{ $variant->stock_quantity }}</span>
                                            @elseif($variant->isLowStock())
                                                <span class="badge bg-warning">{{ $variant->stock_quantity }}</span>
                                            @else
                                                <span class="badge bg-success">{{ $variant->stock_quantity }}</span>
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            <span class="badge {{ $variant->is_active ? 'bg-success' : 'bg-secondary' }}">
                                                {{ $variant->is_active ? 'Hoạt động' : 'Ẩn' }}
                                            </span>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif
        </div>

        <!-- Right Sidebar -->
        <div class="col-lg-4">
            <!-- Product Images -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="m-0 font-weight-bold text-primary">Hình ảnh sản phẩm ({{ $product->images->count() }})</h6>
                                
                            </div>
                            <div>
                                <a href="{{ route('admin.products.edit', $product) }}" class="btn btn-sm btn-primary">
                                    <i class="fas fa-edit me-2"></i>Chỉnh sửa
                                </a>
                                <a href="{{ route('admin.products.index') }}" class="btn btn-sm btn-secondary">
                                    <i class="fas fa-arrow-left me-2"></i>Quay lại
                                </a>
                            </div>
                        </div>
                    </h6>
                </div>
                <div class="card-body">
                    @if($product->images->count() > 0)
                        <div class="row g-2">
                            @foreach($product->images as $image)
                            <div class="col-6">
                                <div class="position-relative">
                                    <img src="{{ $image->url }}" alt="{{ $image->alt }}" class="img-fluid rounded shadow-sm" style="width: 100%; height: 150px; object-fit: cover;">
                                    @if($image->is_primary)
                                        <span class="position-absolute top-0 start-0 badge bg-primary">Chính</span>
                                    @endif
                                    <div class="position-absolute bottom-0 start-0 end-0 bg-dark bg-opacity-75 text-white p-1 rounded-bottom">
                                        <small>{{ $image->formatted_file_size }}</small>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-4">
                            <i class="fas fa-images fa-3x text-muted mb-3"></i>
                            <p class="text-muted">Chưa có hình ảnh nào</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Reviews Summary -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Thống kê đánh giá</h6>
                </div>
                <div class="card-body">
                    <div class="text-center mb-3">
                        <h3 class="text-warning mb-1">{{ number_format($reviewStats['average_rating'], 1) }}</h3>
                        <div class="text-warning mb-2">
                            @for($i = 1; $i <= 5; $i++)
                                @if($i <= $reviewStats['average_rating'])
                                    <i class="fas fa-star"></i>
                                @else
                                    <i class="far fa-star"></i>
                                @endif
                            @endfor
                        </div>
                        <small class="text-muted">{{ $reviewStats['total'] }} đánh giá</small>
                    </div>

                    <div class="row text-center">
                        <div class="col-4">
                            <h6 class="text-success">{{ $reviewStats['approved'] }}</h6>
                            <small class="text-muted">Đã duyệt</small>
                        </div>
                        <div class="col-4">
                            <h6 class="text-warning">{{ $reviewStats['pending'] }}</h6>
                            <small class="text-muted">Chờ duyệt</small>
                        </div>
                        <div class="col-4">
                            <h6 class="text-info">{{ $reviewStats['total'] }}</h6>
                            <small class="text-muted">Tổng cộng</small>
                        </div>
                    </div>

                    @if($reviewStats['approved'] > 0)
                    <hr>
                    <div class="small">
                        @for($i = 5; $i >= 1; $i--)
                        <div class="d-flex align-items-center mb-1">
                            <span class="me-2">{{ $i }} sao</span>
                            <div class="progress flex-fill me-2" style="height: 8px;">
                                <div class="progress-bar bg-warning" style="width: {{ $reviewStats['rating_breakdown'][$i]['percentage'] }}%"></div>
                            </div>
                            <span class="text-muted small">{{ $reviewStats['rating_breakdown'][$i]['count'] }}</span>
                        </div>
                        @endfor
                    </div>
                    @endif

                    @if($product->reviews->count() > 0)
                    <div class="mt-3">
                        <a href="{{ route('admin.products.reviews', $product) }}" class="btn btn-outline-primary btn-sm w-100">
                            <i class="fas fa-comments me-2"></i>Quản lý đánh giá
                        </a>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Thao tác nhanh</h6>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <form action="{{ route('admin.products.toggle-status', $product) }}" method="POST" style="display: inline;">
                            @csrf
                            <button type="submit" class="btn {{ $product->is_active ? 'btn-warning' : 'btn-success' }} w-100">
                                <i class="fas {{ $product->is_active ? 'fa-eye-slash' : 'fa-eye' }} me-2"></i>
                                {{ $product->is_active ? 'Ẩn sản phẩm' : 'Kích hoạt sản phẩm' }}
                            </button>
                        </form>

                        <form action="{{ route('admin.products.toggle-featured', $product) }}" method="POST" style="display: inline;">
                            @csrf
                            <button type="submit" class="btn {{ $product->is_featured ? 'btn-outline-warning' : 'btn-warning' }} w-100">
                                <i class="fas fa-star me-2"></i>
                                {{ $product->is_featured ? 'Bỏ nổi bật' : 'Đánh dấu nổi bật' }}
                            </button>
                        </form>

                        <hr>

                        <a href="{{ route('admin.products.edit', $product) }}" class="btn btn-primary w-100">
                            <i class="fas fa-edit me-2"></i>Chỉnh sửa sản phẩm
                        </a>

                        <form action="{{ route('admin.products.destroy', $product) }}" method="POST" onsubmit="return confirm('Bạn có chắc chắn muốn xóa sản phẩm này?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger w-100">
                                <i class="fas fa-trash me-2"></i>Xóa sản phẩm
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 