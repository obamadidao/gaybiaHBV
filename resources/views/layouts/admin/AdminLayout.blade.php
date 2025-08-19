<!doctype html>
<html lang="en">
<!--begin::Head-->
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>HBV BilliardShop</title>
<!--begin::Primary Meta Tags-->
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="reverb-app-key" content="{{ env('REVERB_APP_KEY') }}">
    <meta name="reverb-host" content="{{ env('REVERB_HOST', 'localhost') }}">
    <meta name="reverb-port" content="{{ env('REVERB_PORT', '8080') }}">
    <meta name="reverb-scheme" content="{{ env('REVERB_SCHEME', 'http') }}">
<meta name="title" content="HBV BilliardShop" />
<meta name="author" content="HBV BilliardShop" />
<meta
name="description"
content="HBV BilliardShop"
/>
<meta
name="keywords"
content="bootstrap 5, bootstrap, bootstrap 5 admin dashboard, bootstrap 5 dashboard, bootstrap 5 charts, bootstrap 5 calendar, bootstrap 5 datepicker, bootstrap 5 tables, bootstrap 5 datatable, vanilla js datatable, colorlibhq, colorlibhq dashboard, colorlibhq admin dashboard"
/>
<!--end::Primary Meta Tags-->
<!--begin::Fonts-->
<link
rel="stylesheet"
href="https://cdn.jsdelivr.net/npm/@fontsource/source-sans-3@5.0.12/index.css"
integrity="sha256-tXJfXfp6Ewt1ilPzLDtQnJV4hclT9XuaZUKyUvmyr+Q="
crossorigin="anonymous"
/>
<!--end::Fonts-->
<!--begin::Third Party Plugin(OverlayScrollbars)-->
<link
rel="stylesheet"
href="https://cdn.jsdelivr.net/npm/overlayscrollbars@2.10.1/styles/overlayscrollbars.min.css"
integrity="sha256-tZHrRjVqNSRyWg2wbppGnT833E/Ys0DHWGwT04GiqQg="
crossorigin="anonymous"
/>
<!--end::Third Party Plugin(OverlayScrollbars)-->
<!--begin::Third Party Plugin(Bootstrap Icons)-->
<link
rel="stylesheet"
href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css"
integrity="sha256-9kPW/n5nn53j4WMRYAxe9c1rCY96Oogo/MKSVdKzPmI="
crossorigin="anonymous"
/>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
<!--end::Third Party Plugin(Bootstrap Icons)-->
<!--begin::Required Plugin(AdminLTE)-->
<link rel="stylesheet" href="{{ asset('dist/css/adminlte.css') }}" />
<!--end::Required Plugin(AdminLTE)-->

<!--begin::Scripts-->
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<!--end::Scripts-->
    
    <!-- Laravel Echo and Pusher CDN -->
    <script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>
    <script src="https://unpkg.com/laravel-echo@1.15.3/dist/echo.iife.js"></script>
    
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css">
@stack('styles')
</head>
<!--end::Head-->
<!--begin::Body-->
<body class="layout-fixed sidebar-expand-lg bg-body-tertiary">
<!--begin::App Wrapper-->
<div class="app-wrapper">
<!--begin::Header-->
@include('layouts.admin.blocks.header')
<!--end::Header-->
<!--begin::Sidebar-->
@include('layouts.admin.blocks.aside')
<!--end::Sidebar-->
<!--begin::App Main-->
<main class="app-main">
<!--begin::App Content Header-->
<div class="app-content-header">
<!--begin::Container-->
<div class="container-fluid">
<!--begin::Row-->
<div class="row">
<div class="col-sm-6"><h3 class="mb-0">@yield('title-page')</h3></div>
</div>
<!--end::Row-->
</div>
<!--end::Container-->
</div>
<!--end::App Content Header-->
<!--begin::App Content-->
<div class="app-content">
<!--begin::Container-->
<div class="container-fluid">
<!--begin::Row-->
@yield('content')
<!--end::Row-->
</div>
<!--end::Container-->
</div>
<!--end::App Content-->
</main>
<!--end::App Main-->
<!--begin::Footer-->
@include('layouts.admin.blocks.footer')
<!--end::Footer-->
</div>
<!--end::App Wrapper-->

