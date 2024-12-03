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

        if (strlen($emails_string) > 0) {
            $emails = explode(';', $emails_string);

            if (count($emails) > 0) {
                foreach ($emails as $email) {
                    if (strlen($email) > 0) {
                        continue;
                    }
                    $notification = (new ScaleNotificationMail($message, $email))
                        ->onQueue("notification");

                    Mail::queue($notification);
                }
            }
        }
    }
}
