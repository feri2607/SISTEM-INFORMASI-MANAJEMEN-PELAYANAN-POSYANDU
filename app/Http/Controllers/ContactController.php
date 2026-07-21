<?php
// app/Http/Controllers/ContactController.php

namespace App\Http\Controllers;

use App\Models\Contact;
use App\Models\ContactMessage;
use App\Models\Faq;
use App\Http\Requests\ContactRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\RateLimiter;

class ContactController extends Controller
{
    /**
     * Display the contact page
     */
    public function index()
    {
        // Get contact info with cache
        $contact = Cache::remember('contact_info', 3600, function () {
            return Contact::first();
        });

        // Get FAQs
        $faqs = Faq::published()->ordered()->get();

        return view('public.contact', compact('contact', 'faqs'));
    }

    /**
     * Send contact message
     */
    public function send(ContactRequest $request)
    {
        // Rate limiting: max 3 messages per hour per IP
        $key = 'contact.' . $request->ip();
        if (RateLimiter::tooManyAttempts($key, 3)) {
            return back()->with('error', 'Anda telah mengirim terlalu banyak pesan. Silakan coba lagi dalam ' . 
                RateLimiter::availableIn($key) . ' detik.');
        }

        RateLimiter::hit($key, 3600);

        // Save message
        ContactMessage::create($request->validated());

        // Clear cache for admin dashboard
        Cache::forget('unread_messages_count');

        return back()->with('success', 'Pesan Anda berhasil dikirim. Tim kami akan segera merespon.');
    }

    /**
     * Admin: Display contact info form
     */
    public function adminIndex()
    {
        $this->authorize('viewAny', Contact::class);

        $contact = Contact::first();
        $unreadCount = ContactMessage::where('is_read', false)->count();

        return view('admin.contact.index', compact('contact', 'unreadCount'));
    }

    /**
     * Admin: Update contact info
     */
    public function adminUpdate(Request $request)
    {
        $this->authorize('update', Contact::class);

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'address' => ['required', 'string'],
            'phone' => ['required', 'string', 'max:20'],
            'whatsapp' => ['nullable', 'string', 'max:20'],
            'email' => ['required', 'string', 'email', 'max:255'],
            'website' => ['nullable', 'string', 'max:255', 'url'],
            'facebook' => ['nullable', 'string', 'max:255'],
            'instagram' => ['nullable', 'string', 'max:255'],
            'youtube' => ['nullable', 'string', 'max:255'],
            'tiktok' => ['nullable', 'string', 'max:255'],
            'google_maps_url' => ['nullable', 'string'],
            'office_hours' => ['required', 'string'],
        ]);

        $contact = Contact::first();
        if (!$contact) {
            $contact = Contact::create($validated);
        } else {
            $contact->update($validated);
        }

        // Clear cache
        Cache::forget('contact_info');

        return redirect()->route('admin.contact.index')
            ->with('success', 'Informasi kontak berhasil diperbarui.');
    }

    /**
     * Admin: Display messages list
     */
    public function messages()
    {
        $this->authorize('viewAny', ContactMessage::class);

        $messages = ContactMessage::orderBy('created_at', 'desc')->paginate(10);
        $unreadCount = ContactMessage::where('is_read', false)->count();

        return view('admin.contact.messages', compact('messages', 'unreadCount'));
    }

    /**
     * Admin: Show message detail
     */
    public function showMessage($id)
    {
        $message = ContactMessage::findOrFail($id);
        $this->authorize('view', $message);

        // Mark as read
        if (!$message->is_read) {
            $message->is_read = true;
            $message->save();
            Cache::forget('unread_messages_count');
        }

        return view('admin.contact.message-detail', compact('message'));
    }

    /**
     * Admin: Delete message
     */
    public function deleteMessage($id)
    {
        $message = ContactMessage::findOrFail($id);
        $this->authorize('delete', $message);

        $message->delete();
        Cache::forget('unread_messages_count');

        return redirect()->route('admin.contact.messages')
            ->with('success', 'Pesan berhasil dihapus.');
    }

    /**
     * Admin: Reply to a message by sending email
     */
    public function replyMessage(Request $request, $id)
    {
        $message = ContactMessage::findOrFail($id);
        $this->authorize('view', $message);

        $request->validate([
            'reply_body' => ['required', 'string', 'min:5'],
        ], [
            'reply_body.required' => 'Isi balasan tidak boleh kosong.',
            'reply_body.min'      => 'Balasan minimal 5 karakter.',
        ]);

        try {
            Mail::raw($request->reply_body, function ($mail) use ($message) {
                $mail->to($message->email, $message->name)
                     ->subject('Re: ' . $message->subject)
                     ->from(config('mail.from.address'), config('mail.from.name') ?: 'Admin Posyandu');
            });

            // Auto-mark as read after replying
            if (!$message->is_read) {
                $message->update(['is_read' => true]);
                Cache::forget('unread_messages_count');
            }

            return redirect()->route('admin.contact.message.show', $id)
                ->with('success', 'Balasan berhasil dikirim ke ' . $message->email . '.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Gagal mengirim email: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Admin: Mark message as read
     */
    public function markAsRead($id)
    {
        $message = ContactMessage::findOrFail($id);
        $this->authorize('update', $message);

        $message->is_read = true;
        $message->save();
        Cache::forget('unread_messages_count');

        return redirect()->back()
            ->with('success', 'Pesan ditandai sebagai sudah dibaca.');
    }

    /**
     * Admin: Mark all messages as read
     */
    public function markAllAsRead()
    {
        $this->authorize('update', ContactMessage::class);

        ContactMessage::where('is_read', false)->update(['is_read' => true]);
        Cache::forget('unread_messages_count');

        return redirect()->back()
            ->with('success', 'Semua pesan ditandai sebagai sudah dibaca.');
    }
}