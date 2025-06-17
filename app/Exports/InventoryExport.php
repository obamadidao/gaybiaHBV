<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class InventoryExport implements FromCollection, WithHeadings, WithMapping, WithStyles
{
    protected $variants;

    public function __construct($variants)
    {
        $this->variants = $variants;
    }

    public function collection()
    {
        return $this->variants;
    }

    public function headings(): array
    {
        return [
            'Mã SKU',
            'Tên sản phẩm',
            'Loại biến thể',
            'Tên biến thể',
            'Giá trị biến thể',
            'Tồn kho',
            'Giá điều chỉnh',
            'Giá cuối cùng',
            'Trạng thái',
        ];
    }

    public function map($variant): array
    {
        return [
            $variant->sku,
            $variant->product->name,
            $variant->variant_type_name,
            $variant->variant_name,
            $variant->variant_value,
            $variant->stock_quantity,
            $variant->formatted_price_adjustment,
            $variant->formatted_final_price,
            $variant->is_active ? 'Đang bán' : 'Ngừng bán',
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true]],
        ];
    }

    
} 