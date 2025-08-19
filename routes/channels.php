<?php

use Illuminate\Support\Facades\Broadcast;
use App\Models\User;

/*
|--------------------------------------------------------------------------
| Broadcast Channels
|--------------------------------------------------------------------------
|
| Here you may register all of the event broadcasting channels that your
| application supports. The given channel authorization callbacks are
| used to check if an authenticated user can listen to the channel.
|
*/

// Channel cho admin để nhận thông báo về đơn hàng mới
Broadcast::channel('admin-orders', function (User $user) {
    return $user->hasRole('admin');
});

// Channel cho user cụ thể để nhận cập nhật trạng thái đơn hàng của họ
Broadcast::channel('user-orders.{userId}', function (User $user, $userId) {
    return (int) $user->id === (int) $userId;
});

// Channel cho đơn hàng cụ thể (có thể cả admin và customer đều nghe)
Broadcast::channel('order.{orderId}', function (User $user, $orderId) {
    // Admin có thể nghe tất cả đơn hàng
    if ($user->hasRole('admin')) {
        return true;
    }
    
    // User chỉ có thể nghe đơn hàng của mình
    return $user->orders()->where('id', $orderId)->exists();
});

// Public channel cho thống kê real-time (chỉ admin)
Broadcast::channel('admin-stats', function (User $user) {
    return $user->hasRole('admin');
});
