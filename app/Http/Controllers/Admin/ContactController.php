<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\ContactReplyMail;

class ContactController extends Controller
{
    public function index(Request $request)
    {
        $query = Contact::with(['user', 'repliedByAdmin'])
                        ->orderBy('created_at', 'desc');

        // Filter theo status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter theo priority
        if ($request->filled('priority')) {
            $query->where('priority', $request->priority);
        }

        // Tìm kiếm theo tên hoặc email
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('subject', 'like', "%{$search}%");
            });
        }

        $contacts = $query->paginate(15);
        $statistics = Contact::getStatistics();

        return view('admin.contacts.index', compact('contacts', 'statistics'));
    }

    public function show(Contact $contact)
    {
        $contact->load(['user', 'repliedByAdmin']);
        return view('admin.contacts.show', compact('contact'));
    }

    public function edit(Contact $contact)
    {
        $contact->load(['user', 'repliedByAdmin']);
        return view('admin.contacts.edit', compact('contact'));
    }

    public function update(Request $request, Contact $contact)
    {
        $request->validate(Contact::getAdminValidationRules());

        try {
            $oldStatus = $contact->status;
            
            $contact->update([
                'status' => $request->status,
                'priority' => $request->priority,
                'admin_notes' => $request->admin_notes,
            ]);

            // Nếu trạng thái chuyển sang in_progress và chưa có người xử lý
            if ($request->status === 'in_progress' && !$contact->replied_by) {
                $contact->update(['replied_by' => Auth::id()]);
            }

            return redirect()->route('admin.contacts.show', $contact)
                           ->with('success', 'Cập nhật liên hệ thành công!');
                           
        } catch (\Exception $e) {
            return redirect()->back()
                           ->with('error', 'Có lỗi xảy ra: ' . $e->getMessage())
                           ->withInput();
        }
    }

    public function reply(Request $request, Contact $contact)
    {
        $request->validate([
            'reply_message' => 'required|string|min:10'
        ]);

        try {
            // Cập nhật contact với thông tin trả lời
            $contact->reply($request->reply_message, Auth::id());

            // Gửi email trả lời (có thể mở rộng sau)
            // Mail::to($contact->email)->send(new ContactReplyMail($contact));

            return redirect()->route('admin.contacts.show', $contact)
                           ->with('success', 'Đã trả lời liên hệ thành công!');
                           
        } catch (\Exception $e) {
            return redirect()->back()
                           ->with('error', 'Có lỗi xảy ra: ' . $e->getMessage())
                           ->withInput();
        }
    }

    public function destroy(Contact $contact)
    {
        try {
            $contact->delete();
            
            return redirect()->route('admin.contacts.index')
                           ->with('success', 'Đã xóa liên hệ thành công!');
                           
        } catch (\Exception $e) {
            return redirect()->back()
                           ->with('error', 'Có lỗi xảy ra khi xóa: ' . $e->getMessage());
        }
    }

    public function updateStatus(Request $request, Contact $contact)
    {
        $request->validate([
            'status' => 'required|in:pending,in_progress,replied,closed'
        ]);

        try {
            if ($request->status === 'in_progress' && !$contact->replied_by) {
                $contact->markAsInProgress(Auth::id());
            } else {
                $contact->update(['status' => $request->status]);
            }

            return response()->json([
                'success' => true,
                'message' => 'Cập nhật trạng thái thành công!',
                'status' => $contact->status_text,
                'status_class' => $contact->status_badge_class
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Có lỗi xảy ra: ' . $e->getMessage()
            ], 500);
        }
    }

    public function updatePriority(Request $request, Contact $contact)
    {
        $request->validate([
            'priority' => 'required|in:low,medium,high'
        ]);

        try {
            $contact->updatePriority($request->priority);

            return response()->json([
                'success' => true,
                'message' => 'Cập nhật mức độ ưu tiên thành công!',
                'priority' => $contact->priority_text,
                'priority_class' => $contact->priority_badge_class
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Có lỗi xảy ra: ' . $e->getMessage()
            ], 500);
        }
    }

    public function bulkAction(Request $request)
    {
        $request->validate([
            'action' => 'required|in:delete,mark_replied,mark_closed,set_priority',
            'contact_ids' => 'required|array',
            'contact_ids.*' => 'exists:contacts,id',
            'priority' => 'required_if:action,set_priority|in:low,medium,high'
        ]);

        try {
            $contacts = Contact::whereIn('id', $request->contact_ids);
            $count = $contacts->count();

            switch ($request->action) {
                case 'delete':
                    $contacts->delete();
                    $message = "Đã xóa {$count} liên hệ thành công!";
                    break;
                    
                case 'mark_replied':
                    $contacts->update(['status' => 'replied']);
                    $message = "Đã đánh dấu {$count} liên hệ là đã trả lời!";
                    break;
                    
                case 'mark_closed':
                    $contacts->update(['status' => 'closed']);
                    $message = "Đã đóng {$count} liên hệ thành công!";
                    break;
                    
                case 'set_priority':
                    $contacts->update(['priority' => $request->priority]);
                    $priorityText = match($request->priority) {
                        'low' => 'Thấp',
                        'medium' => 'Trung bình', 
                        'high' => 'Cao'
                    };
                    $message = "Đã cập nhật mức độ ưu tiên {$priorityText} cho {$count} liên hệ!";
                    break;
            }

            return redirect()->route('admin.contacts.index')
                           ->with('success', $message);
                           
        } catch (\Exception $e) {
            return redirect()->back()
                           ->with('error', 'Có lỗi xảy ra: ' . $e->getMessage());
        }
    }

    public function export(Request $request)
    {
        // TODO: Implement export functionality
        return redirect()->back()->with('info', 'Chức năng xuất dữ liệu sẽ được triển khai sau.');
    }
}