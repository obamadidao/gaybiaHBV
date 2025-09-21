@extends('layouts.admin.AdminLayout')

@section('title', 'Chi tiết liên hệ #' . $contact->id)

@section('content')
<div class="container-fluid">
    <div class="page-header">
        <div class="row align-items-center">
            <div class="col">
                <h3 class="page-title">Chi tiết liên hệ #{{ $contact->id }}</h3>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('admin.contacts.index') }}">Liên hệ</a></li>
                        <li class="breadcrumb-item active">Chi tiết #{{ $contact->id }}</li>
                    </ol>
                </nav>
            </div>
            <div class="col-auto">
                <div class="btn-group">
                    <a href="{{ route('admin.contacts.edit', $contact) }}" class="btn btn-warning">
                        <i class="fa fa-edit"></i> Chỉnh sửa
                    </a>
                    <a href="{{ route('admin.contacts.index') }}" class="btn btn-secondary">
                        <i class="fa fa-arrow-left"></i> Quay lại
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-xl-8">
            <!-- Contact Details -->
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Thông tin liên hệ</h4>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-sm-3">
                            <h6 class="mb-0">Chủ đề:</h6>
                        </div>
                        <div class="col-sm-9">
                            <strong>{{ $contact->subject }}</strong>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-sm-3">
                            <h6 class="mb-0">Nội dung:</h6>
                        </div>
                        <div class="col-sm-9">
                            <div class="border rounded p-3 bg-light">
                                {!! nl2br(e($contact->message)) !!}
                            </div>
                        </div>
                    </div>

                    @if($contact->reply_message)
                    <hr>
                    <div class="row mb-3">
                        <div class="col-sm-3">
                            <h6 class="mb-0 text-success">Phản hồi:</h6>
                        </div>
                        <div class="col-sm-9">
                            <div class="border rounded p-3 bg-success bg-opacity-10 border-success">
                                {!! nl2br(e($contact->reply_message)) !!}
                                <hr class="my-2">
                                <small class="text-muted">
                                    <strong>Trả lời bởi:</strong> {{ $contact->repliedByAdmin->name ?? 'Admin' }} 
                                    <strong>vào lúc:</strong> {{ $contact->formatted_replied_at }}
                                </small>
                            </div>
                        </div>
                    </div>
                    @endif

                    @if($contact->admin_notes)
                    <div class="row mb-3">
                        <div class="col-sm-3">
                            <h6 class="mb-0 text-info">Ghi chú nội bộ:</h6>
                        </div>
                        <div class="col-sm-9">
                            <div class="border rounded p-3 bg-info bg-opacity-10 border-info">
                                {!! nl2br(e($contact->admin_notes)) !!}
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Reply Form -->
            @if($contact->status !== 'closed')
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">{{ $contact->reply_message ? 'Cập nhật phản hồi' : 'Trả lời liên hệ' }}</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.contacts.reply', $contact) }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="reply_message" class="form-label">Nội dung trả lời</label>
                            <textarea name="reply_message" id="reply_message" class="form-control @error('reply_message') is-invalid @enderror" 
                                      rows="5" placeholder="Nhập nội dung trả lời...">{{ old('reply_message', $contact->reply_message) }}</textarea>
                            @error('reply_message')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="d-flex justify-content-end">
                            <button type="submit" class="btn btn-success">
                                <i class="fa fa-reply"></i> {{ $contact->reply_message ? 'Cập nhật phản hồi' : 'Gửi trả lời' }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
            @endif
        </div>

        <div class="col-xl-4">
            <!-- Contact Info -->
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Thông tin người gửi</h4>
                </div>
                <div class="card-body">
                    <div class="row mb-2">
                        <div class="col-sm-5">
                            <h6 class="mb-0">Họ tên:</h6>
                        </div>
                        <div class="col-sm-7">
                            {{ $contact->name }}
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-sm-5">
                            <h6 class="mb-0">Email:</h6>
                        </div>
                        <div class="col-sm-7">
                            <a href="mailto:{{ $contact->email }}">{{ $contact->email }}</a>
                        </div>
                    </div>
                    @if($contact->phone)
                    <div class="row mb-2">
                        <div class="col-sm-5">
                            <h6 class="mb-0">Số điện thoại:</h6>
                        </div>
                        <div class="col-sm-7">
                            <a href="tel:{{ $contact->phone }}">{{ $contact->phone }}</a>
                        </div>
                    </div>
                    @endif
                    <div class="row mb-2">
                        <div class="col-sm-5">
                            <h6 class="mb-0">Loại tài khoản:</h6>
                        </div>
                        <div class="col-sm-7">
                            @if($contact->user)
                                <span class="badge bg-primary">Thành viên</span>
                                <br><small class="text-muted">{{ $contact->user->email }}</small>
                            @else
                                <span class="badge bg-secondary">Khách</span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Status & Priority -->
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Trạng thái & Ưu tiên</h4>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-sm-5">
                            <h6 class="mb-0">Trạng thái:</h6>
                        </div>
                        <div class="col-sm-7">
                            <span class="badge bg-{{ $contact->status_badge_class }}">
                                {{ $contact->status_text }}
                            </span>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-sm-5">
                            <h6 class="mb-0">Mức độ ưu tiên:</h6>
                        </div>
                        <div class="col-sm-7">
                            <span class="badge bg-{{ $contact->priority_badge_class }}">
                                {{ $contact->priority_text }}
                            </span>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-sm-5">
                            <h6 class="mb-0">Ngày tạo:</h6>
                        </div>
                        <div class="col-sm-7">
                            {{ $contact->formatted_created_at }}
                        </div>
                    </div>
                    @if($contact->replied_at)
                    <div class="row mb-2">
                        <div class="col-sm-5">
                            <h6 class="mb-0">Đã trả lời:</h6>
                        </div>
                        <div class="col-sm-7">
                            {{ $contact->formatted_replied_at }}
                        </div>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Technical Info -->
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Thông tin kỹ thuật</h4>
                </div>
                <div class="card-body">
                    @if($contact->ip_address)
                    <div class="row mb-2">
                        <div class="col-sm-4">
                            <h6 class="mb-0">IP:</h6>
                        </div>
                        <div class="col-sm-8">
                            <small>{{ $contact->ip_address }}</small>
                        </div>
                    </div>
                    @endif
                    @if($contact->user_agent)
                    <div class="row mb-2">
                        <div class="col-sm-4">
                            <h6 class="mb-0">Trình duyệt:</h6>
                        </div>
                        <div class="col-sm-8">
                            <small class="text-truncate d-block" title="{{ $contact->user_agent }}">
                                {{ Str::limit($contact->user_agent, 50) }}
                            </small>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection