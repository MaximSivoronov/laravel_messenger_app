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
        $messages = Message::where('from', $id)->orWhere('to', $id)->get();
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
