<?php

namespace App\Jobs;

use App\Contracts\Scale\ScaleApiServiceInterface;
use App\Contracts\Scale\ScaleServiceInterface;
use App\Contracts\ScaleWeight\ScaleWeightServiceInterface;
use App\Models\Scale;
use Illuminate\Bus\Queueable;
use Illuminate\Console\Command;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class GetScaleWeightJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(
        private Scale $scale
    ){}

//    public $tries = 3;
//    public $retryAfter = 5;

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

        while ($retry != 0) {
            try {
                $retry--;
                $weight = $scalesApiService->getWeight($this->scale->ip_address, $this->scale->port);

                if ($weight > 100.00) {
                    throw new \Exception("Весы вернули большой вес ({$weight}). Проверь весы");
                }

                $scaleWeightService->createScaleWeight([
                    "scale_id" => $this->scale->id,
                    "weight" => $weight
                ]);

                break;

            } catch (\Exception $exception) {
                Log::info($exception->getMessage());
            }
        }

        if ($retry == 0) {
            Log::info("Количество попыток для получения данных с ({$this->scale->ip_address}) истекло");
            // send email
            // send telegram message
        }
    }
}
