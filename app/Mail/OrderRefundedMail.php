<?php

namespace App\Mail;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class OrderRefundedMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $order;
    public $refundAmount;
    public $reason;

    /**
     * Create a new message instance.
     */
    public function __construct(Order $order, $refundAmount = null, $reason = null)
    {
        $this->order = $order;
        $this->refundAmount = $refundAmount ?: $order->refund_amount;
        $this->reason = $reason ?: $order->refund_reason;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Thông báo hoàn tiền đơn hàng - ' . $this->order->order_number,
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.order-refunded',
            with: [
                'order' => $this->order,
                'customer' => $this->order->user,
                'items' => $this->order->orderItems,
                'refundAmount' => $this->refundAmount,
                'reason' => $this->reason
            ]
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}