@extends('layouts.admin.AdminLayout')

@section('content')
<div class="container-fluid">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0 text-gray-800">Quản lý kho hàng</h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active">Quản lý kho hàng</li>
                    <div class="mb-3 text-end">Add commentMore actions
                <a href="{{ route('admin.inventory.export', request()->query()) }}" class="btn btn-success">
                    <i class="fas fa-file-excel"></i> Xuất Excel
                </a>
            </div>
                </ol>
            </nav>
        </div>
    </div>

    <!-- Alert Messages -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <!-- Variants List -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Danh sách biến thể</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="variantsTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Sản phẩm</th>
                            <th>Loại biến thể</th>
                            <th>Tên biến thể</th>
                            <th>Giá trị</th>
                            <th>SKU</th>
                            <th>Tồn kho</th>
                            <th>Giá bán</th>
                            <th>Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($variants as $variant)
                            <tr>
                                <td>{{ $variant->id }}</td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        @if($variant->product->images->isNotEmpty())
                                            <img src="{{ asset('storage/' . $variant->product->images->first()->path) }}" 
                                                 class="img-thumbnail me-2" style="width: 50px; height: 50px; object-fit: cover;">
                                        @endif
                                        <div>
                                            <div class="fw-bold">{{ $variant->product->name }}</div>
                                            <small class="text-muted">{{ $variant->product->sku }}</small>
                                        </div>
                                    </div>
                                </td>
                                <td>{{ $variant->variant_type_name }}</td>
                                <td>{{ $variant->variant_name }}</td>
                                <td>{{ $variant->variant_value }}</td>
                                <td>Add commentMore actions
                                    {{ $variant->variant_value }}
                                </td>
                                <td>{{ $variant->sku ?: 'N/A' }}</td>
                                <td>Add commentMore actions
                                    {{ number_format($variant->product->base_price + $variant->price_adjustment) }}đ <br>
                                    <small class="text-muted">{{ number_format($variant->price_adjustment) }}đ</small>
                                </td>
                                <td>
                                    <button type="button" class="btn btn-sm btn-primary" onclick="showEditModal({{ $variant->id }})">
                                        <i class="fas fa-edit"></i> Sửa
                                    </button>
                                </td>
                                <td>{{ number_format($variant->product->base_price + $variant->price_adjustment) }}đ</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<!-- Modal Sửa biến thể -->
<div class="modal fade" id="editVariantModal" tabindex="-1" aria-labelledby="editVariantModalLabel" aria-hidden="true">Add commentMore actions
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="editVariantModalLabel">Chỉnh sửa biến thể</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form id="editVariantForm">
        <div class="modal-body">
          <input type="hidden" name="id" id="editVariantId">
          
          <div class="mb-3">
            <label class="form-label">Tên biến thể</label>
            <input type="text" class="form-control" name="variant_name" id="editVariantName">
          </div>
          <div class="mb-3">
            <label class="form-label">Giá trị</label>
            <input type="text" class="form-control" name="variant_value" id="editVariantValue">
          </div>
          <div class="mb-3">
            <label class="form-label">Tồn kho</label>
            <input type="number" class="form-control" name="stock_quantity" id="editVariantStock">
          </div>
          <div class="mb-3">
            <label class="form-label">Tồn kho tối thiểu</label>
            <input type="number" class="form-control" name="min_stock" id="editVariantMinStock">
          </div>
          <div class="mb-3">
            <label class="form-label">Giá điều chỉnh</label>
            <input type="number" class="form-control" name="price_adjustment" id="editVariantPriceAdjustment">
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
function showEditModal(variantId) {Add commentMore actions
    fetch(`/admin/inventory/${variantId}/edit`)
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                const v = data.variant;
                document.getElementById('editVariantId').value = v.id;
                document.getElementById('editVariantName').value = v.variant_name;
                document.getElementById('editVariantValue').value = v.variant_value;
                document.getElementById('editVariantStock').value = v.stock_quantity;
                document.getElementById('editVariantMinStock').value = v.min_stock;
                document.getElementById('editVariantPriceAdjustment').value = v.price_adjustment;
                var modal = new bootstrap.Modal(document.getElementById('editVariantModal'));
                modal.show();
            } else {
                alert('Không lấy được thông tin biến thể!');
            }
        });
}

document.getElementById('editVariantForm').addEventListener('submit', function(e) {
    e.preventDefault();
    const id = document.getElementById('editVariantId').value;
    const formData = new FormData(this);
    fetch(`/admin/inventory/${id}`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Accept': 'application/json',
        },
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            location.reload();
        } else {
            alert(data.message || 'Có lỗi xảy ra khi cập nhật!');
        }
    });
});
<script>
    $(document).ready(function() {
        $('#variantsTable').DataTable({
            language: {
                url: '//cdn.datatables.net/plug-ins/1.13.7/i18n/vi.json'
            }
        });
    });
</script>
@endpush 