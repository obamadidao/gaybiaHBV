@extends('layouts.client.ClientLayout')

@section('content')
<style>
       .form-check-input {
           width: 1.2em;
           height: 1.2em;
       }
       
       .checkout-btn.disabled {
           opacity: 0.6;
           cursor: not-allowed;
       }
       
       .item-checkbox:checked + .cart-image,
       .item-checkbox:checked ~ .cart-meta {
           opacity: 1;
       }
       
       .item-checkbox:not(:checked) + .cart-image,
       .item-checkbox:not(:checked) ~ .cart-meta {
           opacity: 0.6;
       }
       
       .cart-row {
           transition: opacity 0.3s ease;
       }
        
        .stock-info {
            margin-top: 0.25rem;
        }
        
        .stock-status {
            font-size: 0.875rem;
            font-weight: 500;
        }
        
        .stock-status.text-danger {
            animation: pulse-warning 2s infinite;
        }
        
        @keyframes pulse-warning {
            0% { opacity: 1; }
            50% { opacity: 0.7; }
            100% { opacity: 1; }
        }
   </style>

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
<th class="text-center">
<input type="checkbox" id="select-all" class="form-check-input">
</th>
<th colspan="2" class="text-start">Sản phẩm</th>
<th class="text-center">Giá</th>
<th class="text-center">Số lượng</th>
<th class="text-right">Tổng tiền</th>
<th class="action text-center">#</th>
</tr>
</thead>
<tbody>
@foreach($cartItems as $item)
<tr class="cart-row cart-flex position-relative" data-cart-item-id="{{ $item->id }}">
<td class="text-center">
<input type="checkbox" name="selected_items[]" value="{{ $item->id }}" 
class="form-check-input item-checkbox" checked>
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
                                    @if($item->product->track_quantity)
                                        <div class="stock-info small text-muted">
                                            <span class="stock-status" id="stock-status-{{ $item->id }}">
                                                <i class="fas fa-circle text-success"></i> Tính toán...
                                            </span>
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
<td class="cart-delete text-center small-hide">
<button type="button" class="btn btn-link text-danger remove-item" data-item-id="{{ $item->id }}">
<i class="icon anm anm-times-l"></i>
</button>
</td>
</tr>
@endforeach
</tbody>
<tfoot>
<tr>
<td colspan="4" class="text-left">
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

<div class="row">
<div class=" col-8 mb-3">
<label for="select-coupon" class="form-label">Chọn mã giảm giá có sẵn:</label>
<div class="input-group">
<select class="form-select" id="select-coupon">
<option value="">-- Chọn mã giảm giá --</option>
@foreach($listCoupons as $coupon)
<option value="{{ $coupon->code }}">
{{ $coupon->code }} - {{ $coupon->description }}
</option>
@endforeach
</select>
<button class="btn btn-outline-primary" type="button" id="copy-coupon-btn">
<i class="fas fa-copy"></i> Chọn mã
</button>
</div>
</div>
</div>
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
<div class="d-grid gap-2">
<a href="#" class="btn btn-success btn-lg mb-4 checkout-btn" onclick="proceedToCheckout(event)">
<i class="fas fa-credit-card me-2"></i>Tiến hành thanh toán
</a>
</div>
</div>
</div>
</div>
<!--End Cart Summary-->
@else
<!--Empty Cart-->
<div class="page-section-space text-center mb-4">
<div class="empty-page-content">
<img src="{{ asset('assets/images/empty-img.gif') }}" alt="Giỏ hàng trống" width="300" height="300"/>
<h2 class="mb-3">Giỏ hàng của bạn đang trống</h2>
<p class="mb-4">Hãy thêm một số sản phẩm vào giỏ hàng để tiếp tục mua sắm.</p>
<a href="{{ route('client.index') }}" class="btn btn-primary btn-lg">
Tiếp tục mua sắm
</a>
</div>
</div>
<!--End Empty Cart-->
@endif
</div>
<!--End Main Content-->

