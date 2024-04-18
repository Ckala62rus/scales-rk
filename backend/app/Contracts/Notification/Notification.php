<?php

namespace App\Contracts\Notification;

interface Notification
{
    public function send(string $message);
}
