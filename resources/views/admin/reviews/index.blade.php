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

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="fas fa-exclamation-triangle me-2"></i>{{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <!-- Filter Card -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h1 class="h3 mb-0 text-gray-800">Quản lý tất cả đánh giá</h1>
                </div>
                <a href="{{ route('admin.product-reviews.statistics') }}" class="btn btn-info">
                    <i class="fas fa-chart-bar me-2"></i>Thống kê
                </a>
            </div>
        </div>
        <div class="card-body">
            <form method="GET" action="{{ route('admin.product-reviews.index') }}">
                <div class="row">
                    <div class="col-md-2 mb-3">
                        <label for="status" class="form-label">Trạng thái</label>
                        <select class="form-select" id="status" name="status">
                            <option value="">Tất cả</option>
                            <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Chờ duyệt</option>
                            <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>Đã duyệt</option>
                            <option value="hidden" {{ request('status') == 'hidden' ? 'selected' : '' }}>Đã ẩn</option>
                        </select>
                    </div>
                    <div class="col-md-2 mb-3">
                        <label for="rating" class="form-label">Đánh giá</label>
                        <select class="form-select" id="rating" name="rating">
                            <option value="">Tất cả</option>
                            <option value="5" {{ request('rating') == '5' ? 'selected' : '' }}>5 sao</option>
                            <option value="4" {{ request('rating') == '4' ? 'selected' : '' }}>4 sao</option>
                            <option value="3" {{ request('rating') == '3' ? 'selected' : '' }}>3 sao</option>
                            <option value="2" {{ request('rating') == '2' ? 'selected' : '' }}>2 sao</option>
                            <option value="1" {{ request('rating') == '1' ? 'selected' : '' }}>1 sao</option>
                        </select>
                    </div>
                    <div class="col-md-3 mb-3">
                        <label for="product_id" class="form-label">Sản phẩm</label>
                        <select class="form-select" id="product_id" name="product_id">
                            <option value="">Tất cả sản phẩm</option>
                            @foreach($products as $product)
                                <option value="{{ $product->id }}" {{ request('product_id') == $product->id ? 'selected' : '' }}>
                                    {{ $product->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3 mb-3">
                        <label for="search" class="form-label">Tìm kiếm</label>
                        <input type="text" class="form-control" id="search" name="search" 
                               value="{{ request('search') }}" placeholder="Tìm theo tiêu đề, nội dung...">
                    </div>
                    <div class="col-md-2 mb-3 d-flex align-items-end">
                        <button type="submit" class="btn btn-primary me-2">
                            <i class="fas fa-search"></i> Lọc
                        </button>
                        <a href="{{ route('admin.product-reviews.index') }}" class="btn btn-outline-secondary">
                            <i class="fas fa-undo"></i>
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Reviews Card -->
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">
                Danh sách đánh giá ({{ $reviews->total() }})
            </h6>
            
            @if($reviews->count() > 0)
            <div class="dropdown ms-auto">
                <button class="btn btn-outline-primary btn-sm dropdown-toggle " type="button" 
                        id="bulkActionDropdown" data-bs-toggle="dropdown" aria-expanded="false" disabled>
                    <i class="fas fa-cogs me-1"></i>Thao tác hàng loạt
                </button>
                <ul class="dropdown-menu" aria-labelledby="bulkActionDropdown">
                    <li><a class="dropdown-item" href="#" onclick="bulkAction('approve')">
                        <i class="fas fa-check text-success me-2"></i>Duyệt đánh giá
                    </a></li>
                    <li><a class="dropdown-item" href="#" onclick="bulkAction('reject')">
                        <i class="fas fa-times text-danger me-2"></i>Từ chối
                    </a></li>
                    <li><a class="dropdown-item" href="#" onclick="bulkAction('hide')">
                        <i class="fas fa-eye-slash text-warning me-2"></i>Ẩn đánh giá
                    </a></li>
                    <li><a class="dropdown-item" href="#" onclick="bulkAction('unhide')">
                        <i class="fas fa-eye text-info me-2"></i>Hiện đánh giá
                    </a></li>
                </ul>
            </div>
            @endif
        </div>
        <div class="card-body">
            @if($reviews->count() > 0)
                <form id="bulk-form" method="POST">
                    @csrf
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th width="30">
                                        <input type="checkbox" id="select-all" class="form-check-input">
                                    </th>
                                    <th width="80">Đánh giá</th>
                                    <th>Nội dung</th>
                                    <th width="200">Sản phẩm</th>
                                    <th width="150">Người dùng</th>
                                    <th width="120">Ngày tạo</th>
                                    <th width="100">Trạng thái</th>
                                    <th width="150">Thao tác</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($reviews as $review)
                                <tr>
                                    <td>
                                        <input type="checkbox" name="selected_reviews[]" value="{{ $review->id }}" 
                                               class="form-check-input review-checkbox">
                                    </td>
                                    <td class="text-center">
                                        <div class="text-warning mb-1">
                                            @for($i = 1; $i <= 5; $i++)
                                                @if($i <= $review->rating)
                                                    <i class="fas fa-star"></i>
                                                @else
                                                    <i class="far fa-star"></i>
                                                @endif
                                            @endfor
                                        </div>
                                        <small class="text-muted">{{ $review->rating }}/5</small>
                                    </td>
                                    <td>
                                        @if($review->title)
                                            <strong>{{ $review->title }}</strong><br>
                                        @endif
                                        <p class="mb-2">{{ Str::limit($review->content, 80) }}</p>
                                        
                                        @if($review->hasPros())
                                            <div class="mb-1">
                                                <small class="text-success">
                                                    <i class="fas fa-plus-circle me-1"></i>
                                                    {{ Str::limit(implode(', ', $review->safe_pros), 40) }}
                                                </small>
                                            </div>
                                        @endif
                                        
                                        @if($review->hasCons())
                                            <div class="mb-1">
                                                <small class="text-danger">
                                                    <i class="fas fa-minus-circle me-1"></i>
                                                    {{ Str::limit(implode(', ', $review->safe_cons), 40) }}
                                                </small>
                                            </div>
                                        @endif
                                        
                                        @if($review->admin_notes)
                                            <div class="mt-2 p-2 bg-light rounded">
                                                <small class="text-muted">
                                                    <i class="fas fa-sticky-note me-1"></i>
                                                    Ghi chú: {{ Str::limit($review->admin_notes, 30) }}
                                                </small>
                                            </div>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            @if($review->product->images->count() > 0)
                                                <img src="{{ $review->product->images->first()->url }}" 
                                                     alt="{{ $review->product->name }}" 
                                                     class="rounded me-2" style="width: 40px; height: 40px; object-fit: cover;">
                                            @else
                                                <div class="bg-light rounded me-2 d-flex align-items-center justify-content-center" 
                                                     style="width: 40px; height: 40px;">
                                                    <i class="fas fa-image text-muted"></i>
                                                </div>
                                            @endif
                                            <div>
                                                <a href="{{ route('admin.products.show', $review->product) }}" 
                                                   class="text-decoration-none">
                                                    <strong>{{ Str::limit($review->product->name, 30) }}</strong>
                                                </a>
                                                <br>
                                                <small class="text-muted">SKU: {{ $review->product->sku }}</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="me-2">
                                                <div class="bg-primary rounded-circle d-flex align-items-center justify-content-center" 
                                                     style="width: 32px; height: 32px;">
                                                    <small class="text-white fw-bold">
                                                        {{ substr($review->user_display_name, 0, 1) }}
                                                    </small>
                                                </div>
                                            </div>
                                            <div>
                                                <div class="fw-bold">{{ $review->user_display_name }}</div>
                                                @if($review->is_verified_purchase)
                                                    <small class="text-success">
                                                        <i class="fas fa-check-circle"></i> Đã mua
                                                    </small>
                                                @endif
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <small>{{ $review->created_at->format('d/m/Y H:i') }}</small>
                                    </td>
                                    <td>
                                        @if($review->is_approved && !$review->is_hidden)
                                            <span class="badge bg-success">Đã duyệt</span>
                                        @elseif($review->is_hidden)
                                            <span class="badge bg-warning">Đã ẩn</span>
                                        @else
                                            <span class="badge bg-secondary">Chờ duyệt</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            @if(!$review->is_approved)
                                                <form action="{{ route('admin.product-reviews.approve', $review) }}" method="POST" style="display: inline;">
                                                    @csrf
                                                    <button type="submit" class="btn btn-sm btn-success" title="Duyệt">
                                                        <i class="fas fa-check"></i>
                                                    </button>
                                                </form>
                                                <form action="{{ route('admin.product-reviews.reject', $review) }}" method="POST" style="display: inline;">
                                                    @csrf
                                                    <button type="submit" class="btn btn-sm btn-danger" title="Từ chối">
                                                        <i class="fas fa-times"></i>
                                                    </button>
                                                </form>
                                            @endif
                                            
                                            @if($review->is_approved)
                                                @if($review->is_hidden)
                                                    <form action="{{ route('admin.product-reviews.unhide', $review) }}" method="POST" style="display: inline;">
                                                        @csrf
                                                        <button type="submit" class="btn btn-sm btn-info" title="Hiện">
                                                            <i class="fas fa-eye"></i>
                                                        </button>
                                                    </form>
                                                @else
                                                    <form action="{{ route('admin.product-reviews.hide', $review) }}" method="POST" style="display: inline;">
                                                        @csrf
                                                        <button type="submit" class="btn btn-sm btn-warning" title="Ẩn">
                                                            <i class="fas fa-eye-slash"></i>
                                                        </button>
                                                    </form>
                                                @endif
                                            @endif
                                            
                                            <button type="button" class="btn btn-sm btn-outline-primary" 
                                                    onclick="editNotes({{ $review->id }}, '{{ addslashes($review->admin_notes) }}')" title="Ghi chú">
                                                <i class="fas fa-sticky-note"></i>
                                            </button>
                                            
                                            <form action="{{ route('admin.product-reviews.destroy', $review) }}" method="POST" 
                                                  style="display: inline;" onsubmit="return confirm('Bạn có chắc chắn muốn xóa đánh giá này?')">
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
                </form>
                
                <!-- Pagination -->
                <div class="d-flex justify-content-between align-items-center mt-3">
                    <div>
                        <small class="text-muted">
                            Hiển thị {{ $reviews->firstItem() }} đến {{ $reviews->lastItem() }} 
                            trong tổng số {{ $reviews->total() }} đánh giá
                        </small>
                    </div>
                    <div>
                        {{ $reviews->withQueryString()->links() }}
                    </div>
                </div>
            @else
                <div class="text-center py-4">
                    <i class="fas fa-comments fa-3x text-muted mb-3"></i>
                    <h5 class="text-muted">Không có đánh giá nào</h5>
                    <p class="text-muted">Chưa có đánh giá nào được tìm thấy với bộ lọc hiện tại.</p>
                </div>
            @endif
        </div>
    </div>
</div>

<!-- Edit Notes Modal -->
<div class="modal fade" id="editNotesModal" tabindex="-1" aria-labelledby="editNotesModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editNotesModalLabel">Chỉnh sửa ghi chú admin</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="edit-notes-form" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="admin_notes" class="form-label">Ghi chú</label>
                        <textarea class="form-control" id="admin_notes" name="admin_notes" rows="4" 
                                  placeholder="Nhập ghi chú cho đánh giá này..."></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                    <button type="submit" class="btn btn-primary">Lưu ghi chú</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
// Bulk action functionality
document.getElementById('select-all').addEventListener('change', function() {
    const checkboxes = document.querySelectorAll('.review-checkbox');
    checkboxes.forEach(checkbox => {
        checkbox.checked = this.checked;
    });
    toggleBulkActionButton();
});

document.querySelectorAll('.review-checkbox').forEach(checkbox => {
    checkbox.addEventListener('change', toggleBulkActionButton);
});

function toggleBulkActionButton() {
    const checkedBoxes = document.querySelectorAll('.review-checkbox:checked');
    const bulkButton = document.getElementById('bulkActionDropdown');
    bulkButton.disabled = checkedBoxes.length === 0;
}

function bulkAction(action) {
    const checkedBoxes = document.querySelectorAll('.review-checkbox:checked');
    if (checkedBoxes.length === 0) {
        alert('Vui lòng chọn ít nhất một đánh giá');
        return;
    }
    
    let actionText = '';
    switch(action) {
        case 'approve': actionText = 'duyệt'; break;
        case 'reject': actionText = 'từ chối'; break;
        case 'hide': actionText = 'ẩn'; break;
        case 'unhide': actionText = 'hiện'; break;
        case 'delete': actionText = 'xóa'; break;
    }
    
    if (confirm(`Bạn có chắc chắn muốn ${actionText} ${checkedBoxes.length} đánh giá đã chọn?`)) {
        const form = document.getElementById('bulk-form');
        form.action = `{{ route('admin.product-reviews.bulk-action') }}`;
        
        // Add action input
        const actionInput = document.createElement('input');
        actionInput.type = 'hidden';
        actionInput.name = 'action';
        actionInput.value = action;
        form.appendChild(actionInput);
        
        form.submit();
    }
}

// Edit notes functionality
function editNotes(reviewId, currentNotes) {
    const modal = new bootstrap.Modal(document.getElementById('editNotesModal'));
    const form = document.getElementById('edit-notes-form');
    const notesTextarea = document.getElementById('admin_notes');
    
    form.action = `{{ url('admin/product-reviews') }}/${reviewId}/update-notes`;
    notesTextarea.value = currentNotes;
    
    modal.show();
}
</script>
@endpush 