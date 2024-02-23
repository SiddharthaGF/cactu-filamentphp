<?php

use App\Http\Controllers\WhatsappController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::controller(WhatsappController::class)
    ->name('whatsapp.')
    ->prefix('whatsapp')
    ->group(
        function (): void {
            Route::get('/send/{number_phone}', 'send')->name('send');
            Route::get('/webhook', 'webhook')->name('webhook');
            Route::post('/webhook', 'receive')->name('receive');
        }
    );
