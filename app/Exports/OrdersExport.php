<?php

namespace App\Exports;

use App\Models\Order;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class OrdersExport implements FromCollection, WithHeadings, WithMapping, WithStyles
{
    protected $orders;

    public function __construct($orders)
    {
        $this->orders = $orders;
    }

    public function collection()
    {
        return $this->orders;
    }

    public function headings(): array
    {
        return [
            'Mã đơn hàng',
            'Ngày đặt',
            'Khách hàng',
            'Email',
            'Số điện thoại',
            'Địa chỉ',
            'Tổng tiền',
            'Phí vận chuyển',
            'Giảm giá',
            'Thành tiền',
            'Trạng thái',
            'Trạng thái thanh toán',
            'Phương thức thanh toán',
            'Ghi chú'
        ];
    }

    public function map($order): array
    {
        return [
            $order->order_number,
            $order->created_at->format('d/m/Y H:i'),
            $order->shipping_address['name'],
            $order->user->email,
            $order->shipping_address['phone'],
            $this->formatAddress($order->shipping_address),
            number_format($order->subtotal) . ' đ',
            number_format($order->shipping_fee) . ' đ',
            number_format($order->discount_amount) . ' đ',
            number_format($order->total_amount) . ' đ',
            $order->status_text,
            $order->payment_status_text,
            $order->payment_method_text,
            $order->admin_notes
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true]],
        ];
    }

    protected function formatAddress($address)
    {
        return sprintf(
            '%s, %s, %s, %s',
            $address['address'],
            $address['ward'],
            $address['district'],
            $address['city']
        );
    }
} 