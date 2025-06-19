@extends('layouts.admin.AdminLayout')

@section('content')
<div class="container-fluid">
<div class="d-flex justify-content-between align-items-center mb-4">
<h1 class="h3 mb-0 text-gray-800">Danh sách mã giảm giá</h1>
<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addCouponModal">
<i class="fas fa-plus"></i> Thêm mã mới
</button>
</div>
<div class="card shadow mb-4">
<div class="card-body">
<div class="table-responsive">
<table class="table table-bordered align-middle" id="couponsTable">
<thead>
<tr>
<th>STT</th>
<th>Mã</th>
<th>Loại</th>
<th>Giá trị</th>
<th>Giảm tối đa</th>
<th>Đơn tối thiểu</th>
<th>Số lần dùng</th>
<th>Đã dùng</th>
<th>Thời gian</th>
<th>Trạng thái</th>
<th>Ghi chú</th>
                            <th>Thao tác</th>
</tr>
</thead>
<tbody>
@foreach($coupons as $coupon)
<tr>
<td>{{ $loop->iteration }}</td>
<td><span class="fw-bold">{{ $coupon->code }}</span></td>
<td>{{ $coupon->type_text }}</td>
<td>
@if($coupon->type === 'percent')
{{ $coupon->value }}%
@else
{{ number_format($coupon->value) }}đ
@endif
</td>
<td>{{ $coupon->max_discount_value ? number_format($coupon->max_discount_value) . 'đ' : '-' }}</td>
<td>{{ $coupon->min_order_value ? number_format($coupon->min_order_value) . 'đ' : '-' }}</td>
<td>{{ $coupon->max_uses ?? '-' }}</td>
<td>{{ $coupon->used }}</td>
<td>
@if($coupon->start_date)
<span>{{ $coupon->start_date->format('d/m/Y') }}</span>
@endif
@if($coupon->end_date)
@@ -54,161 +55,346 @@
</td>
<td>
@if($coupon->status)
<span class="badge bg-success">Kích hoạt</span>
@else
<span class="badge bg-secondary">Tắt</span>
@endif
</td>
<td>{{ $coupon->description }}</td>
                            <td>
                                <button type="button" class="btn btn-sm btn-primary" onclick="showEditModal({{ $coupon->id }})">
                                    <i class="fas fa-edit"></i> Sửa
                                </button>
                            </td>
</tr>
@endforeach
</tbody>
</table>
</div>
</div>
</div>
</div>

<!-- Modal Thêm mã giảm giá -->
<div class="modal fade" id="addCouponModal" tabindex="-1" aria-labelledby="addCouponModalLabel" aria-hidden="true">
  <div class="modal-dialog">
<div class="modal fade modal-xl" id="addCouponModal" tabindex="-1" aria-labelledby="addCouponModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl">
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
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Mã giảm giá <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" name="code" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Loại <span class="text-danger">*</span></label>
                    <select class="form-select" name="type" required>
                        <option value="percent">Phần trăm</option>
                        <option value="fixed">Tiền mặt</option>
                    </select>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Giá trị <span class="text-danger">*</span></label>
                    <input type="number" class="form-control" name="value" required min="1">
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Giá trị giảm tối đa</label>
                    <input type="number" class="form-control" name="max_discount_value" min="0">
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Đơn tối thiểu</label>
                    <input type="number" class="form-control" name="min_order_value" min="0">
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Số lần dùng tối đa</label>
                    <input type="number" class="form-control" name="max_uses" min="1">
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Ngày bắt đầu</label>
                    <input type="date" class="form-control" name="start_date">
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Ngày kết thúc</label>
                    <input type="date" class="form-control" name="end_date">
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Ghi chú</label>
                    <textarea class="form-control" name="description" rows="2"></textarea>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Trạng thái</label>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="status" value="1" checked>
                        <label class="form-check-label" for="status">Kích hoạt</label>
                    </div>
                </div>
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

<!-- Modal Sửa mã giảm giá -->
<div class="modal fade modal-xl" id="editCouponModal" tabindex="-1" aria-labelledby="editCouponModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="editCouponModalLabel">Sửa mã giảm giá</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form id="editCouponForm">
        <input type="hidden" name="id" id="editCouponId">
        <div class="modal-body">
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Mã giảm giá <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" name="code" id="editCouponCode" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Loại <span class="text-danger">*</span></label>
                    <select class="form-select" name="type" id="editCouponType" required>
                        <option value="percent">Phần trăm</option>
                        <option value="fixed">Tiền mặt</option>
                    </select>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Giá trị <span class="text-danger">*</span></label>
                    <input type="number" class="form-control" name="value" id="editCouponValue" required min="1">
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Giá trị giảm tối đa</label>
                    <input type="number" class="form-control" name="max_discount_value" id="editCouponMaxDiscountValue" min="0">
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Đơn tối thiểu</label>
                    <input type="number" class="form-control" name="min_order_value" id="editCouponMinOrderValue" min="0">
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Số lần dùng tối đa</label>
                    <input type="number" class="form-control" name="max_uses" id="editCouponMaxUses" min="1">
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Ngày bắt đầu</label>
                    <input type="date" class="form-control" name="start_date" id="editCouponStartDate">
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Ngày kết thúc</label>
                    <input type="date" class="form-control" name="end_date" id="editCouponEndDate">
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Ghi chú</label>
                    <textarea class="form-control" name="description" id="editCouponDescription" rows="2"></textarea>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Trạng thái</label>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="status" id="editCouponStatus" value="1" checked>
                        <label class="form-check-label" for="editCouponStatus">Kích hoạt</label>
                    </div>
                </div>
            </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
          <button type="submit" class="btn btn-primary">Lưu thay đổi</button>
        </div>
      </form>
    </div>
  </div>
