<?php 

namespace App\Services;

use App\Repositories\NotificationRepository;
use Illuminate\Http\Request;

class NotificationService {

    private $notificationRepository;

    public function __construct(NotificationRepository $notificationRepository) {
        $this->notificationRepository = $notificationRepository;
    }

    public function countNotification()
    {   
        return $this->notificationRepository->countNotification();
    }

    public function getNotification()
    {   
        return $this->notificationRepository->getNotification();
    }

    public function markAsRead($id)
    {
        $this->notificationRepository->markAsRead($id);
    }

    public function sendNotification($receiver_id, $notifiable_type)
    {
        $this->notificationRepository->sendNotification($receiver_id, $notifiable_type);
    }
}