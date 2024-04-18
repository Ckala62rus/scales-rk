<?php

namespace App\Services;

use App\Contracts\Notification\Notification;
use App\Mail\ScaleNotificationMail;
use Illuminate\Support\Facades\Mail;

class EmailNotificationService implements Notification
{
    public function send(string $message)
    {
        $notification = (new ScaleNotificationMail($message))
            ->onQueue("notification");

        Mail::queue($notification);
    }
}
