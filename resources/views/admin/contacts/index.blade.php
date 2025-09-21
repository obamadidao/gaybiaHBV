@extends('layouts.admin.AdminLayout')

@section('title', 'Quản lý liên hệ')

@section('content')
<div class="container-fluid">
    <div class="page-header">
        <div class="row align-items-center">
            <div class="col">
                <h3 class="page-title">Quản lý liên hệ</h3>
            </div>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="row mb-4">
        <div class="col-xl-3 col-sm-6 col-12">
            <div class="card">
                <div class="card-body">
                    <div class="dash-widget-header">
                        <span class="dash-widget-icon text-primary border-primary">
                            <i class="fe fe-mail"></i>
                        </span>
                        <div class="dash-count">
                            <h3>{{ $statistics['total'] }}</h3>
                        </div>
                    </div>
                    <div class="dash-widget-info">
                        <h6 class="text-muted">Tổng liên hệ</h6>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-sm-6 col-12">
            <div class="card">
                <div class="card-body">
                    <div class="dash-widget-header">
                        <span class="dash-widget-icon text-warning border-warning">
                            <i class="fe fe-clock"></i>
                        </span>
                        <div class="dash-count">
                            <h3>{{ $statistics['pending'] }}</h3>
                        </div>
                    </div>
                    <div class="dash-widget-info">
                        <h6 class="text-muted">Chờ xử lý</h6>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-sm-6 col-12">
            <div class="card">
                <div class="card-body">
                    <div class="dash-widget-header">
                        <span class="dash-widget-icon text-success border-success">
                            <i class="fe fe-check-circle"></i>
                        </span>
                        <div class="dash-count">
                            <h3>{{ $statistics['replied'] }}</h3>
                        </div>
                    </div>
                    <div class="dash-widget-info">
                        <h6 class="text-muted">Đã trả lời</h6>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-sm-6 col-12">
            <div class="card">
                <div class="card-body">
                    <div class="dash-widget-header">
                        <span class="dash-widget-icon text-danger border-danger">
                            <i class="fe fe-alert-triangle"></i>
                        </span>
                        <div class="dash-count">
                            <h3>{{ $statistics['high_priority'] }}</h3>
                        </div>
                    </div>
                    <div class="dash-widget-info">
                        <h6 class="text-muted">Ưu tiên cao</h6>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Danh sách liên hệ</h4>
                    <div class="card-tools">
                        <!-- Filter Form -->
                        <form method="GET" class="d-inline-flex gap-2">
                            <select name="status" class="form-select form-select-sm" onchange="this.form.submit()">
                                <option value="">Tất cả trạng thái</option>
                                <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Chờ xử lý</option>
                                <option value="in_progress" {{ request('status') == 'in_progress' ? 'selected' : '' }}>Đang xử lý</option>
                                <option value="replied" {{ request('status') == 'replied' ? 'selected' : '' }}>Đã trả lời</option>
                                <option value="closed" {{ request('status') == 'closed' ? 'selected' : '' }}>Đã đóng</option>
                            </select>
                            <select name="priority" class="form-select form-select-sm" onchange="this.form.submit()">
                                <option value="">Tất cả mức độ</option>
                                <option value="high" {{ request('priority') == 'high' ? 'selected' : '' }}>Cao</option>
                                <option value="medium" {{ request('priority') == 'medium' ? 'selected' : '' }}>Trung bình</option>
                                <option value="low" {{ request('priority') == 'low' ? 'selected' : '' }}>Thấp</option>
                            </select>
                            <input type="text" name="search" class="form-control form-control-sm" 
                                   placeholder="Tìm kiếm..." value="{{ request('search') }}">
                            <button type="submit" class="btn btn-sm btn-primary">
                                <i class="fa fa-search"></i>
                            </button>
                        </form>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Tên</th>
                                    <th>Email</th>
                                    <th>Chủ đề</th>
                                    <th>Mức độ</th>
                                    <th>Trạng thái</th>
                                    <th>Ngày tạo</th>
                                    <th>Thao tác</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($contacts as $contact)
                                <tr>
                                    <td>#{{ $contact->id }}</td>
                                    <td>
                                        <strong>{{ $contact->name }}</strong>
                                        @if($contact->user)
                                            <br><small class="text-muted">Thành viên</small>
                                        @else
                                            <br><small class="text-muted">Khách</small>
                                        @endif
                                    </td>
                                    <td>{{ $contact->email }}</td>
                                    <td>
                                        <div class="text-truncate" style="max-width: 200px;" title="{{ $contact->subject }}">
                                            {{ $contact->subject }}
                                        </div>
                                    </td>
                                    <td>
                                        <span class="badge bg-{{ $contact->priority_badge_class }}">
                                            {{ $contact->priority_text }}
                                        </span>
                                    </td>
                                    <td>
                                        <span class="badge bg-{{ $contact->status_badge_class }}">
                                            {{ $contact->status_text }}
                                        </span>
                                    </td>
                                    <td>{{ $contact->formatted_created_at }}</td>
                                    <td>
                                        <div class="btn-group">
                                            <a href="{{ route('admin.contacts.show', $contact) }}" 
                                               class="btn btn-sm btn-outline-primary" title="Xem chi tiết">
                                                <i class="fa fa-eye"></i>
                                            </a>
                                            <a href="{{ route('admin.contacts.edit', $contact) }}" 
                                               class="btn btn-sm btn-outline-warning" title="Chỉnh sửa">
                                                <i class="fa fa-edit"></i>
                                            </a>
                                            <button type="button" class="btn btn-sm btn-outline-danger" 
                                                    onclick="deleteContact({{ $contact->id }})" title="Xóa">
                                                <i class="fa fa-trash"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="8" class="text-center">
                                        <div class="py-4">
                                            <i class="fa fa-inbox fa-3x text-muted mb-3"></i>
                                            <p class="text-muted">Không có liên hệ nào</p>
                                        </div>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div class="row mt-3">
                        <div class="col-sm-5">
                            <div class="dataTables_info">
                                Hiển thị {{ $contacts->firstItem() ?? 0 }} đến {{ $contacts->lastItem() ?? 0 }} 
                                trong tổng số {{ $contacts->total() }} kết quả
                            </div>
                        </div>
                        <div class="col-sm-7">
                            {{ $contacts->appends(request()->query())->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Delete Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Xác nhận xóa</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                Bạn có chắc chắn muốn xóa liên hệ này không?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                <form id="deleteForm" method="POST" style="display: inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Xóa</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('script')
<script>
function deleteContact(contactId) {
    const deleteForm = document.getElementById('deleteForm');
    deleteForm.action = `/admin/contacts/${contactId}`;
    
    const modal = new bootstrap.Modal(document.getElementById('deleteModal'));
    modal.show();
}
</script>
@endpush