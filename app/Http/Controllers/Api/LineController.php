<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Message;


class LineController extends Controller
{

    public function index () {
        $messages = Message::all();
        return view('messageHistory',['messages' => $messages]);
    }

    public function webhook (Request $request)
    {
        $text = $request->events[0]['message']['text'];
        $user_id = $request->events[0]['source']['userId'];

        $message = new Message;
        $message->text = $text;
        $message->user = $user_id;
        $message->save();
    }
}
