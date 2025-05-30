@@ -0,0 +1,293 @@
<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Category::with('parent', 'children');

        // Tìm kiếm theo tên
        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%')
                ->orWhere('description', 'like', '%' . $request->search . '%');
        }

        // Lọc theo trạng thái
        if ($request->filled('status')) {
            $query->where('is_active', $request->status == 'active');
        }

        // Lọc theo danh mục cha
        if ($request->filled('parent_id')) {
            if ($request->parent_id == 'root') {
                $query->whereNull('parent_id');
            } else {
                $query->where('parent_id', $request->parent_id);
            }
        }

        // Lọc theo cấp độ
        if ($request->filled('level')) {
            $level = (int)$request->level;
            if ($level === 0) {
                $query->whereNull('parent_id');
            } elseif ($level === 1) {
                $query->whereHas('parent', function ($q) {
                    $q->whereNull('parent_id');
                });
            } elseif ($level === 2) {
                $query->whereHas('parent.parent', function ($q) {
                    $q->whereNull('parent_id');
                });
            }
        }

        $categories = $query->orderBy('sort_order')->orderBy('name')->paginate(20);

        // Lấy danh sách danh mục cha để filter
        $parentCategories = Category::whereNull('parent_id')->active()->ordered()->get();

        return view('admin.categories.index', compact('categories', 'parentCategories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $parentCategories = $this->getParentCategoriesForSelect();
        return view('admin.categories.create', compact('parentCategories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:categories,slug',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'parent_id' => 'nullable|exists:categories,id',
            'sort_order' => 'integer|min:0',
            'is_active' => 'boolean',
            'is_featured' => 'boolean'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $data = $request->all();

        // Xử lý upload hình ảnh
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '_' . Str::slug($request->name) . '.' . $image->getClientOriginalExtension();
            $imagePath = $image->storeAs('categories', $imageName, 'public');
            $data['image'] = $imagePath;
        }

        Category::create($data);

        return redirect()->route('admin.categories.index')
            ->with('success', 'Danh mục đã được tạo thành công!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        $category->load('parent', 'children.children');
        return view('admin.categories.show', compact('category'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $category)
    {
        $parentCategories = $this->getParentCategoriesForSelect($category->id);
        return view('admin.categories.edit', compact('category', 'parentCategories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Category $category)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:categories,slug,' . $category->id,
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'parent_id' => 'nullable|exists:categories,id',
            'sort_order' => 'integer|min:0',
            'is_active' => 'boolean',
            'is_featured' => 'boolean'
        ]);

        // Kiểm tra không thể đặt chính nó làm cha
        if ($request->parent_id == $category->id) {
            $validator->errors()->add('parent_id', 'Không thể đặt chính danh mục này làm danh mục cha.');
        }

        // Kiểm tra không thể đặt danh mục con của nó làm cha
        if ($request->parent_id && in_array($request->parent_id, $category->getAllChildrenIds())) {
            $validator->errors()->add('parent_id', 'Không thể đặt danh mục con làm danh mục cha.');
        }

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $data = $request->all();

        // Xử lý upload hình ảnh mới
        if ($request->hasFile('image')) {
            // Xóa hình ảnh cũ
            if ($category->image && Storage::disk('public')->exists($category->image)) {
                Storage::disk('public')->delete($category->image);
            }

            $image = $request->file('image');
            $imageName = time() . '_' . Str::slug($request->name) . '.' . $image->getClientOriginalExtension();
            $imagePath = $image->storeAs('categories', $imageName, 'public');
            $data['image'] = $imagePath;
        }

        $category->update($data);

        return redirect()->route('admin.categories.index')
            ->with('success', 'Danh mục đã được cập nhật thành công!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        // Kiểm tra xem danh mục có danh mục con không
        if ($category->hasChildren()) {
            return redirect()->back()
                ->with('error', 'Không thể xóa danh mục này vì vẫn còn danh mục con!');
        }

        // Xóa hình ảnh
        if ($category->image && Storage::disk('public')->exists($category->image)) {
            Storage::disk('public')->delete($category->image);
        }

        $category->delete();

        return redirect()->route('admin.categories.index')
            ->with('success', 'Danh mục đã được xóa thành công!');
    }

    /**
     * Toggle status của danh mục
     */
    public function toggleStatus(Category $category)
    {
        $category->update(['is_active' => !$category->is_active]);

        $status = $category->is_active ? 'kích hoạt' : 'ẩn';
        return redirect()->back()
            ->with('success', "Đã {$status} danh mục thành công!");
    }

    /**
     * Lấy danh sách danh mục cha cho dropdown
     */
    private function getParentCategoriesForSelect($excludeId = null)
    {
        $query = Category::whereNull('parent_id')->active()->ordered();

        if ($excludeId) {
            $query->where('id', '!=', $excludeId);
        }

        return $query->get();
    }

    /**
     * API endpoint để lấy danh mục con
     */
    public function getChildren(Request $request)
    {
        $parentId = $request->get('parent_id');

        $children = Category::where('parent_id', $parentId)
            ->active()
            ->ordered()
            ->get(['id', 'name']);

        return response()->json($children);
    }

    /**
     * Bulk actions
     */
    public function bulkAction(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'action' => 'required|in:delete,activate,deactivate',
            'category_ids' => 'required|array',
            'category_ids.*' => 'exists:categories,id'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator);
        }

        $categoryIds = $request->category_ids;
        $action = $request->action;

        switch ($action) {
            case 'delete':
                $categories = Category::whereIn('id', $categoryIds)->get();
                foreach ($categories as $category) {
                    if (!$category->hasChildren()) {
                        // Xóa hình ảnh
                        if ($category->image && Storage::disk('public')->exists($category->image)) {
                            Storage::disk('public')->delete($category->image);
                        }
                        $category->delete();
                    }
                }
                $message = 'Đã xóa các danh mục được chọn (trừ những danh mục có danh mục con)';
                break;

            case 'activate':
                Category::whereIn('id', $categoryIds)->update(['is_active' => true]);
                $message = 'Đã kích hoạt các danh mục được chọn';
                break;

            case 'deactivate':
                Category::whereIn('id', $categoryIds)->update(['is_active' => false]);
                $message = 'Đã ẩn các danh mục được chọn';
                break;
        }

        return redirect()->back()->with('success', $message);
    }
}