<!--begin::Script-->
<script src="https://cdn.jsdelivr.net/npm/overlayscrollbars@2.10.1/browser/overlayscrollbars.browser.es6.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"></script>
<script src="{{ asset('dist/js/adminlte.js') }}"></script>
<script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>
<!--end::Script-->
<script src="https://cdn.jsdelivr.net/npm/chart.js@2.9.4/dist/Chart.min.js"></script>
    
    <!-- Echo Realtime Setup -->
    <script src="{{ asset('assets/js/echo-realtime.js') }}"></script>

    <!-- Realtime Notifications Script -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Check if user is admin
            @if(Auth::check() && Auth::user()->isAdmin())
                // Wait for Echo to be initialized before setting up notifications
                setTimeout(() => {
                    initAdminNotifications();
                }, 5000); // Wait 5 seconds for Echo to be ready
            @endif
        });

        function initAdminNotifications() {
            let notificationCount = 0;
            
            // Check if Echo is available
            if (typeof window.Echo !== 'undefined' && window.Echo !== null) {
                console.log('🔔 Setting up real-time notifications for admin...');
                console.log('🔍 Echo object:', window.Echo);
                console.log('🔍 Echo connector:', window.Echo?.connector);
                
                // Listen for new orders with error handling
                console.log('🎯 Subscribing to admin-orders channel...');
                try {
                    window.Echo.private('admin-orders')
                        .listen('.order.new', (data) => {
                            console.log('📨 New order received:', data);
                            showNewOrderNotification(data);
                            updateNotificationCount();
                            
                            // Thêm đơn hàng mới vào danh sách nếu đang ở trang orders
                            addNewOrderToList(data);
                        })
                        .listen('.order.status.changed', (data) => {
                            console.log('📨 Order status changed:', data);
                            console.log('🔍 Event data details:', {
                                order_id: data.order_id,
                                new_status: data.new_status,
                                cancelled_by_customer: data.cancelled_by_customer,
                                cancelled_by: data.cancelled_by,
                                old_status: data.old_status,
                                current_path: window.location.pathname
                            });
                            console.log('🔍 Full event data:', data);
                            
                            showOrderStatusNotification(data);
                            updateNotificationCount();
                            
                            // Cập nhật DOM nếu đang ở trang tương ứng
                            updateAdminOrdersView(data);
                        })
                        .error((error) => {
                            console.error('❌ Error on admin-orders channel:', error);
                        });
                        
                    console.log('✅ Successfully subscribed to admin-orders channel');
                } catch (error) {
                    console.error('❌ Error subscribing to admin-orders channel:', error);
                }

                // Listen for admin stats with error handling
                try {
                    window.Echo.private('admin-stats')
                        .listen('.order.new', (data) => {
                            console.log('Stats updated:', data);
                            updateDashboardStats(data);
                        })
                        .error((error) => {
                            console.error('❌ Error on admin-stats channel:', error);
                        });
                } catch (error) {
                    console.error('❌ Error subscribing to admin-stats channel:', error);
                }
            } else {
                console.warn('❌ Echo not available. Using fallback notification system.');
                console.log('🔍 Checking Echo availability...');
                console.log('window.Echo:', typeof window.Echo);
                console.log('window.Echo object:', window.Echo);
                
                // Polling disabled - focus on realtime only
                console.log('🚫 Polling disabled. Working on WebSocket connection...');
            }

            // Handle mark all as read
            document.getElementById('mark-all-read').addEventListener('click', function(e) {
                e.preventDefault();
                markAllNotificationsAsRead();
            });
        }

        function showNewOrderNotification(data) {
            const notification = createNotificationElement({
                type: 'new-order',
                title: 'Đơn hàng mới',
                message: `Đơn hàng #${data.order_code} từ ${data.customer_name}`,
                amount: formatCurrency(data.total_amount),
                time: 'Vừa xong',
                icon: 'bi-cart-plus',
                color: 'success'
            });
            
            addNotificationToList(notification);
            showToast('Có đơn hàng mới!', `Đơn hàng #${data.order_code} từ ${data.customer_name}`, 'success');
        }

        function showOrderStatusNotification(data) {
            let title = 'Cập nhật đơn hàng';
            let message = `Đơn hàng #${data.order_code} đã chuyển sang ${data.status_text}`;
            let icon = 'bi-arrow-repeat';
            let color = 'info';
            let toastType = 'info';
            
            // Xử lý riêng cho trường hợp khách hàng hủy đơn
            if (data.new_status === 'cancelled' && data.cancelled_by_customer) {
                title = '⚠️ Khách hàng hủy đơn';
                message = `Khách hàng đã hủy đơn hàng #${data.order_code}`;
                icon = 'bi-exclamation-triangle';
                color = 'warning';
                toastType = 'warning';
            }
            
            const notification = createNotificationElement({
                type: 'status-change',
                title: title,
                message: message,
                amount: formatCurrency(data.total_amount),
                time: 'Vừa xong',
                icon: icon,
                color: color
            });
            
            addNotificationToList(notification);
            
            // Update order page if currently viewing it
            if (window.location.href.includes('/admin/orders/' + data.order_id)) {
                let toastMsg = `Trạng thái: ${data.status_text}`;
                if (data.new_status === 'cancelled' && data.cancelled_by_customer && data.cancellation_reason) {
                    toastMsg += `\nLý do: ${data.cancellation_reason}`;
                }
                showToast(title, toastMsg, toastType);
            } else {
                showToast(title, message, toastType);
            }
        }

        function createNotificationElement(data) {
            return `
                <div class="dropdown-item notification-item" data-type="${data.type}">
                    <i class="bi ${data.icon} me-2 text-${data.color}"></i>
                    <div class="d-flex justify-content-between w-100">
                        <div>
                            <strong>${data.title}</strong><br>
                            <span class="small text-muted">${data.message}</span>
                            ${data.amount ? `<br><span class="badge bg-${data.color}">${data.amount}</span>` : ''}
                        </div>
                        <span class="small text-muted">${data.time}</span>
                    </div>
                </div>
            `;
        }

        function addNotificationToList(notificationHtml) {
            const notificationsList = document.getElementById('notifications-list');
            const noNotifications = document.getElementById('no-notifications');
            
            // Hide "no notifications" message
            if (noNotifications) {
                noNotifications.style.display = 'none';
            }
            
            // Add new notification at the top
            notificationsList.insertAdjacentHTML('afterbegin', notificationHtml);
            
            // Keep only last 10 notifications
            const notifications = notificationsList.querySelectorAll('.notification-item');
            if (notifications.length > 10) {
                notifications[notifications.length - 1].remove();
            }
        }

        function updateNotificationCount() {
            const countElement = document.getElementById('notifications-count');
            const currentCount = parseInt(countElement.textContent) || 0;
            const newCount = currentCount + 1;
            
            countElement.textContent = newCount;
            countElement.style.display = newCount > 0 ? 'inline' : 'none';
        }

        function markAllNotificationsAsRead() {
            const countElement = document.getElementById('notifications-count');
            const notificationsList = document.getElementById('notifications-list');
            const noNotifications = document.getElementById('no-notifications');
            
            // Clear count
            countElement.textContent = '0';
            countElement.style.display = 'none';
            
            // Clear notifications
            notificationsList.innerHTML = '';
            noNotifications.style.display = 'block';
            notificationsList.appendChild(noNotifications);
        }

        function updateDashboardStats(data) {
            // Update dashboard stats if on dashboard page
            if (window.location.pathname.includes('/admin') && window.location.pathname.endsWith('/admin')) {
                // Update stats cards, charts, etc.
                console.log('Updating dashboard stats:', data);
            }
        }

        function showToast(title, message, type = 'info') {
            // Create toast notification
            const toastHtml = `
                <div class="toast align-items-center text-bg-${type} border-0" role="alert" aria-live="assertive" aria-atomic="true">
                    <div class="d-flex">
                        <div class="toast-body">
                            <strong>${title}</strong><br>
                            ${message}
                        </div>
                        <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
                    </div>
                </div>
            `;
            
            // Add to toast container (create if doesn't exist)
            let toastContainer = document.getElementById('toast-container');
            if (!toastContainer) {
                toastContainer = document.createElement('div');
                toastContainer.id = 'toast-container';
                toastContainer.className = 'toast-container position-fixed top-0 end-0 p-3';
                toastContainer.style.zIndex = '1055';
                document.body.appendChild(toastContainer);
            }
            
            toastContainer.insertAdjacentHTML('beforeend', toastHtml);
            
            // Show toast
            const toastElements = toastContainer.querySelectorAll('.toast');
            const latestToast = toastElements[toastElements.length - 1];
            const toast = new bootstrap.Toast(latestToast, { delay: 5000 });
            toast.show();
            
            // Remove from DOM after hidden
            latestToast.addEventListener('hidden.bs.toast', () => {
                latestToast.remove();
            });
        }

        function formatCurrency(amount) {
            return new Intl.NumberFormat('vi-VN', {
                style: 'currency',
                currency: 'VND',
                minimumFractionDigits: 0
            }).format(amount);
        }

        // Cập nhật DOM cho admin orders
        function updateAdminOrdersView(data) {
            const currentPath = window.location.pathname;
            console.log('🔍 Current path:', currentPath);
            console.log('🔍 Order ID:', data.order_id);
            
            // Nếu đang ở trang danh sách đơn hàng
            if (currentPath.includes('/admin/orders') && !currentPath.includes('/admin/orders/')) {
                console.log('📋 Updating orders index view');
                updateOrdersIndexView(data);
            }
            
            // Nếu đang ở trang chi tiết đơn hàng - kiểm tra chính xác hơn
            if (currentPath.includes('/admin/orders/') && currentPath.includes(`/${data.order_id}`)) {
                console.log('📄 Updating order show view');
                updateOrderShowView(data);
            }
        }

        function updateOrdersIndexView(data) {
            // Tìm và cập nhật hàng đơn hàng trong bảng
            const orderRows = document.querySelectorAll('tbody tr');
            orderRows.forEach(row => {
                const orderNumberCell = row.querySelector('td:first-child');
                if (orderNumberCell && orderNumberCell.textContent.includes(data.order_code)) {
                    // Cập nhật badge trạng thái
                    const statusBadge = row.querySelector('.badge');
                    if (statusBadge) {
                        statusBadge.className = `badge bg-${getStatusBadgeClass(data.new_status)}`;
                        statusBadge.textContent = data.status_text;
                    }
                    
                    // Thêm hiệu ứng highlight - màu khác nếu customer hủy đơn
                    if (data.new_status === 'cancelled' && data.cancelled_by_customer) {
                        row.style.backgroundColor = '#fff3cd'; // Màu vàng nhạt cho customer cancel
                        // Thêm icon warning để phân biệt
                        if (!row.querySelector('.customer-cancelled-icon')) {
                            const icon = document.createElement('span');
                            icon.className = 'customer-cancelled-icon text-warning ms-1';
                            icon.innerHTML = '⚠️';
                            icon.title = 'Hủy bởi khách hàng';
                            statusBadge.parentNode.appendChild(icon);
                        }
                    } else {
                        row.style.backgroundColor = '#fff3cd';
                    }
                    
                    setTimeout(() => {
                        row.style.backgroundColor = '';
                    }, 5000); // Tăng thời gian để nhận thấy rõ hơn
                }
            });
        }

        function updateOrderShowView(data) {
            // Cập nhật badge trạng thái trong trang chi tiết
            const statusBadges = document.querySelectorAll('.badge');
            statusBadges.forEach(badge => {
                if (badge.textContent.includes(data.old_status)) {
                    badge.className = `badge bg-${getStatusBadgeClass(data.new_status)} fs-6`;
                    badge.textContent = data.status_text;
                }
            });
            
            // Cập nhật dropdown actions dựa trên trạng thái mới
            updateStatusDropdown(data.new_status);
            
            // Thêm vào lịch sử trạng thái nếu có
            addToStatusHistory(data);
            
            // Hiển thị thông tin hủy đơn nếu customer hủy  
            console.log('🔍 Checking cancellation condition:', {
                is_cancelled: data.new_status === 'cancelled',
                cancelled_by_customer: data.cancelled_by_customer,
                cancelled_by: data.cancelled_by,
                user_id_from_order: data.order?.user_id
            });
            
            if (data.new_status === 'cancelled' && data.cancelled_by_customer) {
                console.log('🚨 Customer cancelled order detected');
                console.log('🔍 Current URL:', window.location.href);
                console.log('🔍 Order ID:', data.order_id);
                
                addCustomerCancellationInfo(data);
                
                // Hiển thị thông báo sắp refresh
                showToast(
                    '🔄 Đang cập nhật trang', 
                    'Trang sẽ được làm mới sau 2 giây để hiển thị thông tin hủy đơn đầy đủ...', 
                    'info'
                );
                
                console.log('⏰ Setting timeout for page refresh...');
                
                // Refresh trang sau 2 giây để hiển thị đầy đủ thông tin hủy đơn
                setTimeout(() => {
                    console.log('🔄 Refreshing page now...');
                    window.location.reload();
                }, 2000);
            } else if (data.new_status === 'cancelled') {
                // Workaround: Refresh cho tất cả cancellation từ trang show
                console.log('🔄 Order cancelled - refreshing anyway for show page');
                showToast(
                    '🔄 Đơn hàng đã hủy', 
                    'Trang sẽ được làm mới để hiển thị thông tin mới nhất...', 
                    'info'
                );
                
                setTimeout(() => {
                    console.log('🔄 Refreshing page (workaround)...');
                    window.location.reload();
                }, 2000);
            }
        }

        function addCustomerCancellationInfo(data) {
            // Tìm vùng hiển thị thông tin thanh toán để thêm thông tin hủy
            const paymentInfoCard = document.querySelector('.card-body');
            if (!paymentInfoCard) return;
            
            // Kiểm tra xem thông tin hủy đã có chưa
            if (paymentInfoCard.querySelector('.customer-cancellation-info')) return;
            
            const cancellationDiv = document.createElement('div');
            cancellationDiv.className = 'customer-cancellation-info mt-4 p-3 border border-warning rounded';
            cancellationDiv.innerHTML = `
                <h6 class="mb-2 text-warning"><i class="fas fa-exclamation-triangle me-2"></i>Thông tin hủy đơn hàng:</h6>
                <div class="mb-2">
                    <strong>Người hủy:</strong> Khách hàng (${data.customer_name})
                </div>
                <div class="mb-2">
                    <strong>Thời gian hủy:</strong> ${new Date(data.cancelled_at).toLocaleString('vi-VN')}
                </div>
                <div class="mb-2">
                    <strong>Lý do hủy:</strong> ${data.cancellation_reason || 'Không có lý do cụ thể'}
                </div>
            `;
            
            // Thêm vào cuối card body
            paymentInfoCard.appendChild(cancellationDiv);
        }

        function getStatusBadgeClass(status) {
            const statusClasses = {
                'pending': 'warning',
                'confirmed': 'info',
                'processing': 'primary', 
                'shipped': 'info',
                'delivered': 'success',
                'cancelled': 'danger',
                'refunded': 'secondary'
            };
            return statusClasses[status] || 'secondary';
        }

        function updateStatusDropdown(newStatus) {
            const dropdown = document.querySelector('.dropdown-menu');
            if (!dropdown) return;
            
            // Xóa các option cũ
            dropdown.innerHTML = '';
            
            // Thêm option mới dựa trên trạng thái
            const nextActions = getNextStatusActions(newStatus);
            nextActions.forEach(action => {
                const li = document.createElement('li');
                li.innerHTML = `<a class="dropdown-item" href="#" onclick="${action.onclick}">${action.text}</a>`;
                dropdown.appendChild(li);
            });
        }

        function getNextStatusActions(currentStatus) {
            const actions = {
                'pending': [
                    { text: 'Đang xử lý', onclick: "updateOrderStatus('processing')" },
                    { text: 'Hủy đơn hàng', onclick: 'showCancelModal()' }
                ],
                'processing': [
                    { text: 'Đã gửi', onclick: "updateOrderStatus('shipped')" },
                    { text: 'Hủy đơn hàng', onclick: 'showCancelModal()' }
                ],
                'shipped': [
                    { text: 'Đã giao', onclick: "updateOrderStatus('delivered')" }
                ],
                'delivered': [
                    { text: 'Hoàn tiền', onclick: 'showRefundModal()' }
                ],
                'cancelled': [],
                'refunded': []
            };
            return actions[currentStatus] || [];
        }

        function addToStatusHistory(data) {
            const timeline = document.querySelector('.timeline');
            if (!timeline) return;
            
            // Tạo item lịch sử mới
            const timelineItem = document.createElement('div');
            timelineItem.className = 'timeline-item';
            timelineItem.innerHTML = `
                <div class="timeline-marker"></div>
                <div class="timeline-content">
                    <h6 class="mb-1">${data.status_text}</h6>
                    <p class="mb-1">Cập nhật từ ${data.old_status} sang ${data.new_status}</p>
                    <small class="text-muted">${new Date().toLocaleString('vi-VN')}</small>
                </div>
            `;
            
            // Thêm vào đầu timeline
            timeline.insertBefore(timelineItem, timeline.firstChild);
        }

        // Thêm đơn hàng mới vào danh sách
        function addNewOrderToList(data) {
            const currentPath = window.location.pathname;
            
            // Chỉ thêm nếu đang ở trang danh sách đơn hàng
            if (!currentPath.includes('/admin/orders') || currentPath.includes('/admin/orders/')) {
                return;
            }
            
            // Tìm tbody của bảng đơn hàng
            const orderTable = document.querySelector('table tbody');
            if (!orderTable) return;
            
            // Tạo hàng mới cho đơn hàng
            const newRow = createNewOrderRow(data);
            
            // Thêm vào đầu bảng
            orderTable.insertBefore(newRow, orderTable.firstChild);
            
            // Thêm hiệu ứng highlight (màu xanh lá cho đơn mới)
            newRow.style.backgroundColor = '#d4edda';
            newRow.style.transition = 'background-color 0.5s ease';
            
            // Hiệu ứng "slide down"
            newRow.style.opacity = '0';
            newRow.style.transform = 'translateY(-20px)';
            newRow.style.transition = 'all 0.5s ease';
            setTimeout(() => {
                newRow.style.opacity = '1';
                newRow.style.transform = 'translateY(0)';
            }, 100);
            
            // Về màu bình thường sau 5 giây
            setTimeout(() => {
                newRow.style.backgroundColor = '';
            }, 5000);
            
            // Xóa class "new-order-row" sau 5 giây để ẩn label "MỚI"
            setTimeout(() => {
                newRow.classList.remove('new-order-row');
            }, 5000);
            
            // Cập nhật số lượng đơn hàng trong header
            updateOrderCount();
            
            console.log('✅ Added new order to list:', data.order_code);
        }

        function createNewOrderRow(data) {
            const row = document.createElement('tr');
            
            // Format số tiền
            const totalAmount = parseInt(data.total_amount || 0);
            const formattedAmount = new Intl.NumberFormat('vi-VN').format(totalAmount);
            
            // Format thời gian
            const createdAt = new Date().toLocaleString('vi-VN', {
                day: '2-digit',
                month: '2-digit', 
                year: 'numeric',
                hour: '2-digit',
                minute: '2-digit'
            });
            
            row.innerHTML = `
                <td>${data.order_code}</td>
                <td>
                    <div class="d-flex align-items-start">
                        <div>
                            <h6 class="mb-1">${data.customer_name || 'Không có tên'}</h6>
                            <small class="text-muted">${data.customer_email || 'Không có email'}<br></small>
                            <small class="text-muted">${data.customer_phone || 'Không có số điện thoại'}</small>
                        </div>
                    </div>
                </td>
                <td>
                    <strong>${formattedAmount}đ</strong>
                </td>
                <td>
                    <span class="badge bg-warning">Chờ xử lý</span>
                </td>
                <td>
                    <span class="badge bg-warning">Chưa thanh toán</span>
                </td>
                <td>${createdAt}</td>
                <td class="text-center">
                    <div class="btn-group">
                        <a href="/admin/orders/${data.order_id}" 
                           class="btn btn-sm btn-info" title="Xem chi tiết">
                            <i class="fas fa-eye"></i>
                        </a>
                        <button type="button" 
                                class="btn btn-sm btn-primary" 
                                title="Chỉnh sửa"
                                onclick="showEditModal(${data.order_id})">
                            <i class="fas fa-edit"></i>
                        </button>
                    </div>
                </td>
            `;
            
            // Thêm class để phân biệt đơn hàng mới
            row.classList.add('new-order-row');
            row.setAttribute('data-order-id', data.order_id);
            
            return row;
        }

        function updateOrderCount() {
            // Cập nhật số lượng đơn hàng trong header nếu có
            const orderCountElement = document.querySelector('.card-header h6');
            if (orderCountElement && orderCountElement.textContent.includes('Danh sách đơn hàng')) {
                const currentText = orderCountElement.textContent;
                const match = currentText.match(/\((\d+) đơn hàng\)/);
                if (match) {
                    const currentCount = parseInt(match[1]);
                    const newCount = currentCount + 1;
                    orderCountElement.textContent = currentText.replace(/\(\d+ đơn hàng\)/, `(${newCount} đơn hàng)`);
                }
            }
        }

        function checkForNewNotifications() {
            // Fallback polling method
            fetch('/api/admin/notifications', {
                method: 'GET',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.notifications && data.notifications.length > 0) {
                    data.notifications.forEach(notification => {
                        if (notification.type === 'new_order') {
                            showNewOrderNotification(notification);
                        } else if (notification.type === 'status_changed') {
                            showOrderStatusNotification(notification);
                        }
                        updateNotificationCount();
                    });
                }
            })
            .catch(error => {
                console.error('Error checking notifications:', error);
            });
        }
    </script>

   @stack('scripts')

 </body>
 <!--end::Body-->
</html>