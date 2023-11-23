<?php

namespace App\Interfaces;

interface NotificationInterface
{
    public function sendNotification($receiverId, $notificationType, $data = []);
    
    public function countNotification();

    public function getNotification();

    //public function markAsRead($id);
}