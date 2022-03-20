<?php

use Illuminate\Support\Facades\Route;
use App\Api\V1\Controllers\TelegramBotController;
use App\Http\Middleware\MustSetUserIDHeader;

// Route::middleware([MustSetUserIDHeader::class])->get("/test", [TelegramBotController::class, "sendTestMessage"]);

Route::middleware([MustSetUserIDHeader::class])->post('/bot/subscribe-user', [TelegramBotController::class, 'subscribeUserToChat']);

Route::post('/bot/Psdsdsdsds00199183Epn5i3q6vjdhh7hl7djVWDIAVhFDRMAwZ1tj0Og2v4PWyj4PZ/webhook', [TelegramBotController::class, 'webhookGetUpdates']);

Route::post('/bot/{chatID}/broadcast-message', [TelegramBotController::class, 'sendMessageToSubscibers']);

