<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ProductVariant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class InventoryController extends Controller
{
/**
    * Hiển thị danh sách biến thể sản phẩm
    */
    public function index()
    public function index(Request $request)
{
        $variants = ProductVariant::with(['product' => function($query) {
        $query = ProductVariant::with(['product' => function($query) {
$query->with('images');
            }])
            ->orderBy('id', 'desc')
            ->get();
            }]);

        // Tìm kiếm theo tên sản phẩm, SKU sản phẩm hoặc SKU biến thể
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->whereHas('product', function($q2) use ($search) {
                    $q2->where('name', 'like', "%{$search}%")
                       ->orWhere('sku', 'like', "%{$search}%");
                })
                ->orWhere('sku', 'like', "%{$search}%");
            });
        }

        // Lọc theo trạng thái tồn kho
        if ($request->filled('stock_status')) {
            switch ($request->stock_status) {
                case 'in_stock':
                    $query->where('stock_quantity', '>', 0);
                    break;
                case 'low_stock':
                    $query->where('stock_quantity', '<=', DB::raw('min_stock'))
                          ->where('stock_quantity', '>', 0);
                    break;
                case 'out_of_stock':
                    $query->where('stock_quantity', '=', 0);
                    break;
            }
        }

        // Lọc theo loại biến thể
        if ($request->filled('variant_type')) {
            $query->where('variant_type', $request->variant_type);
        }

        // Lọc theo khoảng giá (giá bán cuối = base_price + price_adjustment)
        if ($request->filled('price_from')) {
            $query->whereHas('product', function($q) use ($request) {
                $q->whereRaw('(base_price + product_variants.price_adjustment) >= ?', [$request->price_from]);
            });
        }
        if ($request->filled('price_to')) {
            $query->whereHas('product', function($q) use ($request) {
                $q->whereRaw('(base_price + product_variants.price_adjustment) <= ?', [$request->price_to]);
            });
        }

        $variants = $query->orderBy('id', 'desc')->get();

return view('admin.inventory.index', compact('variants'));
}