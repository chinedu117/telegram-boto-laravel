<?php
namespace App\Api\V1\Controllers;

use App\Exceptions\GenericExceptionHandler;
use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\Request;
use Telegram\Bot\Laravel\Facades\Telegram;
use Carbon\Carbon;

class TelegramBotController extends Controller {
   

    public function sendTestMessage(){
         
        return response()->json(["message" => "ok"]);

    }

   

    public function subscribeUserToChat(Request $request, $chatID){
        try {
            Telegram::chatJoinRequest([
                'chat' => Telegram::getChat($chatID),
                'from' => $request->user(),
                'date' => Carbon::now(),
                'invite_link' => $request->invite_link,
            ]);
        } catch (Exception $e) {
            
            throw new GenericExceptionHandler("Unable to subscribe to channel",400);
        }

        return response()->json(["message" => "Subscribes to channel"]);
    }
    

    public function sendMessageToSubscibers(Request $request, $chatID){

        try {
            Telegram::setAsyncRequest(true)
                ->sendMessage([
                    'chat_id' => $chatID,
                    'text' => $request->message
                ]);
        } catch (Exception $e) {
            
            throw new GenericExceptionHandler("Unable to send message",400);
        }
        return response()->json(["message" => "Message sent."]);

    }

    public function webhook(Request $request){

        // 
        $updates = null;
        try {
            $updates = Telegram::setAsyncRequest(true)
                ->getUpdates();
        } catch (Exception $e) {
            throw new GenericExceptionHandler("Unable to receive updates",400);
        }
        return response()->json(["data"=> $updates, "message" => "Updates received."]);
        
    }





}