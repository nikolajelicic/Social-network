<?php

namespace App\Interfaces;

interface NotificationInterface
{
    public function sendNotification($receiverId, $notificationType, $data = []);
}