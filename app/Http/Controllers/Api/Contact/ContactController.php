<?php

namespace App\Http\Controllers\Api\Contact;

use App\Events\NewMessage;
use App\Http\Controllers\Controller;
use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ContactController extends Controller
{
    public function getContacts()
    {
        $contacts = User::where('id', '!=', auth()->id())->get();

        $unreadIds = Message::select(DB::raw('`from` as sender_id, count(`from`) as messages_count'))
            ->where('to', auth()->id())
            ->where('read', false)
            ->groupBy('from')
            ->get();

        $contacts = $contacts->map(function ($contact) use ($unreadIds) {
            $contactUnread = $unreadIds->where('sender_id', $contact->id)->first();
            $contact->unread = $contactUnread ? $contactUnread->messages_count : 0;
            return $contact;
        });

        return response()->json($contacts);
    }

    public function getMessagesFor($id)
    {
        $messages = Message::where(function ($q) use ($id) {
            $q->where('from', auth()->id());
            $q->where('to', $id);
        })->orWhere(function ($q) use ($id) {
            $q->where('from', $id);
            $q->where('to', auth()->id());
        })->get();

        return response()->json($messages);
    }

    public function sendMessage(Request $request)
    {
        $newMessage = Message::create([
            'from' => auth()->id(),
            'to' => $request->contact_id,
            'content' => $request->message_text,
        ]);

        broadcast(new NewMessage($newMessage));

        return response()->json($newMessage);
    }
}
