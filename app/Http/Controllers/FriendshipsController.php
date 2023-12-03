<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateNewPostRequest;
use App\Services\FriendshipService;
use App\Services\NotificationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class FriendshipsController extends Controller
{
    private $friendshipService;
    private $notificationService;
    public function __construct(FriendshipService $friendshipService, NotificationService $notificationService)
    {
        $this->friendshipService = $friendshipService;
        $this->notificationService = $notificationService;
    }

    public function sendFriendRequest(Request $request)
    {
        $senderId = auth()->id();
        $receiverId = $request->input('friend_id');

        $this->friendshipService->sendFriendRequest($senderId, $receiverId);
        $this->notificationService->sendNotification($receiverId, 'friend_request');
        return redirect()->back()->with('message', 'Friend request sent.');
    }

    public static function getFriendsStatus($userId)
    {
        $friendshipService = App::make(FriendshipService::class);

        $status = $friendshipService->getFriendsStatus($userId);
        return $status;
    }

    public function deleteFriendRequest(Request $request)
    {
        $senderId = auth()->id();
        $receiverId = $request->input('friend_id');

        $this->friendshipService->deleteFriendRequest($senderId, $receiverId);

        $this->notificationService->sendNotification($receiverId, 'delete_friend_request');

        return redirect()->back()->with('message', 'Friend request rejected.');
    }

    public function getFriends()
    {
        $friends = $this->friendshipService->getFriends();
        if($friends == null || count($friends) < 1){
            return (['friends' => null]);
        }else{
            return (['friends' => $friends]);
        }
    }

    public function acceptFriendRequest(Request $request)
    {
        $senderId = $request->input('senderId');
        $this->friendshipService->acceptFriendRequest($senderId);

        $receiverId = $senderId;
        $this->notificationService->sendNotification($receiverId, 'accepted_friend_request');

        return redirect()->back();
    }

    public function friendRequests()
    {
        $requests = $this->friendshipService->friendRequests();
        
        return $requests;
    }

    public function sentRequests()
    {
        $sentRequests = $this->friendshipService->sentRequests();
        return $sentRequests;
    }
}
