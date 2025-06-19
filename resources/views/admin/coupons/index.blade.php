@extends('layouts.admin.AdminLayout')

@section('content')
<div class="container-fluid">
<div class="d-flex justify-content-between align-items-center mb-4">
<h1 class="h3 mb-0 text-gray-800">Danh sách mã giảm giá</h1>
        <a href="#" class="btn btn-primary disabled"><i class="fas fa-plus"></i> Thêm mã mới</a>
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addCouponModal">
            <i class="fas fa-plus"></i> Thêm mã mới
        </button>
</div>
<div class="card shadow mb-4">
<div class="card-body">
@@ -66,16 +68,148 @@
</div>
</div>
</div>

<!-- Modal Thêm mã giảm giá -->
<div class="modal fade" id="addCouponModal" tabindex="-1" aria-labelledby="addCouponModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="addCouponModalLabel">Thêm mã giảm giá mới</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form id="addCouponForm">
        <div class="modal-body">
          <div class="mb-3">
            <label class="form-label">Mã giảm giá <span class="text-danger">*</span></label>
            <input type="text" class="form-control" name="code" required>
          </div>
          <div class="mb-3">
            <label class="form-label">Loại <span class="text-danger">*</span></label>
            <select class="form-select" name="type" required>
              <option value="percent">Phần trăm</option>
              <option value="fixed">Tiền mặt</option>
            </select>
          </div>
          <div class="mb-3">
            <label class="form-label">Giá trị <span class="text-danger">*</span></label>
            <input type="number" class="form-control" name="value" required min="1">
          </div>
          <div class="mb-3">
            <label class="form-label">Giá trị giảm tối đa</label>
            <input type="number" class="form-control" name="max_discount_value" min="0">
          </div>
          <div class="mb-3">
            <label class="form-label">Đơn tối thiểu</label>
            <input type="number" class="form-control" name="min_order_value" min="0">
          </div>
          <div class="mb-3">
            <label class="form-label">Số lần dùng tối đa</label>
            <input type="number" class="form-control" name="max_uses" min="1">
          </div>
          <div class="mb-3">
            <label class="form-label">Ngày bắt đầu</label>
            <input type="date" class="form-control" name="start_date">
          </div>
          <div class="mb-3">
            <label class="form-label">Ngày kết thúc</label>
            <input type="date" class="form-control" name="end_date">
          </div>
          <div class="mb-3">
            <label class="form-label">Ghi chú</label>
            <textarea class="form-control" name="description" rows="2"></textarea>
          </div>
          <div class="form-check mb-3">
            <input class="form-check-input" type="checkbox" name="status" value="1" id="addCouponStatus" checked>
            <label class="form-check-label" for="addCouponStatus">Kích hoạt</label>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
          <button type="submit" class="btn btn-primary">Thêm mới</button>
        </div>
      </form>
    </div>
  </div>
</div>
@endsection

@push('scripts')
<script>
$(document).ready(function() {
    $('#couponsTable').DataTable({
        language: {
            url: '//cdn.datatables.net/plug-ins/1.13.7/i18n/vi.json'
    // Xử lý giới hạn giá trị theo loại mã giảm giá
    $('select[name="type"]').on('change', function() {
        var type = $(this).val();
        var valueInput = $('input[name="value"]');
        
        if (type === 'percent') {
            valueInput.attr('max', 99);
            if (parseFloat(valueInput.val()) > 99) {
                valueInput.val(99);
            }
            valueInput.siblings('label').html('Giá trị (%) <span class="text-danger">*</span>');
        } else {
            valueInput.removeAttr('max');
            valueInput.siblings('label').html('Giá trị (VNĐ) <span class="text-danger">*</span>');
       }
   });
    
    // Kích hoạt sự kiện change khi trang tải
    $('select[name="type"]').trigger('change');
    
    // Xử lý submit form thêm mã giảm giá
    $('#addCouponForm').on('submit', function(e) {
        e.preventDefault();
        var form = $(this);
        var btn = form.find('button[type=submit]');
        btn.prop('disabled', true).html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Đang xử lý...');
        
        // Reset thông báo lỗi
        form.find('.is-invalid').removeClass('is-invalid');
        form.find('.invalid-feedback').remove();
        
        $.ajax({
            url: '{{ route('admin.coupons.store') }}',
            method: 'POST',
            data: form.serialize(),
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            success: function(res) {
                if(res.success) {
                    // Thông báo thành công
                    alert(res.message || 'Thêm mã giảm giá thành công!');
                    
                    // Reset form
                    form[0].reset();
                    
                    // Đóng modal
                    $('#addCouponModal').modal('hide');
                    
                    // Reload trang
                    location.reload();
                } else {
                    alert(res.message || 'Có lỗi xảy ra!');
                }
            },
            error: function(xhr) {
                if (xhr.status === 422) {
                    // Lỗi validation
                    var errors = xhr.responseJSON.errors;
                    $.each(errors, function(key, value) {
                        var input = form.find('[name="' + key + '"]');
                        input.addClass('is-invalid');
                        input.after('<div class="invalid-feedback">' + value[0] + '</div>');
                    });
                    alert('Vui lòng kiểm tra lại thông tin!');
                } else {
                    alert('Có lỗi xảy ra! Vui lòng thử lại sau.');
                }
            },
            complete: function() {
                btn.prop('disabled', false).html('Thêm mới');
            }
        });
    });
});
</script>
@endpush 