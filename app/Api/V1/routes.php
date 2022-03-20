<?php

use Illuminate\Support\Facades\Route;
use App\Api\V1\Controllers\TelegramBotController;
use App\Http\Middleware\MustSetUserIDHeader;

Route::middleware(["api",MustSetUserIDHeader::class])->get("/test", [TelegramBotController::class, "sendTestMessage"]);