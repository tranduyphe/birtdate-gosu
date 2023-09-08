<?php

use Illuminate\Support\Facades\Route;

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

// Route::get('/', function () {
//     return view('welcome');
// });


Route::get('/login', function () {
    return view('layouts.launch');
});

Route::get('/logout', function () {
    return view('layouts.launch');
});


Route::get('/thu-vien-toan-tri', [App\Http\Controllers\HomeController::class, 'home'])->name('thu-vien-toan-tri');
Route::get('/quest', [App\Http\Controllers\HomeController::class, 'quest'])->name('quest');
Route::get('/minigame', [App\Http\Controllers\HomeController::class, 'launch'])->name('home');
Route::get('/launch', [App\Http\Controllers\HomeController::class, 'launch'])->name('launch');
Route::get('/site-map', [App\Http\Controllers\HomeController::class, 'launch'])->name('launch');


Route::get('{any}', function () {
    return view('layouts.launch');
})->where('any', '.*');

// Route::get('/login', [App\Http\Controllers\Api\AuthController::class, 'login']);

// Route::middleware('auth:sanctum')->group( function () {
//     Route::get('user', [App\Http\Controllers\Api\AuthController::class, 'Index']);
//     Route::get('logout', [App\Http\Controllers\Api\AuthController::class, 'logout']);
// });;