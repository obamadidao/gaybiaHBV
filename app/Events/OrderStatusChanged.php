<?php

namespace App\Events;

use App\Models\Order;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class OrderStatusChanged implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $order;
    public $oldStatus;
    public $newStatus;

    /**
     * Create a new event instance.
     */
    public function __construct(Order $order, string $oldStatus, string $newStatus)
    {
        $this->order = $order;
        $this->oldStatus = $oldStatus;
        $this->newStatus = $newStatus;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        return [
            // Channel cho admin
            new PrivateChannel('admin-orders'),
            // Channel cho user cụ thể
            new PrivateChannel('user-orders.' . $this->order->user_id),
            // Channel cho đơn hàng cụ thể
            new PrivateChannel('order.' . $this->order->id),
        ];
    }

    /**
     * Data to broadcast
     */
    public function broadcastWith(): array
    {
        $data = [
            'order_id' => $this->order->id,
            'order_code' => $this->order->order_number,
            'customer_name' => $this->order->user->name ?? $this->order->customer->full_name ?? 'Guest',
            'customer_email' => $this->order->user->email ?? $this->order->customer->user->email ?? '',
            'total_amount' => $this->order->total_amount,
            'old_status' => $this->oldStatus,
            'new_status' => $this->newStatus,
            'updated_at' => $this->order->updated_at->toISOString(),
            'status_text' => $this->getStatusText($this->newStatus),
        ];

        // Thêm thông tin hủy đơn nếu trạng thái là cancelled
        if ($this->newStatus === 'cancelled') {
            $data['cancellation_reason'] = $this->order->cancellation_reason;
            $data['cancelled_by'] = $this->order->cancelled_by;
            $data['cancelled_at'] = $this->order->cancelled_at ? $this->order->cancelled_at->toISOString() : null;
            $data['cancelled_by_customer'] = $this->order->cancelled_by === $this->order->user_id;
        }

        // Thêm thông tin hoàn tiền nếu trạng thái là refunded
        if ($this->newStatus === 'refunded') {
            $data['refund_reason'] = $this->order->refund_reason;
            $data['refund_amount'] = $this->order->refund_amount;
            $data['refunded_by'] = $this->order->refunded_by;
            $data['refunded_at'] = $this->order->refunded_at ? $this->order->refunded_at->toISOString() : null;
        }

        return $data;
    }

    /**
     * Event name for broadcasting
     */
    public function broadcastAs(): string
    {
        return 'order.status.changed';
    }

    /**
     * Get status text in Vietnamese
     */
    private function getStatusText(string $status): string
    {
        return match($status) {
            'pending' => 'Chờ xử lý',
            'confirmed' => 'Đã xác nhận',
            'processing' => 'Đang xử lý',
            'shipped' => 'Đang giao hàng',
            'delivered' => 'Đã giao hàng',
            'cancelled' => 'Đã hủy',
            'refunded' => 'Đã hoàn tiền',
            default => 'Không xác định'
        };
    }
}