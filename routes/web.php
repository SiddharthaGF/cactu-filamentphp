<?php

<<<<<<< HEAD
=======
declare(strict_types=1);

>>>>>>> e2f090c01e7b05179aa0c45c43380d40b16818c8
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

<<<<<<< HEAD
=======
Route::get('/chat/{id}', fn () => User::all())->name('chat');

>>>>>>> e2f090c01e7b05179aa0c45c43380d40b16818c8
Route::controller(PDFController::class)->group(
    function () {
        Route::get('/sheet/{child}', 'sheet')->name('sheet');
    }
);
