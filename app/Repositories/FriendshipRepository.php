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

        //send notification to the sender user that request is sent.
        $notification = new Notification();
        $notification->user_id = $receiverId;
        $notification->notifiable_type = 'friend_request';
        $notification->message = Auth::user()->name . " sent you a friend request";
        $notification->read = 0;
        $notification->save();
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
            $notification->user_id = $senderId;
            $notification->notifiable_type = 'accepted_friend_request';
            $notification->message = Auth::user()->name . " has accepted your friend request.";
            $notification->read = 0;
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

            //send notification to the sender user that request is rejected.
            $notification = new Notification();
            $notification->user_id = $senderId;
            $notification->notifiable_type = 'rejected_friend_request';
            $notification->message = Auth::user()->name . " has rejected your friend request.";
            $notification->read = 0;
            $notification->save();
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
        //dd($friendUsers);
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
        //dd($requests);
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