<script>
       document.addEventListener('DOMContentLoaded', function() {
           // Handle select all checkbox
           const selectAllCheckbox = document.getElementById('select-all');
           const itemCheckboxes = document.querySelectorAll('.item-checkbox');
           
           // Select/Deselect all items
           selectAllCheckbox?.addEventListener('change', function() {
               itemCheckboxes.forEach(checkbox => {
                   checkbox.checked = this.checked;
               });
               updateSelectedItemsSummary();
           });
           
           // Handle individual item checkbox changes
           itemCheckboxes.forEach(checkbox => {
               checkbox.addEventListener('change', function() {
                   updateSelectAllState();
                   updateSelectedItemsSummary();
               });
           });
           
           // Initialize select all state
           updateSelectAllState();
           updateSelectedItemsSummary();
            
            // Initialize stock info for all items
            initializeStockInfo();

           // Handle quantity update
           document.querySelectorAll('.qtyBtn').forEach(button => {
               button.addEventListener('click', function() {
                   const itemId = this.getAttribute('data-item-id');
                   const input = document.querySelector(`input[data-item-id="${itemId}"]`);
                   let currentQty = parseInt(input.value);
                   
                   if (this.classList.contains('plus')) {
                        currentQty++;
                        checkMaxQuantityAndUpdate(itemId, currentQty);
                   } else if (this.classList.contains('minus') && currentQty > 1) {
                        currentQty--;
                        updateQuantity(itemId, currentQty);
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

       function updateSelectAllState() {
           const selectAllCheckbox = document.getElementById('select-all');
           const itemCheckboxes = document.querySelectorAll('.item-checkbox');
           const checkedItems = document.querySelectorAll('.item-checkbox:checked');
           
           if (selectAllCheckbox) {
               if (checkedItems.length === 0) {
                   selectAllCheckbox.checked = false;
                   selectAllCheckbox.indeterminate = false;
               } else if (checkedItems.length === itemCheckboxes.length) {
                   selectAllCheckbox.checked = true;
                   selectAllCheckbox.indeterminate = false;
               } else {
                   selectAllCheckbox.checked = false;
                   selectAllCheckbox.indeterminate = true;
               }
           }
       }

       function calculateSelectedItemsTotal() {
           const checkedItems = document.querySelectorAll('.item-checkbox:checked');
           let selectedSubtotal = 0;
           
           checkedItems.forEach(checkbox => {
               const itemId = checkbox.value;
               const itemRow = document.querySelector(`tr[data-cart-item-id="${itemId}"]`);
               if (itemRow) {
                   const totalElement = itemRow.querySelector(`[class*="item-total-"]`);
                   if (totalElement) {
                       const totalText = totalElement.textContent.replace(/[^\d]/g, '');
                       selectedSubtotal += parseInt(totalText) || 0;
                   }
               }
           });
           
           // Store selected subtotal for future use (e.g., when proceeding to checkout)
           window.selectedItemsSubtotal = selectedSubtotal;
           
           // Update display with selected items total
           updateCartTotalsDisplay(selectedSubtotal);
       }

       function updateCartTotalsDisplay(selectedSubtotal) {
           // Update subtotal display
           const subtotalElement = document.querySelector('.cart-subtotal-amount');
           if (subtotalElement) {
               subtotalElement.textContent = formatCurrency(selectedSubtotal);
           }
           
           // Calculate shipping fee based on selected subtotal (free if >= 500K)
           const shippingFee = selectedSubtotal >= 500000 ? 0 : 0;
           
           // Update shipping fee display
           const shippingElement = document.querySelector('.cart-shipping-fee');
           if (shippingElement) {
               shippingElement.textContent = shippingFee > 0 ? formatCurrency(shippingFee) : 'Miễn phí';
           }
           
           // Get current discount amount and recalculate based on selected items
           let discountAmount = 0;
           
           // Check if there's an applied coupon by looking at the coupon section
           const appliedCouponInfo = document.querySelector('.applied-coupon-info');
           if (appliedCouponInfo && selectedSubtotal > 0) {
               // Try to get coupon info from the current cart summary
               // This is a simplified approach - in real implementation, 
               // you might want to store coupon details in data attributes or make an API call
               fetch('/cart/summary', {
                   method: 'GET',
                   headers: {
                       'X-Requested-With': 'XMLHttpRequest',
                       'Accept': 'application/json'
                   }
               })
               .then(response => response.json())
               .then(data => {
                   if (data.success && data.cart_summary.applied_coupon) {
                       const coupon = data.cart_summary.applied_coupon;
                       
                       // Recalculate discount based on selected subtotal
                       if (coupon.type === 'percent') {
                           discountAmount = (selectedSubtotal * coupon.value) / 100;
                           if (coupon.max_discount_value && discountAmount > coupon.max_discount_value) {
                               discountAmount = coupon.max_discount_value;
                           }
                       } else if (coupon.type === 'fixed') {
                           discountAmount = Math.min(coupon.value, selectedSubtotal);
                       }
                       
                       // Update discount display
                       const discountElement = document.querySelector('.cart-discount-amount');
                       if (discountElement) {
                           if (discountAmount > 0) {
                               discountElement.textContent = '-' + formatCurrency(discountAmount);
                               discountElement.classList.add('text-success');
                           } else {
                               discountElement.textContent = '0đ';
                               discountElement.classList.remove('text-success');
                           }
                       }
                       
                       // Update discount amount in coupon info
                       const couponDiscountText = appliedCouponInfo.querySelector('p.text-success');
                       if (couponDiscountText) {
                           couponDiscountText.textContent = `Giảm: ${formatCurrency(discountAmount)}`;
                       }
                       
                       // Calculate and update final total
                       const finalTotal = Math.max(0, selectedSubtotal + shippingFee - discountAmount);
                       const finalTotalElement = document.querySelector('.cart-final-total');
                       if (finalTotalElement) {
                           finalTotalElement.textContent = formatCurrency(finalTotal);
                       }
                   } else {
                       // No coupon applied, just calculate without discount
                       updateTotalsWithoutCoupon(selectedSubtotal, shippingFee);
                   }
               })
               .catch(() => {
                   // Error getting coupon info, calculate without discount
                   updateTotalsWithoutCoupon(selectedSubtotal, shippingFee);
               });
           } else {
               // No coupon applied, calculate without discount
               updateTotalsWithoutCoupon(selectedSubtotal, shippingFee);
           }
       }

       function updateTotalsWithoutCoupon(selectedSubtotal, shippingFee) {
           // Update discount amount to 0
           const discountElement = document.querySelector('.cart-discount-amount');
           if (discountElement) {
               discountElement.textContent = '0đ';
               discountElement.classList.remove('text-success');
           }
           
           // Update shipping fee display
           const shippingElement = document.querySelector('.cart-shipping-fee');
           if (shippingElement) {
               shippingElement.textContent = shippingFee > 0 ? formatCurrency(shippingFee) : 'Miễn phí';
           }
           
           // Calculate final total without discount
           const finalTotal = selectedSubtotal + shippingFee;
           const finalTotalElement = document.querySelector('.cart-final-total');
           if (finalTotalElement) {
               finalTotalElement.textContent = formatCurrency(finalTotal);
           }
       }

       function formatCurrency(amount) {
           return new Intl.NumberFormat('vi-VN', {
               style: 'currency',
               currency: 'VND',
               minimumFractionDigits: 0,
               maximumFractionDigits: 0
           }).format(amount).replace('₫', 'đ');
       }

       function updateSelectedItemsSummary() {
           const checkedItems = document.querySelectorAll('.item-checkbox:checked');
           const checkoutBtn = document.querySelector('.checkout-btn');
           
           if (checkedItems.length === 0) {
               // Disable checkout if no items selected
               if (checkoutBtn) {
                   checkoutBtn.classList.add('disabled');
                   checkoutBtn.style.pointerEvents = 'none';
                   checkoutBtn.innerHTML = '<i class="fas fa-credit-card me-2"></i>Chọn sản phẩm để thanh toán';
               }
               
               // Reset totals to 0 when no items selected
               updateCartTotalsDisplay(0);
           } else {
               // Enable checkout
               if (checkoutBtn) {
                   checkoutBtn.classList.remove('disabled');
                   checkoutBtn.style.pointerEvents = 'auto';
                   checkoutBtn.innerHTML = `<i class="fas fa-credit-card me-2"></i>Thanh toán (${checkedItems.length} sản phẩm)`;
               }
               
               // Calculate selected items total
               calculateSelectedItemsTotal();
           }
       }

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
                   
                   // Update selected items summary
                   updateSelectedItemsSummary();
                   
                   // Update global cart count
                   if (typeof window.updateCartCount === 'function') {
                       window.updateCartCount(data.cart_count);
                   }
                   
                    // Update stock info for this item and potentially others
                    updateStockInfo(itemId);
                    
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
                   
                   // Update select all state and selected items summary
                   updateSelectAllState();
                   updateSelectedItemsSummary();
                   
                   // Update cart totals and summary (recalculate coupon if applied)
                   refreshCartSummary();
                   
                   // Update global cart count
                   if (typeof window.updateCartCount === 'function') {
                       window.updateCartCount(data.cart_count);
                   }
                   
                    // Update stock info for all remaining items
                    initializeStockInfo();
                    
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
           // Calculate selected items subtotal
           const checkedItems = document.querySelectorAll('.item-checkbox:checked');
           let selectedSubtotal = 0;
           
           checkedItems.forEach(checkbox => {
               const itemId = checkbox.value;
               const itemRow = document.querySelector(`tr[data-cart-item-id="${itemId}"]`);
               if (itemRow) {
                   const totalElement = itemRow.querySelector(`[class*="item-total-"]`);
                   if (totalElement) {
                       const totalText = totalElement.textContent.replace(/[^\d]/g, '');
                       selectedSubtotal += parseInt(totalText) || 0;
                   }
               }
           });

           // Update subtotal with selected items only
           const subtotalElement = document.querySelector('.cart-subtotal-amount');
           if (subtotalElement) {
               subtotalElement.textContent = formatCurrency(selectedSubtotal);
           }

           // Calculate shipping fee based on selected subtotal (free if >= 500K)
           const shippingFee = selectedSubtotal >= 500000 ? 0 : 30000;
           const shippingElement = document.querySelector('.cart-shipping-fee');
           if (shippingElement) {
               shippingElement.textContent = shippingFee > 0 ? formatCurrency(shippingFee) : 'Miễn phí';
           }

           // Calculate discount based on selected items
           let discountAmount = 0;
           if (cartSummary.applied_coupon && selectedSubtotal > 0) {
               // Recalculate discount based on selected subtotal
               const coupon = cartSummary.applied_coupon;
               if (coupon.type === 'percent') {
                   discountAmount = (selectedSubtotal * coupon.value) / 100;
                   if (coupon.max_discount_value && discountAmount > coupon.max_discount_value) {
                       discountAmount = coupon.max_discount_value;
                   }
               } else if (coupon.type === 'fixed') {
                   discountAmount = Math.min(coupon.value, selectedSubtotal);
               }
           }

           // Update discount amount
           const discountElement = document.querySelector('.cart-discount-amount');
           if (discountElement) {
               if (discountAmount > 0) {
                   discountElement.textContent = '-' + formatCurrency(discountAmount);
                   discountElement.classList.add('text-success');
               } else {
                   discountElement.textContent = '0đ';
                   discountElement.classList.remove('text-success');
               }
           }

           // Calculate final total based on selected items
           const finalTotal = Math.max(0, selectedSubtotal + shippingFee - discountAmount);
           const finalTotalElement = document.querySelector('.cart-final-total');
           if (finalTotalElement) {
               finalTotalElement.textContent = formatCurrency(finalTotal);
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
                                               Giảm: ${formatCurrency(discountAmount)}
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

       function proceedToCheckout(event) {
           event.preventDefault();
           
           // Get selected items
           const checkedItems = document.querySelectorAll('.item-checkbox:checked');
           
           if (checkedItems.length === 0) {
               showNotification('Vui lòng chọn ít nhất một sản phẩm để thanh toán!', 'error');
               return;
           }
           
           // Get selected item IDs
           const selectedItemIds = Array.from(checkedItems).map(checkbox => checkbox.value);
           
           // Create form to submit selected items
           const form = document.createElement('form');
           form.method = 'POST';
           form.action = '{{ route("client.order.checkout") }}';
           
           // Add CSRF token
           const csrfInput = document.createElement('input');
           csrfInput.type = 'hidden';
           csrfInput.name = '_token';
           csrfInput.value = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
           form.appendChild(csrfInput);
           
           // Add selected item IDs
           selectedItemIds.forEach(itemId => {
               const input = document.createElement('input');
               input.type = 'hidden';
               input.name = 'selected_items[]';
               input.value = itemId;
               form.appendChild(input);
           });
           
           // Submit form
           document.body.appendChild(form);
           form.submit();
       }

        // Initialize stock info for all cart items
        function initializeStockInfo() {
            document.querySelectorAll('[id^="stock-status-"]').forEach(element => {
                const itemId = element.id.replace('stock-status-', '');
                updateStockInfo(itemId);
            });
        }

        // Check max quantity and update if allowed
        function checkMaxQuantityAndUpdate(itemId, newQuantity) {
            fetch(`/cart/${itemId}/max-quantity`, {
                method: 'GET',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    if (newQuantity <= data.max_quantity) {
                        updateQuantity(itemId, newQuantity);
                    } else {
                        // Show bottleneck message
                        let message = `Chỉ có thể cập nhật tối đa ${data.max_quantity} sản phẩm!`;
                        if (data.bottleneck_info && data.bottleneck_info.is_bottleneck) {
                            message += ` Bị giới hạn bởi "${data.bottleneck_info.name}" (còn ${data.bottleneck_info.available})`;
                        }
                        showNotification(message, 'error');
                    }
                } else {
                    showNotification(data.message, 'error');
                }
            })
            .catch(error => {
                console.error('Error checking max quantity:', error);
                showNotification('Có lỗi xảy ra khi kiểm tra số lượng!', 'error');
            });
        }

        // Update stock info for a cart item
        function updateStockInfo(itemId) {
            fetch(`/cart/${itemId}/max-quantity`, {
                method: 'GET',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    const stockElement = document.getElementById(`stock-status-${itemId}`);
                    if (stockElement) {
                        let statusHtml = '';
                        let statusClass = '';
                        
                        const maxQty = data.max_quantity;
                        const currentQty = data.current_quantity;
                        const availableToAdd = maxQty - currentQty;
                        
                        if (availableToAdd <= 0) {
                            statusClass = 'text-danger';
                            statusHtml = '<i class="fas fa-exclamation-triangle"></i> Đã đạt giới hạn';
                        } else if (availableToAdd <= 3) {
                            statusClass = 'text-warning';
                            statusHtml = `<i class="fas fa-exclamation-circle"></i> Có thể thêm ${availableToAdd} nữa`;
                        } else {
                            statusClass = 'text-success';
                            statusHtml = `<i class="fas fa-check-circle"></i> Có thể thêm ${availableToAdd} nữa`;
                        }
                        
                        // Add bottleneck info if applicable
                        if (data.bottleneck_info && data.bottleneck_info.is_bottleneck) {
                            statusHtml += `<br><small class="text-muted">Giới hạn: ${data.bottleneck_info.name}</small>`;
                        }
                        
                        stockElement.className = `stock-status ${statusClass}`;
                        stockElement.innerHTML = statusHtml;
                    }
                }
            })
            .catch(error => {
                console.error('Error updating stock info:', error);
            });
        }
   </script>
   <script>
       document.addEventListener('DOMContentLoaded', function() {
           const selectCoupon = document.getElementById('select-coupon');
           const copyBtn = document.getElementById('copy-coupon-btn');
           copyBtn.addEventListener('click', function() {
               const code = selectCoupon.value;
               if (!code) {
                   alert('Vui lòng chọn mã giảm giá để sao chép!');
                   return;
               }
               // Tự động điền mã vào ô nhập mã giảm giá nếu có ô đó
               const couponInput = document.getElementById('coupon-code');
               if (couponInput) {
                   couponInput.value = code;
                   couponInput.focus();
               }
           });
       });
   </script>