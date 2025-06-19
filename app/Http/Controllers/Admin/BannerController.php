<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class BannerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Banner::query();

        // Tìm kiếm theo tiêu đề hoặc mô tả
        if ($request->filled('search')) {
            $query->where('title', 'like', '%' . $request->search . '%')
                  ->orWhere('description', 'like', '%' . $request->search . '%');
        }

        // Lọc theo trạng thái
        if ($request->filled('status')) {
            $query->byStatus($request->status);
        }

        // Sắp xếp
        $sortBy = $request->get('sort_by', 'position');
        $sortOrder = $request->get('sort_order', 'asc');
        
        if ($sortBy === 'position') {
            $query->orderBy('position', $sortOrder)->orderBy('created_at', 'desc');
        } elseif ($sortBy === 'created_at') {
            $query->orderBy('created_at', $sortOrder);
        } elseif ($sortBy === 'title') {
            $query->orderBy('title', $sortOrder);
        } else {
            $query->ordered();
        }

        $banners = $query->paginate(15);

        return view('admin.banners.index', compact('banners'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.banners.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [Add commentMore actions
        'title' => 'required|string|max:255',
        'description' => 'nullable|string',
        'image_url' => 'required|string|max:500',
        'link' => 'nullable|string|max:500',
        'position' => 'integer|min:0',
        'is_active' => 'boolean'
    ]);
    
    if ($validator->fails()) {
        return redirect()->back()
            ->withErrors($validator)
            ->withInput();
    }
    
    $data = $request->all();
    $data['is_active'] = $request->has('is_active');
    
    $banner->update($data);
    
    return redirect()->route('admin.banners.index')
        ->with('success', 'Banner đã được cập nhật thành công!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Banner $banner)
    {
        return view('admin.banners.show', compact('banner'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Banner $banner)
    {
        return view('admin.banners.edit', compact('banner'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Banner $banner)
    {
        
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Banner $banner)
    {
        $banner->delete();

        return redirect()->route('admin.banners.index')
            ->with('success', 'Banner đã được xóa thành công!');
    }

    /**
     * Toggle status của banner
     */
    public function toggleStatus(Banner $banner)
    {
        $banner->update(['is_active' => !$banner->is_active]);
        
        $status = $banner->is_active ? 'kích hoạt' : 'tạm dừng';
        
        return redirect()->back()
            ->with('success', "Banner đã được {$status} thành công!");
    }

      
    /**
     * Cập nhật position của banner (drag & drop)
     */
    public function updatePosition(Request $request)
    {
        $positions = $request->get('positions', []);
        
        foreach ($positions as $position => $bannerId) {
            Banner::where('id', $bannerId)->update(['position' => $position + 1]);
        }
        
        return response()->json(['success' => true, 'message' => 'Thứ tự banner đã được cập nhật!']);
    }
} 