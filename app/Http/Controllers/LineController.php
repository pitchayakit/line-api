<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use LINE\LINEBot;
use LINE\LINEBot\Constant\HTTPHeader;
use LINE\LINEBot\SignatureValidator;
use LINE\LINEBot\HTTPClient\CurlHTTPClient;
use LINE\LINEBot\MessageBuilder\TextMessageBuilder;
use Exception;

class LineController extends Controller
{
    public function webhook (Request $request)
    {
        $lineAccessToken = "xRseAo79uy/jbI3cKbdv1C4vc6MeDAznQF0p3uZcdez4ELe4ICaFBFmb9IbHX6aNxCQUr/hCA/xAv6cEZ1cxIFKSo36l7nZctXBYRxeEod2KfiCMQXlgGBTMhnHFLt0G5D7QEzfLMqDiLN2+q8pFtgdB04t89/1O/w1cDnyilFU=";
        $lineChannelSecret = "8e1013c5f9ab0275e13cbee535192fc3";

        // Signature check 
        $signature  =  $request -> headers -> get ( HTTPHeader :: LINE_SIGNATURE ); 
        if  ( ! SignatureValidator :: validateSignature ( $request -> getContent (),  $lineChannelSecret ,  $signature ))  { 
            // TODO Unauthorized access 
            return ; 
        }

        $httpClient = new CurlHTTPClient ($lineAccessToken);
        $lineBot = new LINEBot($httpClient, ['channelSecret' => $lineChannelSecret]);

        try  { 
            // Get event 
            $events  =  $lineBot -> parseEventRequest ( $request -> getContent (),  $signature );

            foreach  ( $events  as  $event )  { 
                // Reply with Hello 
                $replyToken  =  $event -> getReplyToken (); 
                $textMessage  =  new  TextMessageBuilder ( "Hello" ); 
                $lineBot -> replyMessage ( $replyToken ,  $textMessage ); 
            } 
        }  catch  ( Exception  $e )  { 
            // TODO exception 
            return ; 
        }

        return;
    }
}
