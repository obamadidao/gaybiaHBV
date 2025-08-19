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

class NewOrderCreated implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $order;

    /**
     * Create a new event instance.
     */
    public function __construct(Order $order)
    {
        $this->order = $order;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        return [
            // Channel cho admin để nhận thông báo đơn hàng mới
            new PrivateChannel('admin-orders'),
            // Channel cho stats real-time
            new PrivateChannel('admin-stats'),
        ];
    }

    /**
     * Data to broadcast
     */
    public function broadcastWith(): array
    {
        return [
            'order_id' => $this->order->id,
            'order_code' => $this->order->order_number, // Fix: order_code -> order_number
            'customer_name' => $this->order->user->name ?? $this->order->customer->full_name ?? 'Guest', // Fix: lấy tên từ relationship
            'customer_email' => $this->order->user->email ?? $this->order->customer->user->email ?? '',
            'customer_phone' => $this->order->customer->phone ?? $this->order->shipping_address['phone'] ?? '',
            'total_amount' => $this->order->total_amount,
            'status' => $this->order->status,
            'payment_method' => $this->order->payment_method,
            'created_at' => $this->order->created_at->toISOString(),
            'status_text' => $this->getStatusText($this->order->status),
        ];
    }

    /**
     * Event name for broadcasting
     */
    public function broadcastAs(): string
    {
        return 'order.new';
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