</div>
@endsection

@push('scripts')
<script>
$(document).ready(function() {
   // Xử lý giới hạn giá trị theo loại mã giảm giá
    $('select[name="type"]').on('change', function() {
        var type = $(this).val();
        var valueInput = $('input[name="value"]');
        
        if (type === 'percent') {
            valueInput.attr('max', 99);
            if (parseFloat(valueInput.val()) > 99) {
                valueInput.val(99);
    function setupTypeValueRelation(typeSelector, valueInput) {
        $(typeSelector).on('change', function() {
            var type = $(this).val();
            
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
            valueInput.siblings('label').html('Giá trị (%) <span class="text-danger">*</span>');
        } else {
            valueInput.removeAttr('max');
            valueInput.siblings('label').html('Giá trị (VNĐ) <span class="text-danger">*</span>');
        }
    });
        });
    }
   
    // Kích hoạt sự kiện change khi trang tải
    // Thiết lập cho form thêm mới
    setupTypeValueRelation('select[name="type"]', $('input[name="value"]'));
   $('select[name="type"]').trigger('change');
   
    // Thiết lập cho form sửa
    setupTypeValueRelation('#editCouponType', $('#editCouponValue'));
    
    // Xử lý hiển thị modal sửa
    window.showEditModal = function(couponId) {
        // Reset form và thông báo lỗi
        $('#editCouponForm')[0].reset();
        $('#editCouponForm').find('.is-invalid').removeClass('is-invalid');
        $('#editCouponForm').find('.invalid-feedback').remove();
        
        // Lấy thông tin mã giảm giá
        $.ajax({
            url: '/admin/coupons/' + couponId,
            method: 'GET',
            success: function(res) {
                if (res.success) {
                    var coupon = res.coupon;
                    
                    // Điền thông tin vào form
                    $('#editCouponId').val(coupon.id);
                    $('#editCouponCode').val(coupon.code);
                    $('#editCouponType').val(coupon.type).trigger('change');
                    $('#editCouponValue').val(coupon.value);
                    $('#editCouponMaxDiscountValue').val(coupon.max_discount_value);
                    $('#editCouponMinOrderValue').val(coupon.min_order_value);
                    $('#editCouponMaxUses').val(coupon.max_uses);
                    
                    // Xử lý ngày tháng
                    if (coupon.start_date) {
                        $('#editCouponStartDate').val(coupon.start_date.split('T')[0]);
                    }
                    if (coupon.end_date) {
                        $('#editCouponEndDate').val(coupon.end_date.split('T')[0]);
                    }
                    
                    $('#editCouponDescription').val(coupon.description);
                    $('#editCouponStatus').prop('checked', coupon.status == 1);
                    
                    // Hiển thị modal
                    $('#editCouponModal').modal('show');
                } else {
                    alert('Không thể lấy thông tin mã giảm giá!');
                }
            },
            error: function() {
                alert('Có lỗi xảy ra khi lấy thông tin mã giảm giá!');
            }
        });
    };
    
    // Xử lý submit form sửa
    $('#editCouponForm').on('submit', function(e) {
        e.preventDefault();
        var form = $(this);
        var couponId = $('#editCouponId').val();
        var btn = form.find('button[type=submit]');
        
        // Disable nút submit và hiển thị loading
        btn.prop('disabled', true).html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Đang xử lý...');
        
        // Reset thông báo lỗi
        form.find('.is-invalid').removeClass('is-invalid');
        form.find('.invalid-feedback').remove();
        
        $.ajax({
            url: '/admin/coupons/' + couponId,
            method: 'PUT',
            data: form.serialize(),
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            success: function(res) {
                if(res.success) {
                    // Thông báo thành công
                    alert(res.message || 'Cập nhật mã giảm giá thành công!');
                    
                    // Đóng modal
                    $('#editCouponModal').modal('hide');
                    
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
                btn.prop('disabled', false).html('Lưu thay đổi');
            }
        });
    });
    
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