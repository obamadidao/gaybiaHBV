@extends('layouts.admin.AdminLayout')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">Danh sách mã giảm giá</h1>
        <a href="#" class="btn btn-primary disabled"><i class="fas fa-plus"></i> Thêm mã mới</a>
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
                                    <br><span class="text-muted small">đến {{ $coupon->end_date->format('d/m/Y') }}</span>
                                @endif
                            </td>
                            <td>
                                @if($coupon->status)
                                    <span class="badge bg-success">Kích hoạt</span>
                                @else
                                    <span class="badge bg-secondary">Tắt</span>
                                @endif
                            </td>
                            <td>{{ $coupon->description }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
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
        }
    });
});
</script>
@endpush 