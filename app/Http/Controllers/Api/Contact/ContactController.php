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
    /**
     * Returns all contacts from database with except of authorized user.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getContacts()
    {
        // Query for select all users except of authorized user.
        $contacts = User::where('id', '!=', auth()->id())->get();

        // Query for get user ids ('sender_id') and count of messages (messages_count) that authorized user hasn't read yet.
        $unreadIds = Message::select(DB::raw('`from` as sender_id, count(`from`) as messages_count'))
            ->where('to', auth()->id())
            ->where('read', false)
            ->groupBy('from')
            ->get();

        // Sets each of our contacts count of unread messages.
        $contacts = $contacts->map(function ($contact) use ($unreadIds) {
            // Checks do we have unread messages from this contact.
            $contactUnread = $unreadIds->where('sender_id', $contact->id)->first();
            // If we have unread messages from this contact we will get the count of unread messages, else we got zero.
            $contact->unread = $contactUnread ? $contactUnread->messages_count : 0;
            return $contact;
        });

        return response()->json($contacts);
    }

    /**
     * Returns all messages from contact with this id.
     *
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function getMessagesFor($id)
    {
        // Marks all messages from selected contact as read.
        Message::where('from', $id)->where('to', auth()->id())->update(['read' => true]);

        // Query for get all messages that we sent and get from this contact.
        $messages = Message::where(function ($q) use ($id) {
            $q->where('from', auth()->id());
            $q->where('to', $id);
        })->orWhere(function ($q) use ($id) {
            $q->where('from', $id);
            $q->where('to', auth()->id());
        })->get();

        return response()->json($messages);
    }

    /**
     * Creating new message.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
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
