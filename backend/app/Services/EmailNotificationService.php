<?php

namespace App\Services;

use App\Contracts\Notification\Notification;
use App\Mail\ScaleNotificationMail;
use Illuminate\Support\Facades\Mail;

class EmailNotificationService implements Notification
{
    public function send(string $message)
    {
        $emails_string = config('notification.emails');

        $emails = explode(';', $emails_string);

        foreach ($emails as $email) {
            $notification = (new ScaleNotificationMail($message, $email))
                ->onQueue("notification");

            Mail::queue($notification);
        }
    }
}
