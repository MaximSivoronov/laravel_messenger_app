<?php

namespace App\Http\Controllers\Api\Contact;

use App\Http\Controllers\Controller;
use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function getContacts()
    {
        $users = User::all();
        return response()->json($users);
    }

    public function getMessagesFor($id)
    {
        $messages = Message::where('from', $id)->orWhere('to', $id)->get();
        return response()->json($messages);
    }
}
