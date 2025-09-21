<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class ContactController extends Controller
{
    public function index()
    {
        return view('client.contact');
    }

    public function store(Request $request)
    {
        $request->validate(Contact::getValidationRules(), [
            'name.required' => 'Vui lòng nhập họ tên',
            'email.required' => 'Vui lòng nhập địa chỉ email',
            'email.email' => 'Địa chỉ email không hợp lệ',
            'subject.required' => 'Vui lòng nhập chủ đề',
            'message.required' => 'Vui lòng nhập nội dung tin nhắn',
            'message.min' => 'Nội dung tin nhắn phải có ít nhất 10 ký tự'
        ]);

        try {
            // Tạo contact mới
            $contact = Contact::create([
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'subject' => $request->subject,
                'message' => $request->message,
                'priority' => $request->priority ?? 'medium',
                'user_id' => Auth::id(),
                'ip_address' => $request->ip(),
                'user_agent' => $request->userAgent(),
            ]);

            // Thông báo đơn giản cho admin (có thể mở rộng sau)
            $this->notifyAdmins($contact);

            if ($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Cảm ơn bạn đã liên hệ với chúng tôi! Chúng tôi sẽ phản hồi trong thời gian sớm nhất.',
                    'contact_id' => $contact->id
                ]);
            }

            return redirect()->back()
                           ->with('success', 'Cảm ơn bạn đã liên hệ với chúng tôi! Chúng tôi sẽ phản hồi trong thời gian sớm nhất.');

        } catch (\Exception $e) {
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Có lỗi xảy ra khi gửi tin nhắn. Vui lòng thử lại sau.'
                ], 500);
            }

            return redirect()->back()
                           ->with('error', 'Có lỗi xảy ra khi gửi tin nhắn. Vui lòng thử lại sau.')
                           ->withInput();
        }
    }

    public function myContacts()
    {
        if (!Auth::check()) {
            return redirect()->route('client.login-user')
                           ->with('info', 'Vui lòng đăng nhập để xem lịch sử liên hệ.');
        }

        $contacts = Contact::where('user_id', Auth::id())
                          ->orderBy('created_at', 'desc')
                          ->paginate(10);

        return view('client.my-contacts', compact('contacts'));
    }

    public function show(Contact $contact)
    {
        try {
            // Kiểm tra quyền xem: chỉ user tạo contact
            if (!Auth::check() || Auth::id() !== $contact->user_id) {
                if (request()->ajax()) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Bạn không có quyền xem liên hệ này.'
                    ], 403);
                }
                abort(403, 'Bạn không có quyền xem liên hệ này.');
            }

            $contact->load(['user', 'repliedByAdmin']);
            
            if (request()->ajax()) {
                return view('client.contact-detail', compact('contact'))->render();
            }
            
            return view('client.contact-detail', compact('contact'));
            
        } catch (\Exception $e) {
            Log::error('Error loading contact detail', [
                'contact_id' => $contact->id,
                'user_id' => Auth::id(),
                'error' => $e->getMessage()
            ]);
            
            if (request()->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Có lỗi xảy ra khi tải thông tin liên hệ.'
                ], 500);
            }
            
            abort(500, 'Có lỗi xảy ra khi tải thông tin liên hệ.');
        }
    }

    public function checkStatus(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'contact_id' => 'nullable|exists:contacts,id'
        ]);

        if ($request->contact_id) {
            $contact = Contact::where('id', $request->contact_id)
                             ->where('email', $request->email)
                             ->first();
        } else {
            $contact = Contact::where('email', $request->email)
                             ->orderBy('created_at', 'desc')
                             ->first();
        }

        if (!$contact) {
            return response()->json([
                'success' => false,
                'message' => 'Không tìm thấy liên hệ với email này.'
            ]);
        }

        return response()->json([
            'success' => true,
            'contact' => [
                'id' => $contact->id,
                'subject' => $contact->subject,
                'status' => $contact->status_text,
                'status_class' => $contact->status_badge_class,
                'created_at' => $contact->formatted_created_at,
                'replied_at' => $contact->formatted_replied_at,
                'reply_message' => $contact->reply_message,
                'priority' => $contact->priority_text,
                'priority_class' => $contact->priority_badge_class
            ]
        ]);
    }

    private function notifyAdmins(Contact $contact)
    {
        try {
            // Log thông báo có liên hệ mới (có thể mở rộng sau để gửi email)
            Log::info('New contact received', [
                'contact_id' => $contact->id,
                'name' => $contact->name,
                'email' => $contact->email,
                'subject' => $contact->subject,
                'priority' => $contact->priority
            ]);
        } catch (\Exception $e) {
            // Log lỗi nhưng không làm fail request  
            Log::error('Failed to log contact notification: ' . $e->getMessage());
        }
    }

    public function getContactForm()
    {
        // Trả về partial view của form contact để load qua AJAX
        return view('client.partials.contact-form');
    }
}