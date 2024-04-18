<?php

namespace App\Services;

use App\Contracts\Notification\Notification;
use App\Contracts\Notification\NotificationFabricInterface;
use Illuminate\Support\Facades\Log;

class NotificationScaleFabric implements  NotificationFabricInterface
{
    private array $notificationsClasses;

    public function __construct()
    {
        $this->notificationsClasses[] = new EmailNotificationService();
    }

    /**
     * $data advanced messages
     * example:
     *  $data = [
     *     "first text",
     *     "second text"
     *  ]
     *
     * @param string $message
     * @param array $data
     * @return void
     */
    public function sendNotifications(string $message, array $data = []): void
    {
        /** @var Notification $notificator */
        foreach ($this->notificationsClasses as $notificator) {
            try {
                if ($data) {
                    foreach ($data as $text) {
                        $message .= $text . "\n";
                    }
                }

                $notificator->send($message);
            } catch (\Exception $exception) {
                Log::info($exception->getMessage());
            }
        }
    }
}
