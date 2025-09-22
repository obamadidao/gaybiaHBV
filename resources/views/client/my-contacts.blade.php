@extends('layouts.client.ClientLayout')

@section('title', 'Lịch sử liên hệ')

@push('head')
<meta name="csrf-token" content="{{ csrf_token() }}">
@endpush

@section('content')
<!--Page Header-->
<div class="page-header text-center">
<div class="container">
<div class="row">
<div class="col-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-content-between align-items-center">
<div class="page-title">
<h1>Lịch sử liên hệ</h1>
</div>
<!--Breadcrumbs-->
<div class="breadcrumbs">
<a href="{{ route('client.index') }}" title="Trang chủ">Trang chủ</a>
<span class="title"><i class="icon anm anm-angle-right-l"></i>Tài khoản</span>
<span class="main-title fw-bold"><i class="icon anm anm-angle-right-l"></i>Lịch sử liên hệ</span>
</div>
<!--End Breadcrumbs-->
</div>
</div>
</div>
</div>
<!--End Page Header-->

<!--Main Content-->
<div class="container mb-5">
<div class="row justify-content-center">
<div class="col-12 col-lg-10">
<div class="card">
<div class="card-header d-flex justify-content-between align-items-center">
<h4 class="mb-0">Danh sách liên hệ của bạn</h4>
<a href="{{ route('client.contact.index') }}" class="btn btn-primary btn-sm">
<i class="icon anm anm-plus me-1"></i>Gửi liên hệ mới
</a>
</div>
<div class="card-body">
@if($contacts->count() > 0)
<div class="table-responsive">
<table class="table table-hover">
<thead>
<tr>
<th>ID</th>
<th>Chủ đề</th>
<th>Mức độ</th>
<th>Trạng thái</th>
<th>Ngày gửi</th>
<th>Phản hồi</th>
<th>Thao tác</th>
</tr>
</thead>
<tbody>
@foreach($contacts as $contact)
<tr>
<td>
<span class="fw-bold text-primary">#{{ $contact->id }}</span>
</td>
<td>
<div class="contact-subject">
<strong>{{ Str::limit($contact->subject, 50) }}</strong>
<br>
<small class="text-muted">
{{ Str::limit($contact->message, 100) }}
</small>
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
<td>
<div>
{{ $contact->formatted_created_at }}
</div>
</td>
<td>
@if($contact->reply_message)
<div class="text-success">
<i class="fa fa-check-circle me-1"></i>
<small>{{ $contact->formatted_replied_at }}</small>
</div>
@else
<div class="text-muted">
<i class="fa fa-clock me-1"></i>
<small>Chưa có phản hồi</small>
</div>
@endif
</td>
<td>
<button type="button" class="btn btn-sm btn-outline-primary" 
onclick="viewContactDetail({{ $contact->id }})">
<i class="fa fa-eye me-1"></i>Xem
</button>
</td>
</tr>
@endforeach
</tbody>
</table>
</div>

<!-- Pagination -->
<div class="row mt-4">
<div class="col-sm-5">
<div class="dataTables_info">
Hiển thị {{ $contacts->firstItem() }} đến {{ $contacts->lastItem() }} 
trong tổng số {{ $contacts->total() }} liên hệ
</div>
</div>
<div class="col-sm-7">
{{ $contacts->links() }}
</div>
</div>
@else
<div class="text-center py-5">
<i class="icon anm anm-envelope-o" style="font-size: 64px; color: #ddd;"></i>
<h4 class="mt-3">Chưa có liên hệ nào</h4>
<p class="text-muted">Bạn chưa gửi liên hệ nào. Hãy gửi liên hệ đầu tiên của bạn!</p>
<a href="{{ route('client.contact.index') }}" class="btn btn-primary">
<i class="icon anm anm-plus me-1"></i>Gửi liên hệ ngay
</a>
</div>
@endif
</div>
</div>
</div>
</div>
</div>
<!--End Main Content-->

<!-- Contact Detail Modal -->
<div class="modal fade" id="contactDetailModal" tabindex="-1">
<div class="modal-dialog modal-lg">
<div class="modal-content">
<div class="modal-header">
<h5 class="modal-title">Chi tiết liên hệ</h5>
<button type="button" class="btn-close" data-bs-dismiss="modal"></button>
</div>
<div class="modal-body" id="contactDetailContent">
<div class="text-center py-4">
<div class="spinner-border text-primary" role="status">
<span class="visually-hidden">Đang tải...</span>
</div>
<div class="mt-2">Đang tải thông tin...</div>
</div>
</div>
<div class="modal-footer">
<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
</div>
</div>
</div>
</div>
@endsection

@push('script')
<script>
function viewContactDetail(contactId) {
   const modal = new bootstrap.Modal(document.getElementById('contactDetailModal'));
   const modalContent = document.getElementById('contactDetailContent');
   
   // Reset modal content
   modalContent.innerHTML = `
       <div class="text-center py-4">
           <div class="spinner-border text-primary" role="status">
               <span class="visually-hidden">Đang tải...</span>
           </div>
           <div class="mt-2">Đang tải thông tin...</div>
       </div>
   `;
   
   // Show modal
   modal.show();
   
   // Load contact detail
    fetch(`/contact/${contactId}`)
        .then(response => {
            if (!response.ok) {
                throw new Error('Failed to load contact detail');
    fetch(`/contact/${contactId}`, {
        method: 'GET',
        headers: {
            'X-Requested-With': 'XMLHttpRequest',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || ''
        }
    })
    .then(async response => {
        if (!response.ok) {
            // Try to get error message from JSON response
            try {
                const errorData = await response.json();
                throw new Error(errorData.message || `HTTP ${response.status}: ${response.statusText}`);
            } catch (jsonError) {
                throw new Error(`HTTP ${response.status}: ${response.statusText}`);
           }
            return response.text();
        })
        .then(html => {
            modalContent.innerHTML = html;
        })
        .catch(error => {
            console.error('Error:', error);
            modalContent.innerHTML = `
                <div class="alert alert-danger text-center">
                    <i class="fa fa-exclamation-triangle me-2"></i>
                    Không thể tải thông tin liên hệ. Vui lòng thử lại sau.
                </div>
            `;
        });
        }
        
        const contentType = response.headers.get('content-type');
        if (contentType && contentType.includes('application/json')) {
            const jsonData = await response.json();
            if (!jsonData.success) {
                throw new Error(jsonData.message || 'Có lỗi xảy ra');
            }
            return jsonData.html || jsonData.data;
        }
        
        return response.text();
    })
    .then(html => {
        modalContent.innerHTML = html;
    })
    .catch(error => {
        console.error('Error loading contact detail:', error);
        modalContent.innerHTML = `
            <div class="alert alert-danger text-center">
                <i class="fa fa-exclamation-triangle me-2"></i>
                ${error.message || 'Không thể tải thông tin liên hệ. Vui lòng thử lại sau.'}
            </div>
        `;
    });
}
</script>
@endpush