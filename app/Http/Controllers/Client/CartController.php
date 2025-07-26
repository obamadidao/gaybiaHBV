@extends('layouts.client.ClientLayout')

@section('content')
    <!--Page Header-->
    <div class="page-header text-center">
        <div class="container">
            <div class="row">
                <div class="col-12 col-sm-12 col-md-12 col-lg-12 d-flex justify-content-between align-items-center">
                    <div class="page-title"><h1>Giỏ hàng</h1></div>
                    <!--Breadcrumbs-->
                    <div class="breadcrumbs">
                        <a href="{{ route('client.index') }}" title="Back to the home page">Trang chủ</a>
                        <span class="main-title"><i class="icon anm anm-angle-right-l"></i>Giỏ hàng</span>
                    </div>
                    <!--End Breadcrumbs-->
                </div>
            </div>
        </div>
    </div>
    <!--End Page Header-->

    <!--Main Content-->
    <div class="container">
        @if($cartItems->count() > 0)
        <!--Cart Page-->
        <div class="page-section-space">
            <form action="#" method="post" class="cart-table table-bottom-brd">
                @csrf
                <table class="table align-middle">
                    <thead class="cart-row cart-header small-hide position-relative">
                        <tr>
                            <th class="action">&nbsp;</th>
                            <th colspan="2" class="text-start">Sản phẩm</th>
                            <th class="text-center">Giá</th>
                            <th class="text-center">Số lượng</th>
                            <th class="text-right">Tổng tiền</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($cartItems as $item)
                        <tr class="cart-row cart-flex position-relative" data-cart-item-id="{{ $item->id }}">
                            <td class="cart-delete text-center small-hide">
                                <button type="button" class="btn btn-link text-danger remove-item" data-item-id="{{ $item->id }}">
                                    <i class="icon anm anm-times-l"></i>
                                </button>
                            </td>
                            <td class="cart-image cart-flex-item">
                                @php $primaryImage = $item->product->images->where('is_primary', 1)->first() ?? $item->product->images->first() @endphp
                                <a href="{{ route('client.product', $item->product->slug) }}">
                                    <img class="cart-image blur-up lazyload" 
                                         data-src="{{ $primaryImage ? $primaryImage->url : asset('assets/images/collection/category.jpg') }}" 
                                         src="{{ $primaryImage ? $primaryImage->url : asset('assets/images/collection/category.jpg') }}" 
                                         alt="{{ $item->product->name }}" 
                                         width="120" height="170" />
                                </a>
                            </td>
                            <td class="cart-meta small-text-left cart-flex-item">
                                <div class="list-view-item-title">
                                    <a href="{{ route('client.product', $item->product->slug) }}">{{ $item->product->name }}</a>
                                </div>
                                <div class="cart-meta-text">
                                    <div class="product-sku">SKU: {{ $item->product->sku }}</div>
                                    @if($item->selected_variants)
                                        <div class="variant-info">
                                            @foreach($item->selected_variants as $type => $value)
                                                <span class="variant-item">{{ $type }}: {{ $value }}</span>
                                                @if(!$loop->last) | @endif
                                            @endforeach
                                        </div>
                                    @endif
                                    <div class="cart-price mobile-cart-price d-md-none">
                                        <span class="money">{{ number_format($item->unit_price, 0, ',', '.') }}đ</span>
                                    </div>
                                    <div class="cart-delete d-md-none">
                                        <button type="button" class="btn btn-link text-danger remove-item" data-item-id="{{ $item->id }}">
                                            <i class="icon anm anm-times-l"></i> Xóa
                                        </button>
                                    </div>
                                </div>
                            </td>
                            <td class="cart-price cart-flex-item text-center small-hide">
                                <span class="money">{{ number_format($item->unit_price, 0, ',', '.') }}đ</span>
                            </td>
                            <td class="cart-update-wrapper cart-flex-item text-center">
                                <div class="cart-qty d-flex justify-content-center align-items-center">
                                    <div class="qtyField">
                                        <button type="button" class="qtyBtn minus" data-item-id="{{ $item->id }}">
                                            <i class="icon anm anm-minus-r"></i>
                                        </button>
                                        <input type="text" name="quantity[]" value="{{ $item->quantity }}" 
                                               class="cart-qty-input qty" data-item-id="{{ $item->id }}" readonly />
                                        <button type="button" class="qtyBtn plus" data-item-id="{{ $item->id }}">
                                            <i class="icon anm anm-plus-r"></i>
                                        </button>
                                    </div>
                                </div>
                            </td>
                            <td class="cart-price cart-flex-item text-center">
                                <span class="money item-total-{{ $item->id }}">{{ number_format($item->total_price, 0, ',', '.') }}đ</span>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="3" class="text-left">
                                <a href="{{ route('client.index') }}" class="btn btn-outline-secondary cart-continue">
                                    <i class="icon anm anm-angle-left-r"></i> Tiếp tục mua sắm
                                </a>
                            </td>
                            <td colspan="3" class="text-right">
                                <button type="button" class="btn btn-outline-danger" id="clear-cart">
                                    <i class="icon anm anm-times-r"></i> Xóa toàn bộ giỏ hàng
                                </button>
                            </td>
                        </tr>
                    </tfoot>
                </table>
            </form>
        </div>

        <!--Cart Summary-->
        <div class="row">
            <div class="col-12 col-sm-12 col-md-12 col-lg-8 cart-footer">
                <div class="cart-discount">
                    <h4>Mã giảm giá</h4>
                    <div class="row">
                        <div class="col-8">
                            <input type="text" class="form-control" placeholder="Nhập mã giảm giá" id="coupon-code">
                        </div>
                        <div class="col-4">
                            <button type="button" class="btn btn-secondary" id="apply-coupon">Áp dụng</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-sm-12 col-md-12 col-lg-4">
                <div class="cart-total-box">
                    <div class="row border-bottom pb-2">
                        <span class="col-5 cart-subtotal-title"><strong>Tạm tính</strong></span>
                        <span class="col-7 cart-subtotal-title cart-subtotal text-right">
                            <span class="money cart-total">{{ number_format($total, 0, ',', '.') }}đ</span>
                        </span>
                    </div>
                    <div class="row border-bottom pb-2 pt-2">
                        <span class="col-5 cart-subtotal-title"><strong>Phí vận chuyển</strong></span>
                        <span class="col-7 cart-subtotal-title text-right">
                            <span class="money">{{ $total >= 500000 ? 'Miễn phí' : '30.000đ' }}</span>
                        </span>
                    </div>
                    <div class="row border-bottom pb-2 pt-2">
                        <span class="col-5 cart-subtotal-title"><strong>Giảm giá</strong></span>
                        <span class="col-7 cart-subtotal-title text-right">
                            <span class="money discount-amount">0đ</span>
                        </span>
                    </div>
                    <div class="row pt-2">
                        <span class="col-5 cart-subtotal-title fs-6"><strong>Tổng cộng</strong></span>
                        <span class="col-7 cart-subtotal-title fs-5 text-right">
                            <span class="money cart-final-total">
                                {{ number_format($total + ($total >= 500000 ? 0 : 30000), 0, ',', '.') }}đ
                            </span>
                        </span>
                    </div>
                    <hr />
                    <p class="cart-tearms">
                        <input type="checkbox" class="form-check-input" id="cart-tearms">
                        <label class="form-check-label" for="cart-tearms">
                            Tôi đồng ý với <a href="#" class="text-link">điều khoản và điều kiện</a>
                        </label>
                    </p>
                    <input type="submit" name="add" class="btn btn-lg my-4 checkout-btn" value="Thanh toán" />
                    <div class="paymnet-img text-center">
                        <img src="{{ asset('assets/images/payment-img.jpg') }}" alt="Payment" width="299" height="28" />
                    </div>
                </div>
            </div>
        </div>
        <!--End Cart Summary-->
        @else
        <!--Empty Cart-->
        <div class="page-section-space text-center">
            <div class="empty-page-content">
                <img src="{{ asset('assets/images/empty-cart.svg') }}" alt="Giỏ hàng trống" width="300" height="300" />
                <h2 class="mb-3">Giỏ hàng của bạn đang trống</h2>
                <p class="mb-4">Hãy thêm một số sản phẩm vào giỏ hàng để tiếp tục mua sắm.</p>
                <a href="{{ route('client.index') }}" class="btn btn-primary btn-lg">
                    <i class="icon anm anm-angle-left-r"></i> Tiếp tục mua sắm
                </a>
            </div>
        </div>
        <!--End Empty Cart-->
        @endif
    </div>
    <!--End Main Content-->

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Handle quantity update
            document.querySelectorAll('.qtyBtn').forEach(button => {
                button.addEventListener('click', function() {
                    const itemId = this.getAttribute('data-item-id');
                    const input = document.querySelector(`input[data-item-id="${itemId}"]`);
                    let currentQty = parseInt(input.value);
                    
                    if (this.classList.contains('plus')) {
                        currentQty++;
                    } else if (this.classList.contains('minus') && currentQty > 1) {
                        currentQty--;
                    }
                    
                    updateQuantity(itemId, currentQty);
                });
            });

            // Handle remove item
            document.querySelectorAll('.remove-item').forEach(button => {
                button.addEventListener('click', function() {
                    const itemId = this.getAttribute('data-item-id');
                    removeItem(itemId);
                });
            });

            // Handle clear cart
            document.getElementById('clear-cart')?.addEventListener('click', function() {
                if (confirm('Bạn có chắc chắn muốn xóa toàn bộ giỏ hàng?')) {
                    clearCart();
                }
            });
        });

        function updateQuantity(itemId, quantity) {
            fetch(`/cart/${itemId}/quantity`, {
                method: 'PUT',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({ quantity: quantity })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Update quantity input
                    document.querySelector(`input[data-item-id="${itemId}"]`).value = quantity;
                    
                    // Update item total
                    document.querySelector(`.item-total-${itemId}`).textContent = data.item_total;
                    
                    // Update cart totals
                    updateCartTotals(data.cart_total);
                    
                    showNotification(data.message, 'success');
                } else {
                    showNotification(data.message, 'error');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showNotification('Có lỗi xảy ra!', 'error');
            });
        }

        function removeItem(itemId) {
            if (!confirm('Bạn có chắc chắn muốn xóa sản phẩm này?')) {
                return;
            }

            fetch(`/cart/${itemId}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Remove item row
                    document.querySelector(`tr[data-cart-item-id="${itemId}"]`).remove();
                    
                    // Update cart totals
                    updateCartTotals(data.cart_total);
                    
                    // Check if cart is empty
                    if (data.cart_count === 0) {
                        location.reload(); // Reload to show empty cart
                    }
                    
                    showNotification(data.message, 'success');
                } else {
                    showNotification(data.message, 'error');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showNotification('Có lỗi xảy ra!', 'error');
            });
        }

        function clearCart() {
            fetch('/cart', {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    location.reload(); // Reload to show empty cart
                } else {
                    showNotification(data.message, 'error');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showNotification('Có lỗi xảy ra!', 'error');
            });
        }

        function updateCartTotals(cartTotal) {
            // Parse cart total (remove 'đ' and convert to number)
            const total = parseInt(cartTotal.replace(/[^0-9]/g, ''));
            const shipping = total >= 500000 ? 0 : 30000;
            const finalTotal = total + shipping;

            // Update display
            document.querySelector('.cart-total').textContent = new Intl.NumberFormat('vi-VN').format(total) + 'đ';
            document.querySelector('.cart-final-total').textContent = new Intl.NumberFormat('vi-VN').format(finalTotal) + 'đ';
        }

        function showNotification(message, type = 'success') {
            // Remove existing notifications
            const existingNotifications = document.querySelectorAll('.cart-notification');
            existingNotifications.forEach(notif => notif.remove());

            // Create notification
            const notification = document.createElement('div');
            notification.className = `cart-notification alert alert-${type === 'success' ? 'success' : 'danger'} alert-dismissible fade show`;
            notification.style.cssText = `
                position: fixed;
                top: 20px;
                right: 20px;
                z-index: 9999;
                min-width: 300px;
                box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            `;
            
            notification.innerHTML = `
                <strong>${type === 'success' ? 'Thành công!' : 'Lỗi!'}</strong> ${message}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            `;

            document.body.appendChild(notification);

            // Auto remove after 3 seconds
            setTimeout(() => {
                if (notification && notification.parentNode) {
                    notification.remove();
                }
            }, 3000);
        }
    </script>
@endsection 