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
<span class="variant-item">{{ $value }}</span>
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
<td class="cart-price cart-flex-item text-end">
<span class="money item-total-{{ $item->id }}">{{ number_format($item->total_price, 0, ',', '.') }}đ</span>
</td>
</tr>
@endforeach
</tbody>
<tfoot>
<tr>
<td colspan="3" class="text-left">
<a href="{{ route('client.index') }}" class="btn btn-outline-secondary cart-continue">
Tiếp tục mua sắm
</a>
</td>
<td colspan="3" class="text-right">
<button type="button" class="btn btn-outline-danger" id="clear-cart">
Xóa toàn bộ giỏ hàng
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

<div id="coupon-section">
@if($cartSummary['applied_coupon'])
<!-- Hiển thị coupon đã áp dụng -->
<div class="row">
<div class="col-8">
<div class="applied-coupon-info border rounded p-3 mb-3 bg-light">
<div class="d-flex justify-content-between align-items-center">
<div>
<strong class="text-success">
<i class="fas fa-check-circle"></i> 
Mã "{{ $cartSummary['applied_coupon']['code'] }}" đã được áp dụng
</strong>
@if($cartSummary['applied_coupon']['description'])
<p class="mb-0 text-muted small">{{ $cartSummary['applied_coupon']['description'] }}</p>
@endif
<p class="mb-0 text-success">
Giảm: {{ number_format($cartSummary['discount_amount'], 0, ',', '.') }}đ
</p>
</div>
<button type="button" class="btn btn-outline-danger btn-sm" id="remove-coupon">
<i class="fas fa-times"></i> Hủy
</button>
</div>
</div>
</div>
</div>
@else
<!-- Form nhập mã giảm giá -->
<div class="coupon-form">
<div class="row">
<div class="col-8">
<div class="input-group mb-3">
<input type="text" class="form-control" placeholder="Nhập mã giảm giá" aria-label="Nhập mã giảm giá" aria-describedby="button-addon2" id="coupon-code">
<button class="btn btn-outline-secondary" type="button" id="apply-coupon">
<span class="button-text">Áp dụng</span>
<span class="button-loading d-none">
<i class="fas fa-spinner fa-spin"></i> Đang xử lý...
</span>
</button>
</div>
</div>
</div>
</div>
@endif
</div>
</div>
</div>
<div class="col-12 col-sm-12 col-md-12 col-lg-4">
<div class="cart-total-box">
<div class="row border-bottom pb-2">
<span class="col-5 cart-subtotal-title"><strong>Tạm tính</strong></span>
<span class="col-7 cart-subtotal-title cart-subtotal text-right">
<span class="money cart-subtotal-amount">{{ $cartSummary['formatted']['subtotal'] }}</span>
</span>
</div>
<div class="row border-bottom pb-2 pt-2">
<span class="col-5 cart-subtotal-title"><strong>Phí vận chuyển</strong></span>
<span class="col-7 cart-subtotal-title text-right">
<span class="money cart-shipping-fee">{{ $cartSummary['formatted']['shipping_fee'] }}</span>
</span>
</div>
<div class="row border-bottom pb-2 pt-2">
<span class="col-5 cart-subtotal-title"><strong>Giảm giá</strong></span>
<span class="col-7 cart-subtotal-title text-right">
<span class="money cart-discount-amount text-success">
@if($cartSummary['discount_amount'] > 0)
-{{ $cartSummary['formatted']['discount_amount'] }}
@else
0đ
@endif
</span>
</span>
</div>
<div class="row pt-2">
<span class="col-5 cart-subtotal-title fs-6"><strong>Tổng cộng</strong></span>
<span class="col-7 cart-subtotal-title fs-5 text-right">
<span class="money cart-final-total text-danger fw-bold">
{{ $cartSummary['formatted']['final_total'] }}
</span>
</span>
</div>
<hr />
                    <input type="submit" name="add" style="width: 100%;" class="btn btn-lg my-4 checkout-btn" value="Thanh toán" />
                    <div class="d-grid gap-2">
                            <a href="{{ route('client.order.checkout') }}" class="btn btn-success btn-lg mb-4 checkout-btn">
                            <i class="fas fa-credit-card me-2"></i>Tiến hành thanh toán
                        </a>
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
                   } else if (this.classList.contains('minus') && currentQty > 1) {
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

           // Handle apply coupon
           document.getElementById('apply-coupon')?.addEventListener('click', function() {
               applyCoupon();
           });

           // Handle coupon input keypress
           document.getElementById('coupon-code')?.addEventListener('keypress', function(e) {
               if (e.key === 'Enter') {
                   applyCoupon();
               }
           });

           // Handle remove coupon
           document.getElementById('remove-coupon')?.addEventListener('click', function() {
               removeCoupon();
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
                   
                   // Update cart totals and summary (recalculate coupon if applied)
                   refreshCartSummary();
                   
                   // Update global cart count
                   if (typeof window.updateCartCount === 'function') {
                       window.updateCartCount(data.cart_count);
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
                   
                   // Update cart totals and summary (recalculate coupon if applied)
                   refreshCartSummary();
                   
                   // Update global cart count
                   if (typeof window.updateCartCount === 'function') {
                       window.updateCartCount(data.cart_count);
                   }
                   
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
                   // Update global cart count to 0
                   if (typeof window.updateCartCount === 'function') {
                       window.updateCartCount(0);
                   }
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
           // Legacy function - now we should use updateCartSummary instead
           // But keeping for backward compatibility
           refreshCartSummary();
       }

       function refreshCartSummary() {
           fetch('/cart/summary', {
               method: 'GET',
               headers: {
                   'X-Requested-With': 'XMLHttpRequest',
                   'Accept': 'application/json'
               }
           })
           .then(response => response.json())
           .then(data => {
               if (data.success) {
                   updateCartSummaryDisplay(data.cart_summary);
               }
           })
           .catch(error => {
               console.error('Error refreshing cart summary:', error);
           });
       }

       function updateCartSummaryDisplay(cartSummary) {
           // Update subtotal
           const subtotalElement = document.querySelector('.cart-subtotal-amount');
           if (subtotalElement) {
               subtotalElement.textContent = cartSummary.formatted.subtotal;
           }

           // Update shipping fee
           const shippingElement = document.querySelector('.cart-shipping-fee');
           if (shippingElement) {
               shippingElement.textContent = cartSummary.formatted.shipping_fee;
           }

           // Update discount amount
           const discountElement = document.querySelector('.cart-discount-amount');
           if (discountElement) {
               if (cartSummary.discount_amount > 0) {
                   discountElement.textContent = '-' + cartSummary.formatted.discount_amount;
                   discountElement.classList.add('text-success');
               } else {
                   discountElement.textContent = '0đ';
                   discountElement.classList.remove('text-success');
               }
           }

           // Update final total
           const finalTotalElement = document.querySelector('.cart-final-total');
           if (finalTotalElement) {
               finalTotalElement.textContent = cartSummary.formatted.final_total;
           }

           // Update coupon section
           const couponSection = document.getElementById('coupon-section');
           if (couponSection) {
               if (cartSummary.applied_coupon) {
                   couponSection.innerHTML = `
                       <div class="row">
                           <div class="col-8">
                               <div class="applied-coupon-info border rounded p-3 mb-3 bg-light">
                                   <div class="d-flex justify-content-between align-items-center">
                                       <div>
                                           <strong class="text-success">
                                               <i class="fas fa-check-circle"></i> 
                                               Mã "${cartSummary.applied_coupon.code}" đã được áp dụng
                                           </strong>
                                           ${cartSummary.applied_coupon.description ? 
                                               `<p class="mb-0 text-muted small">${cartSummary.applied_coupon.description}</p>` : ''}
                                           <p class="mb-0 text-success">
                                               Giảm: ${cartSummary.formatted.discount_amount}
                                           </p>
                                       </div>
                                       <button type="button" class="btn btn-outline-danger btn-sm" id="remove-coupon">
                                           <i class="fas fa-times"></i> Hủy
                                       </button>
                                   </div>
                               </div>
                           </div>
                       </div>
                   `;
                   // Reattach event listener for remove coupon button
                   document.getElementById('remove-coupon')?.addEventListener('click', removeCoupon);
               } else {
                   couponSection.innerHTML = `
                       <div class="coupon-form">
                           <div class="row">
                               <div class="col-8">
                                   <div class="input-group mb-3">
                                       <input type="text" class="form-control" placeholder="Nhập mã giảm giá" 
                                              aria-label="Nhập mã giảm giá" aria-describedby="button-addon2" id="coupon-code">
                                       <button class="btn btn-outline-secondary" type="button" id="apply-coupon">
                                           <span class="button-text">Áp dụng</span>
                                           <span class="button-loading d-none">
                                               <i class="fas fa-spinner fa-spin"></i> Đang xử lý...
                                           </span>
                                       </button>
                                   </div>
                               </div>
                           </div>
                       </div>
                   `;
                   // Reattach event listeners for apply coupon
                   document.getElementById('apply-coupon')?.addEventListener('click', applyCoupon);
                   document.getElementById('coupon-code')?.addEventListener('keypress', function(e) {
                       if (e.key === 'Enter') {
                           applyCoupon();
                       }
                   });
               }
           }
       }

       function applyCoupon() {
           const couponInput = document.getElementById('coupon-code');
           const applyButton = document.getElementById('apply-coupon');
           const buttonText = applyButton.querySelector('.button-text');
           const buttonLoading = applyButton.querySelector('.button-loading');

           const couponCode = couponInput.value.trim();

           if (!couponCode) {
               showNotification('Vui lòng nhập mã giảm giá!', 'error');
               couponInput.focus();
               return;
           }

           // Show loading state
           buttonText.classList.add('d-none');
           buttonLoading.classList.remove('d-none');
           applyButton.disabled = true;

           fetch('/cart/coupon/apply', {
               method: 'POST',
               headers: {
                   'Content-Type': 'application/json',
                   'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                   'Accept': 'application/json'
               },
               body: JSON.stringify({
                   coupon_code: couponCode
               })
           })
           .then(response => response.json())
           .then(data => {
               if (data.success) {
                   showNotification(data.message, 'success');
                   refreshCartSummary();
               } else {
                   showNotification(data.message, 'error');
               }
           })
           .catch(error => {
               console.error('Error applying coupon:', error);
               showNotification('Có lỗi xảy ra khi áp dụng mã giảm giá!', 'error');
           })
           .finally(() => {
               // Reset button state
               buttonText.classList.remove('d-none');
               buttonLoading.classList.add('d-none');
               applyButton.disabled = false;
           });
       }

       function removeCoupon() {
           if (!confirm('Bạn có chắc chắn muốn hủy áp dụng mã giảm giá?')) {
               return;
           }

           fetch('/cart/coupon/remove', {
               method: 'DELETE',
               headers: {
                   'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                   'Accept': 'application/json'
               }
           })
           .then(response => response.json())
           .then(data => {
               if (data.success) {
                   showNotification(data.message, 'success');
                   refreshCartSummary();
               } else {
                   showNotification(data.message, 'error');
               }
           })
           .catch(error => {
               console.error('Error removing coupon:', error);
               showNotification('Có lỗi xảy ra khi hủy mã giảm giá!', 'error');
           });
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