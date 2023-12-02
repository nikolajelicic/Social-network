<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\NotificationService;

class NotificationsController extends Controller
{
    private $notificationService;

    public function __construct(NotificationService $notificationService)
    {
        $this->notificationService = $notificationService;
    }

    public function countNotification()
    {
        return $this->notificationService->countNotification();
    }

    public function getNotification()
    {
        return $this->notificationService->getNotification();
    }

    public function markAsRead($id)
    {
        return $this->notificationService->markAsRead($id);
    }   

    public function sendNotification($receiver_id, $notifiable_type)
    {
        $this->notificationService->sendNotification($receiver_id, $notifiable_type);
    }
}
