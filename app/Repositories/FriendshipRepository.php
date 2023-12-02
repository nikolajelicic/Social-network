<?php 

namespace App\Repositories;

use App\Interfaces\FriendshipInterface;
use App\Models\Friendship;
use App\Models\Notification;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class FriendshipRepository implements FriendshipInterface{

    public function sendFriendRequest($senderId, $receiverId)
    {
        $friendship = new Friendship();
        $friendship->user_id = $senderId;
        $friendship->friend_id = $receiverId;
        $friendship->status = 'pending';
        $friendship->save();
    }

    public function acceptFriendRequest($senderId)
    {
        $friendship = Friendship::where('user_id', $senderId)
                    ->where('friend_id',Auth::id())
                    ->where('status', 'pending')
                    ->first();
        if($friendship){
            $friendship->status = 'accepted';
            $friendship->save();
        }else{
            return false;
        }
    }

    public function rejectFriendRequest($senderId, $receiverId)
    {
        //This method is implemented on deleteFriendRequest(), the code would be the same
    }

    public function deleteFriendRequest($senderId, $receiverId)
    {
        $friendRequest = Friendship::where('friend_id', $receiverId)
                    ->where('user_id', $senderId)
                    ->first();

        if(!$friendRequest){
            $friendRequest = Friendship::where('friend_id', $senderId)
                ->where('user_id', $receiverId)
                ->first();
        }

        if($friendRequest){
            $friendRequest->delete();
            return true;
        }else{
            return false;
        }
    }

    public function unfriend($senderId, $receiverId)
    {
        //This method is implemented on deleteFriendRequest(), the code would be the same
    }

    public function getFriends()
    {
        $friends = Friendship::where(function ($query) {
            $query->where('user_id', auth()->id())
                ->where('status', 'accepted');
        })
        ->orWhere(function ($query) {
            $query->where('friend_id', auth()->id())
                ->where('status', 'accepted');
        })
        ->get();
        
        $friendIds = collect();
        
        foreach ($friends as $friend) {
            if ($friend->user_id != auth()->id()) {
                $friendIds = $friendIds->merge([$friend->user_id]);
            } else {
                $friendIds = $friendIds->merge([$friend->friend_id]);
            }
        }
        
        $friendIds = $friendIds->unique();
    
        $friendUsers = User::whereIn('id', $friendIds)->get();

        return $friendUsers;
    }

    public function getFriendsStatus($userId)
    {
        $status = Friendship::where(function ($query) use ($userId) {
            $query->where('user_id', auth()->id())
                  ->where('friend_id', $userId);
        })
        ->orWhere(function ($query) use ($userId) {
            $query->where('user_id', $userId)
                  ->where('friend_id', auth()->id());
        })
        ->with('user')
        ->value('status');

        return $status;
    }

    public function friendRequests()//friend requests received by the logged in user 
    {
        $requests = Friendship::where('friend_id',auth()->id())
        ->where('status','pending')
        ->with('user')
        ->get();

        return $requests;
    }

    public function sentRequests()//friend requests sent by a logged in user
    {
        $sentRequests = Friendship::where('user_id',auth()->id())
        ->where('status','pending')
        ->with('friend')
        ->get();

        return $sentRequests;
    }
}