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

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        /** @var ScaleApiServiceInterface $scalesApiService */
        $scalesApiService = app(ScaleApiServiceInterface::class);

        /** @var ScaleWeightServiceInterface $scaleWeightService */
        $scaleWeightService = app(ScaleWeightServiceInterface::class);

        try {
//            $scalesApiService
//                ->getScaleInfo($config['ip'], $config['port']);
//
//            $socket = $scalesApiService
//                ->getSocket($config['ip'], $config['port']);
//
//            $dataFormScale = $scalesApiService
//                ->sendCommandToSocket($socket);
//
//            $convertDataToDecFromScale = $scalesApiService
//                ->convertHexToDec($dataFormScale, [6, 7, 8, 9]);
//
//            $bytesWight = $scalesApiService
//                ->convertHexArrayDataToWeightForScale($convertDataToDecFromScale);
//
//            $result = $bytesWight / 100;


            $weight = $scalesApiService->getWeight($this->scale->ip, $this->scale->port);
            $scaleWeightService->createScaleWeight([
                "scale_id" => $this->scale->id,
                "weight" => $weight
            ]);

        } catch (\Exception $exception) {
            Log::info($exception->getMessage());
        }
    }
}
