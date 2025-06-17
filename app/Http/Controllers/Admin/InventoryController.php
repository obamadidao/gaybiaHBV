<?php

namespace App\Http\Controllers\Admin;

use App\Exports\InventoryExport;
use App\Http\Controllers\Controller;
use App\Models\ProductVariant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class InventoryController extends Controller
{
    /**
     * Hiển thị danh sách biến thể sản phẩm
     */
    public function index(Request $request)
    {
        $query = ProductVariant::with(['product' => function ($query) {
            $query->with('images');
        }]);

        // Tìm kiếm theo tên sản phẩm, SKU sản phẩm hoặc SKU biến thể
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->whereHas('product', function ($q2) use ($search) {
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
            $query->whereHas('product', function ($q) use ($request) {
                $q->whereRaw('(base_price + product_variants.price_adjustment) >= ?', [$request->price_from]);
            });
        }
        if ($request->filled('price_to')) {
            $query->whereHas('product', function ($q) use ($request) {
                $q->whereRaw('(base_price + product_variants.price_adjustment) <= ?', [$request->price_to]);
            });
        }

        $variants = $query->orderBy('id', 'desc')->get();

        return view('admin.inventory.index', compact('variants'));
    }

    public function export(Request $request)
    {
        $query = ProductVariant::with('product');

        // Áp dụng các bộ lọc giống như trong index()
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->whereHas('product', function ($q2) use ($search) {
                    $q2->where('name', 'like', "%{$search}%")
                        ->orWhere('sku', 'like', "%{$search}%");
                })
                    ->orWhere('sku', 'like', "%{$search}%");
            });
        }
        if ($request->filled('variant_type')) {
            $query->where('variant_type', $request->variant_type);
        }
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
        if ($request->filled('price_from')) {
            $query->whereHas('product', function ($q) use ($request) {
                $q->whereRaw('(base_price + product_variants.price_adjustment) >= ?', [$request->price_from]);
            });
        }
        if ($request->filled('price_to')) {
            $query->whereHas('product', function ($q) use ($request) {
                $q->whereRaw('(base_price + product_variants.price_adjustment) <= ?', [$request->price_to]);
            });
        }

        $variants = $query->orderBy('id', 'desc')->get();

        return Excel::download(new InventoryExport($variants), 'danh-sach-ton-kho.xlsx');
    }

    public function edit($id)
    {
        $variant = ProductVariant::findOrFail($id);
        return response()->json([
            'success' => true,
            'variant' => $variant
        ]);
    }

    public function update(Request $request, $id)
    {
        $variant = ProductVariant::findOrFail($id);
        $validated = $request->validate([
            'sku' => 'nullable|string|max:50',
            'variant_name' => 'nullable|string|max:255',
            'variant_value' => 'nullable|string|max:255',
            'stock_quantity' => 'nullable|integer|min:0',
            'min_stock' => 'nullable|integer|min:0',
            'price_adjustment' => 'nullable|numeric',
        ]);
        $variant->update($validated);
        return response()->json([
            'success' => true,
            'message' => 'Cập nhật thành công!'
        ]);
    }
}