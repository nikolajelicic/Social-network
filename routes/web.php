<?php

use App\Http\Controllers\PagesController;
use App\Http\Controllers\PostsController;
use App\Http\Controllers\LikesController;
use App\Http\Controllers\CommentLikesController;
use App\Http\Controllers\CommentsController;
use App\Http\Controllers\FriendshipsController;
use App\Http\Controllers\MessagesController;
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

Route::get('/', function () {
    return view('index');
})->middleware('guest');


Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    //PageController routes
    Route::get('/profile', [PagesController::class, 'profilePage'])->name('profile.profilePage');
    Route::get('/edit-post/{id}', [PagesController::class, 'showEditPostPage'])->name('profile.showEditPostPage');
    Route::get('/add-friends', [PagesController::class, 'showAddFriendsPage'])->name('profile.addFriends');
    Route::get('/chat', [PagesController::class, 'showChatPage'])->name('profile.showChatPage');
    Route::get('/profile/{slug}', [PagesController::class, 'profilePageBySlug'])->name('profile.profilePageBySlug');

    Route::get('/friends-request', [PagesController::class, 'showFriendsRequest'])->name('profile.showFriendsRequest');
    Route::get('/my-friends', [PagesController::class, 'myFriends'])->name('profile.myFriends');

    Route::get('/notification', [PagesController::class, 'notificationPage'])->name('profile.notificationPage');
    Route::get('/friend-posts', [PagesController::class, 'showFriendPostsPage'])->name('profile.showFriendPostsPage');

    //LikesController routes
    Route::get('/like{id}', [LikesController::class, 'likePost'])->name('profile.likePost');
    Route::get('/unlike{id}', [LikesController::class, 'unlikePost'])->name('profile.unlikePost');

    //CommentLikesController routes
    Route::get('/commentUnlike{id}', [CommentLikesController::class, 'unlikeComment'])->name('profile.commentUnlike');
    Route::get('/commentLike{id}', [CommentLikesController::class, 'likeComment'])->name('profile.commentLike');
    Route::delete('/delete-comment/{id}', [CommentsController::class, 'deleteComment'])->name('profile.deleteComment');
    Route::post('/new-comment', [CommentsController::class, 'newComment'])->name('profile.newComment');
    Route::get('/commentLikes/{id}', [CommentLikesController::class, 'showWhoIsLikesComment'])->name('profile.showWhoIsLikesComment');

    //FriendshipsController routes
    Route::post('/add-new-friend',[FriendshipsController::class, 'sendFriendRequest'])->name('profile.newFriendRequest');
    Route::post('/delete-friend-request',[FriendshipsController::class, 'deleteFriendRequest'])->name('profile.deleteFriendRequest');
    Route::post('/delete-friend',[FriendshipsController::class, 'deleteFriendRequest'])->name('profile.deleteFriendRequest');
    Route::post('/accept-friend-request',[FriendshipsController::class, 'acceptFriendRequest'])->name('profile.acceptFriendRequest');
    Route::get('/my-friends', [FriendshipsController::class, 'getFriends'])->name('profile.getFriends');

    //PostsController routes
    Route::post('/createNewPost', [PostsController::class, 'createNewPost'])->name('post.new');
    Route::delete('/delete-post/{id}', [PostsController::class, 'deletePost'])->name('profile.deletePost');
    Route::put('/editPost', [PostsController::class, 'editPost'])->name('profile.editPost');
    Route::get('/showLikes/{postId}', [PostsController::class, 'showLikes'])->name('post.showLikes');

    //message controller
    Route::get('/chat/{receiver_id}', [MessagesController::class, 'showMessage'])->name('profile.showMessage');
    Route::post('/newMessage', [MessagesController::class, 'newMessage'])->name('profile.newMessage');
    Route::post('/deleteMessage', [MessagesController::class, 'deleteMessage'])->name('profile.deleteMessage');
    Route::put('/editMessage', [MessagesController::class, 'editMessage'])->name('profile.editMessage');


    /*Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');*/
});

require __DIR__.'/auth.php';
