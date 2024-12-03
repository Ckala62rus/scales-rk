<?php

namespace App\Console\Commands;

use App\Contracts\Notification\NotificationFabricInterface;
use App\Contracts\Scale\ScaleServiceInterface;
use App\Models\Scale;
use Illuminate\Console\Command;
use Illuminate\Support\Carbon;

class SendNotificationIfScaleDontWorkAllDayCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:SendNotificationIfScaleDontWorkAllDayCommand';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        /** @var ScaleServiceInterface $scaleService */
        $scaleService = app(ScaleServiceInterface::class);

        /** @var NotificationFabricInterface $notificationFabric */
        $notificationFabric = app(NotificationFabricInterface::class);

        $scales = $scaleService->getAllScalesCollection([]);

        $notificationMessage = null;

        /** @var Scale $scale */
        foreach ($scales as $scale) {
            // Проверяем сколько прошло времени с момента отсутствия связи с весами
            // и если связи нет 24 часа, то отправляем письмо с уведомлением.
            if ($scale->send_error_notification && $scale->last_error_date != null) {

                /** @var Carbon $date */
                $now = Carbon::now();
                $diff = $now->diffInHours($scale->last_error_date);

                if ($diff >= 24) {
                    $notificationMessage .= "Спустя 24 часа, связь с весами ({$scale->ip_address}:{$scale->port}) не установлена" . PHP_EOL;
                    $scale->last_error_date = Carbon::now();
                    $scale->save();
                }
            }
        }

        if ($notificationMessage !== null) {
            $notificationFabric
                ->sendNotifications($notificationMessage);
        }

        return Command::SUCCESS;
    }
}
