<?php

namespace App\Interfaces;

interface NotificationInterface
{
    public function sendNotification($receiver_id, $notifiable_type);
    
    public function countNotification();

    public function getNotification();

    public function markAsRead($id);
}