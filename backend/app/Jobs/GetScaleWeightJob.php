<?php

namespace App\Jobs;

use App\Contracts\Notification\NotificationFabricInterface;
use App\Contracts\Scale\ScaleApiServiceInterface;
use App\Contracts\ScaleWeight\ScaleWeightServiceInterface;
use App\Models\Scale;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class GetScaleWeightJob implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(
        private Scale $scale
    ){}


    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $retry = 2;

        /** @var ScaleApiServiceInterface $scalesApiService */
        $scalesApiService = app(ScaleApiServiceInterface::class);

        /** @var ScaleWeightServiceInterface $scaleWeightService */
        $scaleWeightService = app(ScaleWeightServiceInterface::class);

        /** @var NotificationFabricInterface $notificationFabric */
        $notificationFabric = app(NotificationFabricInterface::class);

        while ($retry != 0) {
            try {
                if ($retry == 1) {
                    sleep(15);
                }

                $retry--;
                $weight = $scalesApiService->getWeight($this->scale->ip_address, $this->scale->port);

                if ($weight > 100.00) {
                    throw new \Exception("Весы вернули большой вес ({$weight}). Проверь весы.");
                }

                $scaleWeightService->createScaleWeight([
                    "scale_id" => $this->scale->id,
                    "weight" => $weight
                ]);

                if ($this->scale->send_error_notification) {
                    $this->scale->send_error_notification = false;
                    $this->scale->last_error = null;
                    $this->scale->last_error_date = null;
                    $this->scale->save();
                    $notificationFabric
                        ->sendNotifications("Связь с весами {$this->scale->ip_address}:{$this->scale->port} восстановлена.");
                }

                break;

            } catch (\Exception $exception) {
                Log::info($exception->getMessage());
            }
        }

        if ($retry == 0) {
            // Если в БД стоит 0, то можно отправлять письмо
            if (!$this->scale->send_error_notification) {
                $error = "Количество попыток для получения данных с весов по адресу ({$this->scale->ip_address}:{$this->scale->port}) истекло.";
                Log::info($error);
                $notificationFabric
                    ->sendNotifications($exception->getMessage() . "\n", [$error]);

                $this->scale->send_error_notification = true;
                $this->scale->last_error = $exception->getMessage() . " | " . $error;
                $this->scale->last_error_date = Carbon::now();
                $this->scale->save();
            }
        }
    }
}
