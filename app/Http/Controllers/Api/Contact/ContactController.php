<?php

namespace App\Http\Controllers\Api\Contact;

use App\Events\NewMessage;
use App\Http\Controllers\Controller;
use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function getContacts()
    {
        $users = User::where('id', '!=', auth()->id())->get();
        return response()->json($users);
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
