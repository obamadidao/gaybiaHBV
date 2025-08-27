<!DOCTYPE html>
<html class="no-js" lang="en">

<!-- Mirrored from www.annimexweb.com/items/hema/index5-tools-parts.html by HTTrack Website Copier/3.x [XR&CO'2014], Sun, 22 Jun 2025 15:17:43 GMT -->

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="description" content="description">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="reverb-app-key" content="{{ env('REVERB_APP_KEY') }}">
    <meta name="reverb-host" content="{{ env('REVERB_HOST', 'localhost') }}">
    <meta name="reverb-port" content="{{ env('REVERB_PORT', '8080') }}">
    <meta name="reverb-scheme" content="{{ env('REVERB_SCHEME', 'http') }}">
    <!-- Title Of Site -->
    <title>HBV Billiards</title>
    <!-- Favicon -->
    <link rel="shortcut icon" href="{{ asset('assets/images/favicon.png') }}" />
    <!-- Plugins CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/plugins.css') }}">
    <!-- Main Style CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/style-min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/responsive.css') }}">

    <!-- Custom Cart Styles -->
    <link rel="stylesheet" href="{{ asset('assets/css/cart.css') }}">

    <!-- Custom Notification Styles -->
    <style>
        .notifications-parent {
            position: relative;
            display: inline-block;
        }

        .notifications-link {
            cursor: pointer;
            position: relative;
        }

        .notification-count {
            position: absolute;
            top: -5px;
            right: -8px;
            background: #ff4757;
            color: white;
            border-radius: 50%;
            width: 18px;
            height: 18px;
            font-size: 11px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
        }

        #notificationsBox {
            position: absolute;
            top: 100%;
            right: 0;
            width: 320px;
            background: white;
            border: 1px solid #ddd;
            border-radius: 8px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            z-index: 1000;
            margin-top: 10px;
        }

        .notification-content {
            max-height: 400px;
            overflow-y: auto;
        }

        .notification-header {
            padding: 15px;
            border-bottom: 1px solid #eee;
            background: #f8f9fa;
            border-radius: 8px 8px 0 0;
        }

        .notification-header h6 {
            margin: 0;
            font-weight: 600;
            color: #333;
        }

        .notification-list {
            padding: 10px 0;
        }

        .notification-item {
            padding: 12px 15px;
            border-bottom: 1px solid #f0f0f0;
            transition: background-color 0.2s;
        }

        .notification-item:hover {
            background-color: #f8f9fa;
        }

        .notification-item:last-child {
            border-bottom: none;
        }

        .no-notifications {
            padding: 20px;
            color: #999;
        }

        .client-toast {
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 9999;
            min-width: 300px;
            background: white;
            border: 1px solid #ddd;
            border-radius: 8px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            padding: 15px;
            margin-bottom: 10px;
            animation: slideInRight 0.3s ease;
        }

        @keyframes slideInRight {
            from {
                transform: translateX(100%);
                opacity: 0;
            }

            to {
                transform: translateX(0);
                opacity: 1;
            }
        }

        .client-toast.success {
            border-left: 4px solid #2ed573;
        }

        .client-toast.info {
            border-left: 4px solid #3742fa;
        }

        .client-toast.warning {
            border-left: 4px solid #ffa502;
        }

        .client-toast-close {
            float: right;
            cursor: pointer;
            color: #999;
            font-weight: bold;
        }
    </style>
</head>

