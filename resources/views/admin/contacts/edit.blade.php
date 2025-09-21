@extends('layouts.admin.AdminLayout')

@section('title', 'Chỉnh sửa liên hệ #' . $contact->id)

@section('content')
<div class="container-fluid">
    <div class="page-header">
        <div class="row align-items-center">
            <div class="col">
                <h3 class="page-title">Chỉnh sửa liên hệ #{{ $contact->id }}</h3>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('admin.contacts.index') }}">Liên hệ</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.contacts.show', $contact) }}">Chi tiết #{{ $contact->id }}</a></li>
                        <li class="breadcrumb-item active">Chỉnh sửa</li>
                    </ol>
                </nav>
            </div>
            <div class="col-auto">
                <a href="{{ route('admin.contacts.show', $contact) }}" class="btn btn-secondary">
                    <i class="fa fa-arrow-left"></i> Quay lại
                </a>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-xl-8">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Cập nhật trạng thái và ghi chú</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.contacts.update', $contact) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="status" class="form-label">Trạng thái <span class="text-danger">*</span></label>
                                <select name="status" id="status" class="form-select @error('status') is-invalid @enderror" required>
                                    <option value="pending" {{ old('status', $contact->status) == 'pending' ? 'selected' : '' }}>
                                        Chờ xử lý
                                    </option>
                                    <option value="in_progress" {{ old('status', $contact->status) == 'in_progress' ? 'selected' : '' }}>
                                        Đang xử lý
                                    </option>
                                    <option value="replied" {{ old('status', $contact->status) == 'replied' ? 'selected' : '' }}>
                                        Đã trả lời
                                    </option>
                                    <option value="closed" {{ old('status', $contact->status) == 'closed' ? 'selected' : '' }}>
                                        Đã đóng
                                    </option>
                                </select>
                                @error('status')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="priority" class="form-label">Mức độ ưu tiên <span class="text-danger">*</span></label>
                                <select name="priority" id="priority" class="form-select @error('priority') is-invalid @enderror" required>
                                    <option value="low" {{ old('priority', $contact->priority) == 'low' ? 'selected' : '' }}>
                                        Thấp
                                    </option>
                                    <option value="medium" {{ old('priority', $contact->priority) == 'medium' ? 'selected' : '' }}>
                                        Trung bình
                                    </option>
                                    <option value="high" {{ old('priority', $contact->priority) == 'high' ? 'selected' : '' }}>
                                        Cao
                                    </option>
                                </select>
                                @error('priority')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="admin_notes" class="form-label">Ghi chú nội bộ</label>
                            <textarea name="admin_notes" id="admin_notes" class="form-control @error('admin_notes') is-invalid @enderror" 
                                      rows="4" placeholder="Ghi chú chỉ admin mới thấy...">{{ old('admin_notes', $contact->admin_notes) }}</textarea>
                            @error('admin_notes')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">Ghi chú này chỉ admin mới thấy, không hiển thị với khách hàng.</div>
                        </div>

                        <div class="d-flex justify-content-end gap-2">
                            <a href="{{ route('admin.contacts.show', $contact) }}" class="btn btn-secondary">Hủy</a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fa fa-save"></i> Lưu thay đổi
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-xl-4">
            <!-- Contact Summary -->
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Tóm tắt liên hệ</h4>
                </div>
                <div class="card-body">
                    <div class="row mb-2">
                        <div class="col-sm-4">
                            <h6 class="mb-0">Người gửi:</h6>
                        </div>
                        <div class="col-sm-8">
                            <strong>{{ $contact->name }}</strong>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-sm-4">
                            <h6 class="mb-0">Email:</h6>
                        </div>
                        <div class="col-sm-8">
                            {{ $contact->email }}
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-sm-4">
                            <h6 class="mb-0">Chủ đề:</h6>
                        </div>
                        <div class="col-sm-8">
                            {{ $contact->subject }}
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-sm-4">
                            <h6 class="mb-0">Ngày tạo:</h6>
                        </div>
                        <div class="col-sm-8">
                            {{ $contact->formatted_created_at }}
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-sm-4">
                            <h6 class="mb-0">Trạng thái hiện tại:</h6>
                        </div>
                        <div class="col-sm-8">
                            <span class="badge bg-{{ $contact->status_badge_class }}">
                                {{ $contact->status_text }}
                            </span>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-sm-4">
                            <h6 class="mb-0">Ưu tiên hiện tại:</h6>
                        </div>
                        <div class="col-sm-8">
                            <span class="badge bg-{{ $contact->priority_badge_class }}">
                                {{ $contact->priority_text }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Contact Content Preview -->
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Nội dung tin nhắn</h4>
                </div>
                <div class="card-body">
                    <div class="border rounded p-3 bg-light" style="max-height: 200px; overflow-y: auto;">
                        {!! nl2br(e($contact->message)) !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection