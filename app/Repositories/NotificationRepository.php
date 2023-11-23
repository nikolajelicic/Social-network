<?php 

namespace App\Repositories;

use App\Interfaces\NotificationInterface;
use App\Models\Notification;
use Illuminate\Support\Facades\Auth;

class NotificationRepository implements NotificationInterface {

    public function sendNotification($receiverId, $notificationType, $data = [])
    {
        //inplementirati
    }

    public function getNotification()
    {
        $notification = Notification::where('user_id', Auth::id())
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