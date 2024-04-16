<?php

namespace App\Console\Commands;

use App\Contracts\Scale\ScaleApiServiceInterface;
use App\Contracts\Scale\ScaleServiceInterface;
use App\Jobs\GetScaleWeightJob;
use Illuminate\Console\Command;

class GetScaleWeightCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:GetScaleWeightCommand';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     * clear && php artisan command:GetScaleWeightCommand
     *
     * @return int
     */
    public function handle()
    {
        /** @var ScaleServiceInterface $scalesService */
        $scalesService = app(ScaleServiceInterface::class);

        $scales = $scalesService->getAllScalesCollection([]);

        foreach ($scales as $scale) {
            GetScaleWeightJob::dispatch($scale)->onQueue("scale_weight");
        }
    }
}
