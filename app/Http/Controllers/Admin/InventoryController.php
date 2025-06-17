<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ProductVariant;
use Illuminate\Http\Request;

class InventoryController extends Controller
{
    /**
     * Hiển thị danh sách biến thể sản phẩm
     */
    public function index()
    {
        $variants = ProductVariant::with(['product' => function($query) {
                $query->with('images');
            }])
            ->orderBy('id', 'desc')
            ->get();

        return view('admin.inventory.index', compact('variants'));
    }
} 