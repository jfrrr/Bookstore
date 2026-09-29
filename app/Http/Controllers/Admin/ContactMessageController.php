<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContactMessage;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

/**
 * Pengelolaan pesan kontak masuk di panel admin — melihat daftar pesan, membaca detail pesan, mengubah status baca, dan menghapus pesan.
 */
class ContactMessageController extends Controller
{
    /**
     * Menampilkan daftar semua pesan kontak yang masuk dari pengunjung.
     */
    public function index(Request $request): View
    {
        $query = ContactMessage::query();

        // Filter pencarian berdasarkan nama, email, subjek, atau pesan
        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('subject', 'like', "%{$search}%")
                  ->orWhere('message', 'like', "%{$search}%");
            });
        }

        // Filter status (unread / read)
        if ($status = $request->input('status')) {
            if (in_array($status, ['unread', 'read'])) {
                $query->where('status', $status);
            }
        }

        $messages = $query->latest()->paginate(15)->withQueryString();

        $unreadCount = ContactMessage::where('status', 'unread')->count();
        $totalCount  = ContactMessage::count();

        return view('admin.messages.index', compact('messages', 'unreadCount', 'totalCount'));
    }

    /**
     * Menampilkan detail pesan dan otomatis menandainya sebagai sudah dibaca (read).
     */
    public function show(ContactMessage $message): View
    {
        if ($message->status === 'unread') {
            $message->update(['status' => 'read']);
        }

        return view('admin.messages.show', compact('message'));
    }

    /**
     * Mengubah status pesan antara 'read' dan 'unread'.
     */
    public function toggleRead(ContactMessage $message): RedirectResponse
    {
        $newStatus = $message->status === 'unread' ? 'read' : 'unread';
        $message->update(['status' => $newStatus]);

        $statusText = $newStatus === 'read' ? 'sudah dibaca' : 'belum dibaca';
        return back()->with('success', "Status pesan ditandai sebagai {$statusText}.");
    }

    /**
     * Menghapus pesan kontak.
     */
    public function destroy(ContactMessage $message): RedirectResponse
    {
        $message->delete();

        return redirect()->route('admin.messages.index')->with('success', 'Pesan kontak berhasil dihapus.');
    }
}
