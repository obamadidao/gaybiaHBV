<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
@@ -77,23 +78,76 @@
public function updateStatus(Request $request, Order $order)
{
$request->validate([
            'status' => 'required|in:processing,shipped,delivered,cancelled'
            'status' => 'required|in:processing,shipped,delivered,cancelled,refunded',
            'admin_notes' => 'required_if:status,cancelled,refunded',
            'evidence_image' => 'required_if:status,refunded|nullable|image|max:2048'
]);

try {
            $order->update([
                'status' => $request->status,
                'shipped_at' => $request->status === 'shipped' ? now() : $order->shipped_at,
                'delivered_at' => $request->status === 'delivered' ? now() : $order->delivered_at,
                'cancelled_at' => $request->status === 'cancelled' ? now() : $order->cancelled_at,
            ]);
            DB::beginTransaction();

            $oldStatus = $order->status;
            $newStatus = $request->status;

            // Kiểm tra quy trình chuyển trạng thái
            if (!$this->isValidStatusTransition($oldStatus, $newStatus)) {
                throw new \Exception('Không thể chuyển từ trạng thái ' . $oldStatus . ' sang ' . $newStatus);
            }

            // Xử lý hủy đơn hàng
            if ($newStatus === 'cancelled') {
                $order->cancellation_reason = $request->admin_notes;
                $order->cancelled_by = auth()->id();
                $order->cancelled_at = now();

                if ($request->hasFile('evidence_image')) {
                    $path = $request->file('evidence_image')->store('order-evidence', 'public');
                    $order->cancellation_evidence = $path;
                }
            }

            // Xử lý hoàn tiền
            if ($newStatus === 'refunded') {
                $order->refund_reason = $request->admin_notes;
                $order->refunded_by = auth()->user()->id;
                $order->refunded_at = now();
                $order->refund_amount = $order->total_amount;

                if ($request->hasFile('evidence_image')) {
                    $path = $request->file('evidence_image')->store('order-evidence', 'public');
                    $order->refund_evidence = $path;
                }
            }

            $order->status = $newStatus;
            $order->admin_notes = $request->admin_notes;
            $order->save();

            // Thêm vào lịch sử trạng thái
            $order->addStatusHistory($newStatus, $request->admin_notes, auth()->id());

            DB::commit();
return redirect()->back()->with('success', 'Cập nhật trạng thái đơn hàng thành công');
} catch (\Exception $e) {
            return redirect()->back()->with('error', 'Có lỗi xảy ra khi cập nhật trạng thái đơn hàng');
            DB::rollBack();
            return redirect()->back()->with('error', 'Có lỗi xảy ra: ' . $e->getMessage());
}
}

    private function isValidStatusTransition($oldStatus, $newStatus)
    {
        $validTransitions = [
            'pending' => ['processing', 'cancelled'],
            'processing' => ['shipped', 'cancelled'],
            'shipped' => ['delivered'],
            'delivered' => ['refunded'],
            'cancelled' => [],
            'refunded' => []
        ];

        return in_array($newStatus, $validTransitions[$oldStatus] ?? []);
    }

/**
    * Cập nhật trạng thái thanh toán
    */