<?php
namespace App\Api\V1\Controllers;

use App\Exceptions\GenericExceptionHandler;
use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\Request;
use Telegram\Bot\Laravel\Facades\Telegram;
use Carbon\Carbon;

/**
 * @OA\Schema(
 *     title="TelegramBotController",
 *     description="TelegramBotController",
 *     @OA\Xml(
 *         name="TelegramBotController"
 *     )
 * )
 */
class TelegramBotController extends Controller {
   

    public function sendTestMessage(){
         
        return response()->json(["message" => "ok"]);

    }

   
     /**
     *@OA\Post(
     *      path="/bot/subscribe-user",
     *      operationId="subscribe",
     *      tags="Telegram Bot",
     *      summary="Subscribe user to chat",
     *      description="Subscribe user to chat",
     *      @OA\Parameter(
     *         description="Chat id",
     *         in="path",
     *         name="chatID",
     *         required=true,
     *         @OA\Schema(
     *          anyOf={@OA\Schema(type="integer", format="int64"), @OA\Schema(type="string", format="string")}
     *         )
     *      ),
     *      @OA\Produces(
     *          "application/json"
     *      ),
     *      @OA\RequestBody(
     *          required=true
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Subscribed to channel",
     *          @OA\JsonContent(ref="")
     *       ),
     *      @OA\Response(
     *          response=403,
     *          description="User ID Header required"
     *      )
     *)
     */
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

        return response()->json(["message" => "Subscribed to channel."]);
    }
    

    /**
     *@OA\Post(
     *      path="bot/{chatID}/broadcast-message",
     *      operationId="sendMessageToSubscibers",
     *      tags="Telegram Bot",
     *      summary="Send message to subscribers to a chat",
     *      description="Sends message to chat",
     *      @OA\Produces(
     *          "application/json"
     *      ),
     *      @OA\Parameter(
     *         description="Chat id",
     *         in="path",
     *         parameter="chatID_required",
     *         name="chatID",
     *         required=true,
     *         @OA\Schema(
     *          anyOf={@OA\Schema(type="integer", format="int64"), @OA\Schema(type="string", format="string")}
     *         )
     *      ),
     *      @OA\RequestBody(
     *          required=true
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Message sent.",
     *          @OA\JsonContent(ref="")
     *       ),
     *      @OA\Response(
     *          response=400,
     *          description="Unable to send message",
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      )
     *     
     *)
     */
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
    
    
    /**
     *@OA\Post(
     *      path='/bot/Psdsdsdsds00199183Epn5i3q6vjdhh7hl7djVWDIAVhFDRMAwZ1tj0Og2v4PWyj4PZ/webhook',
     *      operationId="webhookGetUpdates",
     *      tags="Telegram Bot",
     *      summary="Webhook to receive updates",
     *      description="Webhook to receive updates",
     *      @OA\Produces(
     *          "application/json"
     *      ),
    *      @OA\Response(
     *          response=200,
     *          description="Updates received.",
     *          @OA\JsonContent(ref="")
     *       )
     *)
     */
    public function webhookGetUpdates(Request $request){

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