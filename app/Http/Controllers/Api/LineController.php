<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use LINE\LINEBot;
use LINE\LINEBot\Constant\HTTPHeader;
use LINE\LINEBot\SignatureValidator;
use LINE\LINEBot\HTTPClient\CurlHTTPClient;
use LINE\LINEBot\MessageBuilder\TextMessageBuilder;
use Exception;
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
