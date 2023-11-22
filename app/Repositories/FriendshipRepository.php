<?php 

namespace App\Repositories;

use App\Interfaces\FriendshipInterface;
use App\Models\Friendship;
use App\Models\Notification;
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
            //send notification to the sender user that request is accepted.
            $notification = new Notification();
            $notification->from_user_id = Auth::id();
            $notification->to_user_id = $senderId;
            $notification->message = Auth::user()->name . "has accepted your friend request.";
            $notification->is_read = false;
            $notification->save();
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

    public function getFriends($userId)
    {
        $friends = Friendship::where(function ($query) use ($userId) {
            $query->where('user_id', $userId)
                  ->where('status', 'accepted');
        })
        ->orWhere(function ($query) use ($userId) {
            $query->where('friend_id', $userId)
                  ->where('status', 'accepted');
        })
        ->with('user')
        ->get();

        return $friends;
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
}