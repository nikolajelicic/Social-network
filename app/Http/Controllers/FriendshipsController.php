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
        $userId = auth()->id();
        $friends = $this->friendshipService->getFriends($userId);
        if($friends == null || count($friends) < 1){
            return view('myFriend')->with('message', 'No friends');
        }else{
            foreach($friends as $friend){
                dd($friend->user->name);
            }
            return view('myFriends', ['friends' => $friends]);
        }
    }

    public function acceptFriendRequest(CreateNewPostRequest $request)
    {
        $senderId = $request->input('senderId');
        $this->friendshipService->acceptFriendRequest($senderId);
        
        return response()->json(['success'=>true],200);
    }
}