<body class="template-index index-demo5">
    <!--Page Wrapper-->
    <div class="page-wrapper">
        <!--Header-->
        @include('layouts.client.blocks.header')
        <!--End Header-->
        <!--Mobile Menu-->
        @include('layouts.client.blocks.navMobile')
        <!--End Mobile Menu-->

        <!-- Flash Messages -->
        @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show m-3" role="alert">
            <strong>Thành công!</strong> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @endif

        @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show m-3" role="alert">
            <strong>Lỗi!</strong> {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @endif

        @if (session('warning'))
        <div class="alert alert-warning alert-dismissible fade show m-3" role="alert">
            <strong>Cảnh báo!</strong> {{ session('warning') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @endif

        @if (session('info'))
        <div class="alert alert-info alert-dismissible fade show m-3" role="alert">
            <strong>Thông tin!</strong> {{ session('info') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @endif

        <!-- Body Container -->
        @yield('content')
        <!-- End Body Container -->

        <!--Footer-->
        @include('layouts.client.blocks.footer')
        <!--End Footer-->

        <!--Scoll Top-->
        <div id="site-scroll"><i class="icon anm anm-arw-up"></i></div>
        <!--End Scoll Top-->

        <!--MiniCart Drawer-->
        @include('layouts.client.blocks.miniCart')
        <!--End MiniCart Drawer-->

        <!-- Including Jquery/Javascript -->
        <!-- Laravel Echo and Pusher CDN -->
        <script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>
        <script src="https://unpkg.com/laravel-echo@1.15.3/dist/echo.iife.js"></script>

        <!-- Echo Realtime Setup -->
        <script src="{{ asset('assets/js/echo-realtime.js') }}"></script>

        <!-- Plugins JS -->
        <script src="{{ asset('assets/js/plugins.js') }}"></script>


        <script src="{{ asset('assets/js/vendor/jquery.elevatezoom.js') }}"></script>
        <script>
            $(document).ready(function() {
                /* Product Zoom */
                function product_zoom() {
                    $(".zoompro").elevateZoom({
                        gallery: "gallery",
                        galleryActiveClass: "active",
                        zoomWindowWidth: 300,
                        zoomWindowHeight: 100,
                        scrollZoom: false,
                        zoomType: "inner",
                        cursor: "crosshair"
                    });
                }
                product_zoom();
            });
        </script>

        <!-- Main JS -->
        <script src="{{ asset('assets/js/main.js') }}"></script>

        <!-- Cart JS -->
        <script src="{{ asset('assets/js/cart.js') }}"></script>

        <!-- Cart Sync JS -->
        <script src="{{ asset('assets/js/cart-sync.js') }}"></script>

        <!-- Client Realtime Notifications -->
        <script>
            // Global notification toggle function
            function toggleNotifications() {
                const notificationsBox = document.getElementById('notificationsBox');
                const isVisible = notificationsBox.style.display !== 'none';
                notificationsBox.style.display = isVisible ? 'none' : 'block';

                // Close when clicking outside
                if (!isVisible) {
                    document.addEventListener('click', closeNotificationsOnClickOutside);
                }
            }

            function closeNotificationsOnClickOutside(event) {
                const notificationsParent = document.querySelector('.notifications-parent');
                if (!notificationsParent.contains(event.target)) {
                    document.getElementById('notificationsBox').style.display = 'none';
                    document.removeEventListener('click', closeNotificationsOnClickOutside);
                }
            }

            document.addEventListener('DOMContentLoaded', function() {
                // Check if user is logged in
                @auth
                // Wait for Echo to be initialized before setting up notifications
                setTimeout(() => {
                    initClientNotifications();
                }, 5000); // Wait 5 seconds for Echo to be ready
                @endauth
            });

            function initClientNotifications() {
                const userId = {
                    {
                        Auth::id() ?? 'null'
                    }
                };

                if (!userId) return;

                console.log('🔔 Setting up client notifications for user:', userId);
                console.log('🔍 Echo object:', window.Echo);
                console.log('🔍 Echo connector:', window.Echo?.connector);

                // Check if Echo is available
                if (typeof window.Echo !== 'undefined' && window.Echo !== null && window.Echo.connector) {
                    console.log('🚀 Echo is available, setting up listeners...');

                    // Listen for order status changes for this user with error handling
                    console.log(`🎯 Subscribing to channel: user-orders.${userId}`);
                    try {
                        window.Echo.private(`user-orders.${userId}`)
                            .listen('.order.status.changed', (data) => {
                                console.log('📨 Order status changed event received:', data);
                                showClientOrderStatusNotification(data);
                                updateClientNotificationCount();

                                // Cập nhật DOM nếu đang ở trang tương ứng
                                updateClientOrdersView(data);
                            })
                            .error((error) => {
                                console.error('❌ Error on user-orders channel:', error);
                            });

                        console.log('✅ Successfully subscribed to user-orders channel');
                    } catch (error) {
                        console.error('❌ Error subscribing to user-orders channel:', error);
                    }

                    // Listen for specific order updates (when viewing order page)
                    const currentOrderId = getCurrentOrderId();
                    if (currentOrderId) {
                        try {
                            window.Echo.private(`order.${currentOrderId}`)
                                .listen('.order.status.changed', (data) => {
                                    console.log('Current order updated:', data);
                                    updateCurrentOrderStatus(data);
                                })
                                .error((error) => {
                                    console.error('❌ Error on specific order channel:', error);
                                });

                            console.log(`✅ Successfully subscribed to order.${currentOrderId} channel`);
                        } catch (error) {
                            console.error('❌ Error subscribing to specific order channel:', error);
                        }
                    }
                } else {
                    console.warn('❌ Echo not available for client notifications.');
                    console.log('🔍 Checking Echo availability...');
                    console.log('window.Echo:', typeof window.Echo);
                    console.log('window.Echo object:', window.Echo);

                    // Polling disabled - focus on realtime only
                    console.log('🚫 Polling disabled. Working on WebSocket connection...');
                }
            }

            function getCurrentOrderId() {
                // Extract order ID from URL if on order success page
                const urlPath = window.location.pathname;
                const orderSuccessMatch = urlPath.match(/\/order\/success\/(\d+)/);
                return orderSuccessMatch ? orderSuccessMatch[1] : null;
            }

            function showClientOrderStatusNotification(data) {
                const notification = createClientNotificationElement({
                    type: 'order-status',
                    title: 'Cập nhật đơn hàng',
                    message: `Đơn hàng #${data.order_code} đã chuyển sang trạng thái: ${data.status_text}`,
                    time: 'Vừa xong',
                    orderId: data.order_id
                });

                addClientNotificationToList(notification);
                showClientToast('Đơn hàng đã cập nhật', `#${data.order_code}: ${data.status_text}`, getStatusToastType(data.new_status));
            }

            function createClientNotificationElement(data) {
                const statusColor = getStatusColor(data.type);
                return `
                        <div class="notification-item" data-type="${data.type}" data-order-id="${data.orderId}">
                            <div class="d-flex justify-content-between">
                                <div class="flex-grow-1">
                                    <div class="notification-title fw-bold">${data.title}</div>
                                    <div class="notification-message text-muted small">${data.message}</div>
                                </div>
                                <div class="notification-time text-muted small">${data.time}</div>
                            </div>
                        </div>
                    `;
            }

            function addClientNotificationToList(notificationHtml) {
                const notificationsList = document.getElementById('client-notifications-list');
                const noNotifications = notificationsList.querySelector('.no-notifications');

                // Hide "no notifications" message
                if (noNotifications) {
                    noNotifications.style.display = 'none';
                }

                // Add new notification at the top
                notificationsList.insertAdjacentHTML('afterbegin', notificationHtml);

                // Keep only last 5 notifications
                const notifications = notificationsList.querySelectorAll('.notification-item');
                if (notifications.length > 5) {
                    notifications[notifications.length - 1].remove();
                }
            }

            function updateClientNotificationCount() {
                const countElement = document.getElementById('client-notifications-count');
                if (countElement) {
                    const currentCount = parseInt(countElement.textContent) || 0;
                    const newCount = currentCount + 1;

                    countElement.textContent = newCount;
                    countElement.style.display = newCount > 0 ? 'flex' : 'none';
                }
            }

            function updateCurrentOrderStatus(data) {
                // Update order status on current page if viewing order details
                const statusElements = document.querySelectorAll('.order-status, .status-badge, [data-order-status]');
                statusElements.forEach(element => {
                    element.textContent = data.status_text;
                    element.className = element.className.replace(/status-\w+/, `status-${data.new_status}`);
                });

                showClientToast('Trạng thái đã cập nhật', `Đơn hàng của bạn hiện tại: ${data.status_text}`, getStatusToastType(data.new_status));
            }

            function showClientToast(title, message, type = 'info') {
                const toastId = 'toast-' + Date.now();
                const toastHtml = `
                        <div class="client-toast ${type}" id="${toastId}">
                            <div class="client-toast-close" onclick="removeClientToast('${toastId}')">&times;</div>
                            <div class="client-toast-title fw-bold">${title}</div>
                            <div class="client-toast-message">${message}</div>
                        </div>
                    `;

                document.body.insertAdjacentHTML('beforeend', toastHtml);

                // Auto remove after 5 seconds
                setTimeout(() => {
                    removeClientToast(toastId);
                }, 5000);
            }

            function removeClientToast(toastId) {
                const toast = document.getElementById(toastId);
                if (toast) {
                    toast.style.animation = 'slideOutRight 0.3s ease';
                    setTimeout(() => {
                        if (toast.parentNode) {
                            toast.parentNode.removeChild(toast);
                        }
                    }, 300);
                }
            }

            function getStatusColor(status) {
                const colors = {
                    'pending': 'warning',
                    'confirmed': 'info',
                    'processing': 'primary',
                    'shipped': 'info',
                    'delivered': 'success',
                    'cancelled': 'danger',
                    'refunded': 'secondary'
                };
                return colors[status] || 'info';
            }

            function getStatusToastType(status) {
                const types = {
                    'delivered': 'success',
                    'cancelled': 'warning',
                    'refunded': 'warning'
                };
                return types[status] || 'info';
            }

            let lastCheckTime = localStorage.getItem('lastOrderCheckTime') || new Date().toISOString();

            function checkForOrderUpdates() {
                // Fallback polling method for order updates
                fetch(`/api/user/order-updates?since=${encodeURIComponent(lastCheckTime)}`, {
                        method: 'GET',
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.updates && data.updates.length > 0) {
                            console.log(`📊 Polling found ${data.updates.length} new updates`);
                            data.updates.forEach(update => {
                                showClientOrderStatusNotification(update);
                                updateClientNotificationCount();
                            });

                            // Update last check time
                            lastCheckTime = new Date().toISOString();
                            localStorage.setItem('lastOrderCheckTime', lastCheckTime);
                        }
                    })
                    .catch(error => {
                        console.error('Error checking order updates:', error);
                    });
            }

            // CSS for slide out animation
            const style = document.createElement('style');
            style.textContent = `
                    @keyframes slideOutRight {
                        from { transform: translateX(0); opacity: 1; }
                        to { transform: translateX(100%); opacity: 0; }
                    }
                `;
            document.head.appendChild(style);

            // Global functions for debugging
            window.checkClientEcho = function() {
                const userId = {
                    {
                        Auth::id() ?? 'null'
                    }
                };
                console.log('📊 Client Echo Status:', {
                    Echo: typeof window.Echo,
                    Connector: window.Echo?.connector ? 'available' : 'undefined',
                    Connected: window.Echo?.connector?.pusher?.connection?.state || 'unknown',
                    UserId: userId,
                    Channels: window.Echo?.connector?.channels || 'none'
                });
            };

            window.testClientNotifications = function() {
                const userId = {
                    {
                        Auth::id() ?? 'null'
                    }
                };
                if (!userId) {
                    console.error('❌ No user logged in');
                    return;
                }

                console.log('🧪 Testing client notifications...');
                showClientOrderStatusNotification({
                    order_id: 123,
                    order_code: 'TEST-123',
                    new_status: 'shipped',
                    status_text: 'Đang giao hàng'
                });
            };

            // Cập nhật DOM cho client orders
            function updateClientOrdersView(data) {
                const currentPath = window.location.pathname;

                // Nếu đang ở trang profile với tab orders
                if (currentPath.includes('/profile-user')) {
                    updateProfileOrdersView(data);
                }

                // Nếu đang ở trang order success
                if (currentPath.includes(`/order/success/${data.order_id}`)) {
                    updateOrderSuccessView(data);
                }
            }

            function updateProfileOrdersView(data) {
                // Tìm và cập nhật hàng đơn hàng trong bảng
                const orderTable = document.getElementById('orderTable');
                if (!orderTable) return;

                // Cập nhật badge trạng thái đơn hàng bằng ID cụ thể
                const statusBadge = document.getElementById(`order-status-${data.order_id}`);
                if (statusBadge) {
                    statusBadge.className = `badge bg-${getClientStatusBadgeClass(data.new_status)}`;
                    statusBadge.textContent = getStatusTextInVietnamese(data.new_status);
                }

                // Thêm hiệu ứng highlight cho row
                const orderRow = document.getElementById(`order-row-${data.order_id}`);
                if (orderRow) {
                    orderRow.style.backgroundColor = '#e7f3ff';
                    setTimeout(() => {
                        orderRow.style.backgroundColor = '';
                    }, 3000);

                    // Nếu đơn hàng bị hủy, thêm class để làm mờ
                    if (data.new_status === 'cancelled') {
                        orderRow.classList.add('table-danger');
                    }
                }

                // Cập nhật modal chi tiết đơn hàng nếu đang mở
                if (typeof window.updateProfileOrderDetail === 'function') {
                    window.updateProfileOrderDetail(data);
                }
            }

            function updateOrderSuccessView(data) {
                // Cập nhật trạng thái đơn hàng trong trang success
                const statusElements = document.querySelectorAll('.order-status, .status-badge, [data-order-status]');
                statusElements.forEach(element => {
                    if (element.textContent.includes(data.old_status)) {
                        element.textContent = data.status_text;
                        element.className = element.className.replace(/bg-\w+/, `bg-${getClientStatusBadgeClass(data.new_status)}`);
                    }
                });
            }

            function getClientStatusBadgeClass(status) {
                const statusClasses = {
                    'pending': 'warning',
                    'confirmed': 'info',
                    'processing': 'info',
                    'shipped': 'primary',
                    'delivered': 'success',
                    'cancelled': 'danger',
                    'refunded': 'secondary'
                };
                return statusClasses[status] || 'secondary';
            }

            function getStatusTextInVietnamese(status) {
                const statusTexts = {
                    'pending': 'Chờ xử lý',
                    'confirmed': 'Đã xác nhận',
                    'processing': 'Đang xử lý',
                    'shipped': 'Đã gửi hàng',
                    'delivered': 'Đã giao hàng',
                    'cancelled': 'Đã hủy',
                    'refunded': 'Đã hoàn tiền'
                };
                return statusTexts[status] || status;
            }
        </script>

        @stack('script')

    </div>
    <!--End Page Wrapper-->

    <!-- Search Drawer for Mobile -->
    <div class="offcanvas offcanvas-top" tabindex="-1" id="search-drawer">
        <div class="offcanvas-header">
            <h5 class="offcanvas-title">Tìm kiếm sản phẩm</h5>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body">
            <form action="{{ route('client.search') }}" method="get" class="d-flex">
                <input type="text" name="query" class="form-control me-2" placeholder="Nhập từ khóa tìm kiếm..." value="{{ request('query') }}" required>
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-search"></i> Tìm
                </button>
            </form>
            @if(request('query'))
            <div class="mt-3">
                <small class="text-muted">Từ khóa gần đây: <strong>{{ request('query') }}</strong></small>
            </div>
            @endif
        </div>
    </div>
    <!-- End Search Drawer -->
</body>

<!-- Mirrored from www.annimexweb.com/items/hema/index5-tools-parts.html by HTTrack Website Copier/3.x [XR&CO'2014], Sun, 22 Jun 2025 15:18:29 GMT -->

</html>