<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use App\Models\ProductVariant;
use App\Models\ProductImage;
use App\Models\ProductReview;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Product::with(['category', 'primaryImage'])
            ->withCount(['variants', 'reviews', 'approvedReviews']);

        // Tìm kiếm
        if ($request->filled('search')) {
            $query->search($request->search);
        }

        // Lọc theo danh mục
        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        // Lọc theo trạng thái
        if ($request->filled('status')) {
            if ($request->status === 'active') {
                $query->where('is_active', true);
            } elseif ($request->status === 'inactive') {
                $query->where('is_active', false);
            }
        }

        // Lọc theo thương hiệu
        if ($request->filled('brand')) {
            $query->where('brand', $request->brand);
        }

        // Lọc theo tồn kho
        if ($request->filled('stock_status')) {
            if ($request->stock_status === 'in_stock') {
                $query->where('stock_quantity', '>', 0);
            } elseif ($request->stock_status === 'out_of_stock') {
                $query->where('stock_quantity', '<=', 0);
            } elseif ($request->stock_status === 'low_stock') {
                $query->whereColumn('stock_quantity', '<=', 'min_stock')
                    ->where('stock_quantity', '>', 0);
            }
        }

        // Lọc sản phẩm nổi bật
        if ($request->filled('featured')) {
            $query->where('is_featured', $request->featured);
        }

        // Sắp xếp
        $sortBy = $request->get('sort_by', 'created_at');
        $sortDirection = $request->get('sort_direction', 'desc');

        if (in_array($sortBy, ['name', 'base_price', 'stock_quantity', 'created_at'])) {
            $query->orderBy($sortBy, $sortDirection);
        }

        $products = $query->paginate(15);

        // Lấy dữ liệu cho filters
        $categories = Category::active()->orderBy('name')->get();
        $brands = Product::distinct()->whereNotNull('brand')->pluck('brand')->sort();

        return view('admin.products.index', compact('products', 'categories', 'brands'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::active()->orderBy('name')->get();
        $variantTypes = ProductVariant::VARIANT_TYPES;

        return view('admin.products.create', compact('categories', 'variantTypes'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:products,slug',
            'description' => 'nullable|string',
            'short_description' => 'nullable|string',
            'category_id' => 'required|exists:categories,id',
            'brand' => 'nullable|string|max:255',
            'model' => 'nullable|string|max:255',
            'material' => 'nullable|string|max:255',
            'base_price' => 'required|numeric|min:0',
            'compare_price' => 'nullable|numeric|min:0',
            'cost_price' => 'nullable|numeric|min:0',
            'sku' => 'nullable|string|max:255|unique:products,sku',
            'stock_quantity' => 'required|integer|min:0',
            'min_stock' => 'required|integer|min:0',
            'track_quantity' => 'boolean',
            'weight' => 'nullable|numeric|min:0',
            'length' => 'nullable|numeric|min:0',
            'width' => 'nullable|numeric|min:0',
            'height' => 'nullable|numeric|min:0',
            'is_active' => 'boolean',
            'is_featured' => 'boolean',
            'is_digital' => 'boolean',

            // Images
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',

            // Variants
            'variants.*.variant_type' => 'nullable|in:handle_material,tip_material',
            'variants.*.variant_name' => 'nullable|string|max:255',
            'variants.*.variant_value' => 'nullable|string|max:255',
            'variants.*.description' => 'nullable|string',
            'variants.*.price_adjustment' => 'nullable|numeric',
            'variants.*.cost_adjustment' => 'nullable|numeric',
            'variants.*.stock_quantity' => 'nullable|integer|min:0',
            'variants.*.min_stock' => 'nullable|integer|min:0',
            'variants.*.is_active' => 'boolean',
            'variants.*.sort_order' => 'nullable|integer',
        ]);

        DB::transaction(function () use ($validated, $request) {
            // Tạo sản phẩm
            $product = Product::create($validated);

            // Upload và lưu hình ảnh
            if ($request->hasFile('images')) {
                $this->handleImageUploads($product, $request->file('images'));
            }

            // Tạo variants
            if ($request->filled('variants')) {
                $this->createVariants($product, $request->variants);
            }
        });

        return redirect()->route('admin.products.index')
            ->with('success', 'Sản phẩm đã được tạo thành công!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        $product->load([
            'category',
            'images' => function ($query) {
                $query->ordered();
            },
            'variants' => function ($query) {
                $query->ordered();
            },
            'reviews' => function ($query) {
                $query->with('user')->latest();
            }
        ]);

        // Thống kê đánh giá
        $reviewStats = [
            'total' => $product->reviews->count(),
            'approved' => $product->approvedReviews->count(),
            'pending' => $product->reviews->where('is_approved', false)->count(),
            'average_rating' => $product->average_rating,
            'rating_breakdown' => []
        ];

        // Phân tích theo từng mức đánh giá
        for ($i = 1; $i <= 5; $i++) {
            $count = $product->approvedReviews->where('rating', $i)->count();
            $percentage = $reviewStats['approved'] > 0
                ? round(($count / $reviewStats['approved']) * 100)
                : 0;

            $reviewStats['rating_breakdown'][$i] = [
                'count' => $count,
                'percentage' => $percentage
            ];
        }

        return view('admin.products.show', compact('product', 'reviewStats'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        $product->load([
            'images' => function ($query) {
                $query->ordered();
            },
            'variants' => function ($query) {
                $query->ordered();
            }
        ]);

        $categories = Category::active()->orderBy('name')->get();
        $variantTypes = ProductVariant::VARIANT_TYPES;

        return view('admin.products.edit', compact('product', 'categories', 'variantTypes'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:products,slug,' . $product->id,
            'description' => 'nullable|string',
            'short_description' => 'nullable|string',
            'category_id' => 'required|exists:categories,id',
            'brand' => 'nullable|string|max:255',
            'model' => 'nullable|string|max:255',
            'material' => 'nullable|string|max:255',
            'base_price' => 'required|numeric|min:0',
            'compare_price' => 'nullable|numeric|min:0',
            'cost_price' => 'nullable|numeric|min:0',
            'sku' => 'nullable|string|max:255|unique:products,sku,' . $product->id,
            'stock_quantity' => 'required|integer|min:0',
            'min_stock' => 'required|integer|min:0',
            'track_quantity' => 'boolean',
            'weight' => 'nullable|numeric|min:0',
            'length' => 'nullable|numeric|min:0',
            'width' => 'nullable|numeric|min:0',
            'height' => 'nullable|numeric|min:0',
            'is_active' => 'boolean',
            'is_featured' => 'boolean',
            'is_digital' => 'boolean',

            // Images
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'delete_images.*' => 'nullable|integer|exists:product_images,id',

            // Variants
            'variants.*.id' => 'nullable|integer|exists:product_variants,id',
            'variants.*.variant_type' => 'nullable|in:handle_material,tip_material',
            'variants.*.variant_name' => 'nullable|string|max:255',
            'variants.*.variant_value' => 'nullable|string|max:255',
            'variants.*.description' => 'nullable|string',
            'variants.*.price_adjustment' => 'nullable|numeric',
            'variants.*.cost_adjustment' => 'nullable|numeric',
            'variants.*.stock_quantity' => 'nullable|integer|min:0',
            'variants.*.min_stock' => 'nullable|integer|min:0',
            'variants.*.is_active' => 'boolean',
            'variants.*.sort_order' => 'nullable|integer',
            'delete_variants.*' => 'nullable|integer|exists:product_variants,id',
        ]);

        DB::transaction(function () use ($validated, $request, $product) {
            // Cập nhật sản phẩm
            $product->update($validated);

            // Xóa hình ảnh được chọn
            if ($request->filled('delete_images')) {
                $this->deleteImages($request->delete_images);
            }

            // Upload hình ảnh mới
            if ($request->hasFile('images')) {
                $this->handleImageUploads($product, $request->file('images'));
            }

            // Xóa variants được chọn
            if ($request->filled('delete_variants')) {
                ProductVariant::whereIn('id', $request->delete_variants)->delete();
            }

            // Cập nhật/tạo variants
            if ($request->filled('variants')) {
                $this->updateVariants($product, $request->variants);
            }
        });

        return redirect()->route('admin.products.show', $product)
            ->with('success', 'Sản phẩm đã được cập nhật thành công!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        DB::transaction(function () use ($product) {
            // Xóa tất cả hình ảnh
            foreach ($product->images as $image) {
                if (Storage::exists($image->image_path)) {
                    Storage::delete($image->image_path);
                }
            }

            // Soft delete sản phẩm (sẽ tự động xóa variants, images, reviews do cascade)
            $product->delete();
        });

        return redirect()->route('admin.products.index')
            ->with('success', 'Sản phẩm đã được xóa thành công!');
    }

    /**
     * Toggle product status
     */
    public function toggleStatus(Product $product)
    {
        $product->update(['is_active' => !$product->is_active]);

        $status = $product->is_active ? 'kích hoạt' : 'ẩn';
        return back()->with('success', "Sản phẩm đã được {$status} thành công!");
    }

    /**
     * Toggle featured status
     */
    public function toggleFeatured(Product $product)
    {
        $product->update(['is_featured' => !$product->is_featured]);

        $status = $product->is_featured ? 'đánh dấu nổi bật' : 'bỏ đánh dấu nổi bật';
        return back()->with('success', "Sản phẩm đã được {$status} thành công!");
    }

    /**
     * Handle bulk actions
     */
    public function bulkAction(Request $request)
    {
        $request->validate([
            'action' => 'required|in:activate,deactivate,feature,unfeature,delete',
            'product_ids' => 'required|array',
            'product_ids.*' => 'exists:products,id'
        ]);

        $products = Product::whereIn('id', $request->product_ids);

        switch ($request->action) {
            case 'activate':
                $products->update(['is_active' => true]);
                $message = 'Các sản phẩm đã được kích hoạt thành công!';
                break;

            case 'deactivate':
                $products->update(['is_active' => false]);
                $message = 'Các sản phẩm đã được ẩn thành công!';
                break;

            case 'feature':
                $products->update(['is_featured' => true]);
                $message = 'Các sản phẩm đã được đánh dấu nổi bật!';
                break;

            case 'unfeature':
                $products->update(['is_featured' => false]);
                $message = 'Các sản phẩm đã được bỏ đánh dấu nổi bật!';
                break;

            case 'delete':
                // Xóa hình ảnh trước khi xóa sản phẩm
                foreach ($products->get() as $product) {
                    foreach ($product->images as $image) {
                        if (Storage::exists($image->image_path)) {
                            Storage::delete($image->image_path);
                        }
                    }
                }
                $products->delete();
                $message = 'Các sản phẩm đã được xóa thành công!';
                break;
        }

        return back()->with('success', $message);
    }

    /**
     * Product reviews management
     */
    public function reviews(Product $product, Request $request)
    {
        $query = $product->reviews()->with('user');

        // Filter by status
        if ($request->filled('status')) {
            switch ($request->status) {
                case 'pending':
                    $query->pending();
                    break;
                case 'approved':
                    $query->approved();
                    break;
                case 'hidden':
                    $query->hidden();
                    break;
            }
        }

        // Filter by rating
        if ($request->filled('rating')) {
            $query->where('rating', $request->rating);
        }

        // Search in title and content
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('content', 'like', "%{$search}%");
            });
        }

        $reviews = $query->latest()->paginate(15);

        return view('admin.products.reviews', compact('product', 'reviews'));
    }

    /**
     * Handle image uploads
     */
    private function handleImageUploads(Product $product, array $images)
    {
        $maxSortOrder = $product->images()->max('sort_order') ?? 0;
        $isFirstImage = $product->images()->count() === 0;

        foreach ($images as $index => $image) {
            if ($image && $image->isValid()) {
                // Tạo tên file unique
                $filename = time() . '_' . $index . '.' . $image->getClientOriginalExtension();
                $path = $image->storeAs('products', $filename, 'public');

                // Lấy thông tin file
                $imageInfo = getimagesize($image->getRealPath());

                ProductImage::create([
                    'product_id' => $product->id,
                    'image_path' => $path,
                    'alt_text' => $product->name,
                    'title' => $product->name,
                    'sort_order' => $maxSortOrder + $index + 1,
                    'is_primary' => $isFirstImage && $index === 0,
                    'width' => $imageInfo[0] ?? null,
                    'height' => $imageInfo[1] ?? null,
                    'file_size' => $image->getSize(),
                    'mime_type' => $image->getMimeType()
                ]);
            }
        }
    }

    /**
     * Delete images
     */
    private function deleteImages(array $imageIds)
    {
        $images = ProductImage::whereIn('id', $imageIds)->get();

        foreach ($images as $image) {
            if (Storage::exists($image->image_path)) {
                Storage::delete($image->image_path);
            }
            $image->delete();
        }
    }

    /**
     * Create product variants
     */
    private function createVariants(Product $product, array $variants)
    {
        foreach ($variants as $variantData) {
            if (!empty($variantData['variant_type']) && !empty($variantData['variant_value'])) {
                ProductVariant::create(array_merge($variantData, [
                    'product_id' => $product->id
                ]));
            }
        }
    }

    /**
     * Update product variants
     */
    private function updateVariants(Product $product, array $variants)
    {
        foreach ($variants as $variantData) {
            if (!empty($variantData['variant_type']) && !empty($variantData['variant_value'])) {
                if (!empty($variantData['id'])) {
                    // Cập nhật variant hiện có
                    $variant = ProductVariant::find($variantData['id']);
                    if ($variant && $variant->product_id === $product->id) {
                        $variant->update($variantData);
                    }
                } else {
                    // Tạo variant mới
                    ProductVariant::create(array_merge($variantData, [
                        'product_id' => $product->id
                    ]));
                }
            }
        }
    }
}