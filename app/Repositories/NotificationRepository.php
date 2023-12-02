<?php 

namespace App\Repositories;

use App\Interfaces\NotificationInterface;
use App\Models\Notification;
use Illuminate\Support\Facades\Auth;

class NotificationRepository implements NotificationInterface {

    public function sendNotification($receiver_id, $notifiable_type)
    {
        $data = [
            'accepted_friend_request' => 'has accepted you friend request',
            'friend_request' => 'sent you a friend request',
            'delete_friend_request' => 'deleted you from friends',
            'rejected_friend_request' => 'has rejected you friend request',
            'sent_you_a_message' => 'sent you a message',
        ];

        $message = '';
        foreach($data as $key => $value){
            if($notifiable_type == $key){
                $message =  Auth::user()->name . ' ' . $value;
            }
        }
        $notification = new Notification();
        $notification->insert([
            'user_id' => $receiver_id,
            'notifiable_type' => $notifiable_type,
            'message' => $message,
            'read' => 0
        ]);
    }

    public function getNotification()
    {
        $notification = Notification::where('user_id', Auth::id())
        ->orderByDesc('created_at')
        ->get();

        return $notification;
    }

    public function countNotification()
    {
        $notification = Notification::where('user_id', Auth::id())
        ->where('read', 0)
        ->count();

        return $notification;
    }

    public function markAsRead($id)
    {
        $notification = Notification::find($id);
        $notification->read = 1;
        $notification->save();
    }
}