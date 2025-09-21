<div class="contact-detail">
    <div class="row mb-3">
        <div class="col-md-8">
            <h5 class="mb-1">{{ $contact->subject }}</h5>
            <div class="d-flex align-items-center gap-3">
                <span class="badge bg-{{ $contact->status_badge_class }}">
                    {{ $contact->status_text }}
                </span>
                <span class="badge bg-{{ $contact->priority_badge_class }}">
                    {{ $contact->priority_text }}
                </span>
                <small class="text-muted">
                    <i class="fa fa-clock me-1"></i>{{ $contact->formatted_created_at }}
                </small>
            </div>
        </div>
        <div class="col-md-4 text-end">
            <strong class="text-primary">ID: #{{ $contact->id }}</strong>
        </div>
    </div>

    <div class="contact-content">
        <h6 class="mb-2">Nội dung tin nhắn:</h6>
        <div class="border rounded p-3 bg-light mb-4">
            {!! nl2br(e($contact->message)) !!}
        </div>

        @if($contact->reply_message)
        <div class="admin-reply">
            <h6 class="mb-2 text-success">
                <i class="fa fa-reply me-1"></i>Phản hồi từ Admin:
            </h6>
            <div class="border rounded p-3 bg-success bg-opacity-10 border-success">
                {!! nl2br(e($contact->reply_message)) !!}
                <hr class="my-2">
                <small class="text-muted">
                    <strong>Trả lời bởi:</strong> {{ $contact->repliedByAdmin->name ?? 'Admin' }} 
                    <strong>vào lúc:</strong> {{ $contact->formatted_replied_at }}
                </small>
            </div>
        </div>
        @else
        <div class="no-reply">
            <div class="alert alert-info">
                <i class="fa fa-info-circle me-2"></i>
                Chúng tôi sẽ phản hồi liên hệ của bạn trong thời gian sớm nhất. 
                Cảm ơn bạn đã kiên nhẫn chờ đợi!
            </div>
        </div>
        @endif
    </div>

    <div class="contact-info mt-4">
        <div class="row">
            <div class="col-md-6">
                <h6 class="mb-2">Thông tin liên hệ:</h6>
                <ul class="list-unstyled">
                    <li><strong>Tên:</strong> {{ $contact->name }}</li>
                    <li><strong>Email:</strong> {{ $contact->email }}</li>
                    @if($contact->phone)
                        <li><strong>Điện thoại:</strong> {{ $contact->phone }}</li>
                    @endif
                </ul>
            </div>
            <div class="col-md-6">
                <h6 class="mb-2">Thông tin xử lý:</h6>
                <ul class="list-unstyled">
                    <li><strong>Trạng thái:</strong> 
                        <span class="badge bg-{{ $contact->status_badge_class }}">
                            {{ $contact->status_text }}
                        </span>
                    </li>
                    <li><strong>Mức độ ưu tiên:</strong> 
                        <span class="badge bg-{{ $contact->priority_badge_class }}">
                            {{ $contact->priority_text }}
                        </span>
                    </li>
                    <li><strong>Ngày gửi:</strong> {{ $contact->formatted_created_at }}</li>
                    @if($contact->replied_at)
                        <li><strong>Ngày trả lời:</strong> {{ $contact->formatted_replied_at }}</li>
                    @endif
                </ul>
            </div>
        </div>
    </div>

    @if($contact->status === 'closed')
    <div class="alert alert-secondary mt-3">
        <i class="fa fa-lock me-2"></i>
        Liên hệ này đã được đóng. Nếu bạn cần hỗ trợ thêm, vui lòng tạo liên hệ mới.
    </div>
    @endif
</div>