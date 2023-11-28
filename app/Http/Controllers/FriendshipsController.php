<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateNewPostRequest;
use App\Services\FriendshipService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class FriendshipsController extends Controller
{
    private $friendshipService;

    public function __construct(FriendshipService $friendshipService)
    {
        $this->friendshipService = $friendshipService;
    }

    public function sendFriendRequest(Request $request)
    {
        $senderId = auth()->id();
        $receiverId = $request->input('friend_id');

        $this->friendshipService->sendFriendRequest($senderId, $receiverId);

        return redirect()->route('profile.addFriends')->with('message', 'Friend request sent.');
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

        return redirect()->route('profile.addFriends')->with('message', 'Friend request rejected.');
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
        
        return redirect()->route('profile.addFriends');
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
