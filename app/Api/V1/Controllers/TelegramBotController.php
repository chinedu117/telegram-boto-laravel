<?php
namespace App\Api\V1\Controllers;

use App\Http\Controllers\Controller;

class TelegramBotController extends Controller {
   

    public function sendTestMessage(){
         
        return response()->json(["message" => "ok"]);

    }

    

    public function subscribeUserToBot(){

    }

    public function subscribeUserToChat(){

    }

    public function sendMessageToSubscibers(){

    }





}