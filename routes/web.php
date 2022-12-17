<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\UserController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::group(['middleware' => 'auth'],function(){
    Route::get('/',[MessageController::class,"index"])->name('dashboard');
    Route::post('send-message',[MessageController::class,"store"])->name('sendMessage');
    Route::get('fetch-user-messages-by-ajax',[MessageController::class,"fetchMessagesByUser"]);
    Route::get('fetch-user-by-ajax',[UserController::class,"index"]);
    Route::post('delete-message',[MessageController::class,"delete"])->name('delete');
});

require __DIR__.'/auth.php';
