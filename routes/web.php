<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\ChatController;
use App\Http\Controllers\HomeController;

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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [HomeController::class, 'index'])->name('home');
Route::view('/users', 'users.showAll')->name('users.all');
Route::view('/game', 'game.show')->name('game.show');

Route::resource('chat', ChatController::class)->only(['index', 'store']);
Route::post('chat/message', [ChatController::class, 'messageReceived'])->name('chat.message');
