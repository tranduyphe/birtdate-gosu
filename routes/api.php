<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/


Route::post('/login', [AuthController::class, 'login']);
// private routes
Route::group(['middleware' => ['auth:sanctum']], function () {
    // logout 
    Route::post('/logout', [AuthController::class, 'logout']);

    Route::get('/get-flip', [App\Http\Controllers\FlipController::class, 'getFlip'])->name('flip');
    Route::post('/active-flip', [App\Http\Controllers\FlipController::class, 'activeFlip'])->name('active-flip');
    Route::get('/reload-flip', [App\Http\Controllers\FlipController::class, 'reloadFlip'])->name('reload-flip');
    Route::post('/active-flip-tvtt', [App\Http\Controllers\FlipController::class, 'activeFlipTvtt'])->name('active-flip-tvtt');

    Route::get('/get-top-feathers', [App\Http\Controllers\HomeController::class, 'getTopfeathers'])->name('top-feathers');
    Route::get('/get-log-activity', [App\Http\Controllers\HomeController::class, 'getLogActivity'])->name('log-activity');
    Route::get('/get-item', [App\Http\Controllers\HomeController::class, 'getItem'])->name('list-item');
    
    Route::get('/get-quests', [App\Http\Controllers\QuestController::class, 'getQuests'])->name('quests');
    Route::post('/active-quest', [App\Http\Controllers\QuestController::class, 'activeQuest'])->name('active-quest');
    Route::get('/get-reward', [App\Http\Controllers\QuestController::class, 'getReward'])->name('get-reward-quest');
    Route::get('/invite', [App\Http\Controllers\QuestController::class, 'invite'])->name('invite');

    // Route::get('/send-notification', [App\Http\Controllers\SocketController::class, 'index'])->name('send-notification');
});
