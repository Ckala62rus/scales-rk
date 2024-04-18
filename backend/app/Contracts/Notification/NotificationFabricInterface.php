<?php

namespace App\Contracts\Notification;

interface NotificationFabricInterface
{
    public function sendNotifications(string $message, array $data = []): void;
}
