<?php

use App\Http\Controllers\CommentLikesController;
use App\Http\Controllers\LikesController;
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

Route::middleware(['auth'])->group(function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    Route::get('/like{id}', [LikesController::class, 'likePost'])->name('profile.likePost');
    Route::get('/commentLikes/{id}', [CommentLikesController::class, 'showWhoIsLikesComment'])->name('profile.showWhoIsLikesComment');

});
