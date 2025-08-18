<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductReview;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ProductReviewController extends Controller
{
    /**
     * Submit review cho sản phẩm
     */
    public function submitReview(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'order_id' => 'required|exists:orders,id',
            'rating' => 'required|integer|min:1|max:5',
            'title' => 'nullable|string|max:255',
            'content' => 'required|string|min:10|max:1000',
            'pros' => 'nullable|array|max:10',
            'pros.*' => 'nullable|string|max:100',
            'cons' => 'nullable|array|max:10',
            'cons.*' => 'nullable|string|max:100'
        ]);

        if (!Auth::check()) {
            return response()->json([
                'success' => false,
                'message' => 'Vui lòng đăng nhập để đánh giá sản phẩm'
            ], 401);
        }

        $userId = Auth::id();

        try {
            DB::beginTransaction();

            // Kiểm tra order có thuộc về user không
            $order = Order::where('id', $request->order_id)
                ->where('user_id', $userId)
                ->where('status', 'delivered')
                ->first();

            if (!$order) {
                return response()->json([
                    'success' => false,
                    'message' => 'Đơn hàng không hợp lệ hoặc chưa được giao'
                ], 400);
            }

            // Kiểm tra order có chứa sản phẩm này không
            $orderHasProduct = $order->orderItems()
                ->where('product_id', $request->product_id)
                ->exists();

            if (!$orderHasProduct) {
                return response()->json([
                    'success' => false,
                    'message' => 'Sản phẩm không có trong đơn hàng này'
                ], 400);
            }

            // Kiểm tra đã review cho đơn hàng và sản phẩm này chưa
            $existingReview = ProductReview::where('user_id', $userId)
                ->where('product_id', $request->product_id)
                ->where('order_id', $request->order_id)
                ->first();

            if ($existingReview) {
                return response()->json([
                    'success' => false,
                    'message' => 'Bạn đã đánh giá sản phẩm cho đơn hàng này rồi'
                ], 400);
            }

            // Xử lý pros và cons - chỉ lấy những item không rỗng
            $pros = null;
            if ($request->pros && is_array($request->pros)) {
                $filteredPros = array_values(array_filter($request->pros, function($item) {
                    return !empty(trim($item));
                }));
                $pros = !empty($filteredPros) ? $filteredPros : null;
            }

            $cons = null;
            if ($request->cons && is_array($request->cons)) {
                $filteredCons = array_values(array_filter($request->cons, function($item) {
                    return !empty(trim($item));
                }));
                $cons = !empty($filteredCons) ? $filteredCons : null;
            }

            // Tạo review mới
            $review = ProductReview::create([
                'product_id' => $request->product_id,
                'user_id' => $userId,
                'order_id' => $request->order_id,
                'rating' => $request->rating,
                'title' => trim($request->title) ?: null,
                'content' => trim($request->content),
                'pros' => $pros,
                'cons' => $cons,
                'is_verified_purchase' => true, // Đã mua hàng nên là verified
                'is_approved' => true, // Tự động duyệt
                'approved_at' => now(), // Thời gian duyệt
                'approved_by' => null, // Hệ thống tự duyệt
            ]);

            DB::commit();

            // Load review với user để trả về đầy đủ dữ liệu
            $review->load('user');

            return response()->json([
                'success' => true,
                'message' => 'Cảm ơn bạn đã đánh giá! Đánh giá của bạn đã được đăng thành công.',
                'review' => [
                    'id' => $review->id,
                    'order_id' => $review->order_id,
                    'rating' => $review->rating,
                    'title' => $review->title,
                    'content' => $review->content,
                    'pros' => $review->safe_pros,
                    'cons' => $review->safe_cons,
                    'user_display_name' => $review->user_display_name,
                    'created_at' => $review->created_at->format('d/m/Y'),
                    'days_ago' => $review->days_ago,
                    'rating_text' => $review->rating_text,
                    'has_pros' => $review->hasPros(),
                    'has_cons' => $review->hasCons()
                ]
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Có lỗi xảy ra: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Lấy thông tin các đơn hàng có thể review cho sản phẩm
     */
    public function getEligibleOrders(Request $request, $productId)
    {
        if (!Auth::check()) {
            return response()->json([
                'success' => false,
                'message' => 'Vui lòng đăng nhập'
            ], 401);
        }

        $userId = Auth::id();

        // Lấy các đơn hàng đã giao có chứa sản phẩm này
        $eligibleOrders = Order::where('user_id', $userId)
            ->where('status', 'delivered')
            ->whereHas('orderItems', function($query) use ($productId) {
                $query->where('product_id', $productId);
            })
            ->with(['orderItems' => function($query) use ($productId) {
                $query->where('product_id', $productId);
            }])
            ->get();

        // Lấy các review đã có
        $existingReviews = ProductReview::where('user_id', $userId)
            ->where('product_id', $productId)
            ->pluck('order_id')
            ->toArray();

        // Lọc các đơn hàng chưa được review
        $availableOrders = $eligibleOrders->reject(function($order) use ($existingReviews) {
            return in_array($order->id, $existingReviews);
        })->map(function($order) {
            return [
                'id' => $order->id,
                'order_number' => $order->order_number,
                'delivered_at' => $order->delivered_at ? $order->delivered_at->format('d/m/Y') : null,
                'created_at' => $order->created_at->format('d/m/Y')
            ];
        });

        return response()->json([
            'success' => true,
            'orders' => $availableOrders->values()
        ]);
    }
}
