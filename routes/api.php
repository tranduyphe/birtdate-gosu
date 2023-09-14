<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\WallController;
use App\Http\Controllers\API\CommentController;
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
    Route::group(
        array( 'prefix' => 'wall' ),
        function () {
            Route::post( '/', array( WallController::class, 'index' ) );
            Route::post( '/create', array( WallController::class, 'create' ) );
            Route::post( '/update/{id}', array( WallController::class, 'update' ) );
        }
    );
    Route::group(
        array( 'prefix' => 'comment' ),
        function () {
            //Route::post( '/', array( CommentController::class, 'index' ) );
            Route::post( '/create', array( CommentController::class, 'create' ) );
            Route::post( '/update/{id}', array( CommentController::class, 'update' ) );
            Route::post( '/delete/{id}', array( CommentController::class, 'destroy' ) );
        }
    );
    Route::get('/get-flip', [App\Http\Controllers\FlipController::class, 'getFlip'])->name('flip');
    Route::post('/active-flip', [App\Http\Controllers\FlipController::class, 'activeFlip'])->name('active-flip');
    Route::get('/reload-flip', [App\Http\Controllers\FlipController::class, 'reloadFlip'])->name('reload-flip');
    
    Route::get('/get-flip-tvtt', [App\Http\Controllers\FlipController::class, 'getFlipTvtt'])->name('flip');
    
    Route::get('/reload-flip-tvtt', [App\Http\Controllers\FlipController::class, 'reloadFlipTvtt'])->name('reload-flip-tvtt');
    Route::post('/active-flip-tvtt-2', [App\Http\Controllers\FlipController::class, 'activeFlipTvtt2'])->name('active-flip-tvtt-2');
    Route::post('/active-flip-tvtt', [App\Http\Controllers\FlipController::class, 'activeFlipTvtt'])->name('active-flip-tvtt');

    Route::get('/get-top-feathers', [App\Http\Controllers\HomeController::class, 'getTopfeathers'])->name('top-feathers');
    Route::get('/get-log-activity', [App\Http\Controllers\HomeController::class, 'getLogActivity'])->name('log-activity');
    Route::get('/get-item', [App\Http\Controllers\HomeController::class, 'getItem'])->name('list-item');
    Route::get('/done-instructions', [App\Http\Controllers\HomeController::class, 'doneInstructions'])->name('done-instructions');
    
    Route::get('/get-data-sanh-truong-hop-hep', [App\Http\Controllers\HomeController::class, 'getDataSanhTruongHopHep'])->name('list-data-sthh');
    

    Route::get('/get-quests', [App\Http\Controllers\QuestController::class, 'getQuests'])->name('quests');
    Route::post('/active-quest', [App\Http\Controllers\QuestController::class, 'activeQuest'])->name('active-quest');
    Route::get('/get-reward', [App\Http\Controllers\QuestController::class, 'getReward'])->name('get-reward-quest');
    Route::get('/invite', [App\Http\Controllers\QuestController::class, 'invite'])->name('invite');    
    // Route::get('/check-notification', [App\Http\Controllers\QuestController::class, 'checkNotification'])->name('check-notification');

    // Route::get('/send-notification', [App\Http\Controllers\SocketController::class, 'index'])->name('send-notification');
});
