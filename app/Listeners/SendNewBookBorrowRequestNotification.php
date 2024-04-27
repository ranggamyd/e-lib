<?php

namespace App\Listeners;

use App\Events\NewBookBorrowRequest;
use App\Models\Book;
use App\Models\Member;
use App\Models\Order;
use App\Models\User;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Twilio\Rest\Client;

class SendNewBookBorrowRequestNotification implements ShouldQueue
{
    public function handle(NewBookBorrowRequest $order)
    {
        $member = Member::where('id', $order->member_id)->first();
        $book = Book::where('id', $order->book_id)->first();
        $staffs = User::where('role', 'staff')->get();

        foreach ($staffs as $staff) {
            $message = "Halo $staff->name, ada permintaan peminjaman buku baru dengan detail sebagai berikut:\n\n" .
                "Peminjam: " . $member->name . "\n" .
                "Judul Buku: " . $book->title . "\n" .
                "Mohon untuk diperiksa dan dikonfirmasi secepat mungkin. Terima kasih!";

            $twilio = new Client(env('TWILIO_ACCOUNT_SID'), env('TWILIO_AUTH_TOKEN')); // inisialisasi obyek Twilio API
            $message = $twilio->messages->create("whatsapp:" . env('WHATSAPP_ADMIN_NUMBER'), array('from' => 'whatsapp:' . env('TWILIO_WHATSAPP_NUMBER'), 'body' => $message)); // kirim pesan notifikasi via WhatsApp menggunakan Twilio API
        }
    }
}
