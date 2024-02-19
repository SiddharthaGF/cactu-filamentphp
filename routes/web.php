<?php

declare(strict_types=1);

use App\Http\Controllers\PDFController;
use App\Models\User;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/chat/{id}', fn () => User::all())->name('chat');

Route::controller(PDFController::class)->group(
    function () {
        Route::get('/sheet/{child}', 'sheet')->name('sheet');
    }
);
