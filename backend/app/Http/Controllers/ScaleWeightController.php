<?php

namespace App\Http\Controllers;

use App\Contracts\Scale\ScaleServiceInterface;
use App\Contracts\ScaleWeight\ScaleWeightServiceInterface;
use App\Http\Resources\Admin\Dashboard\Scale\ScaleShowResource;
use App\Http\Resources\Admin\Dashboard\ScaleWeight\ScaleWeightResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ScaleWeightController extends Controller
{
    public function __construct(
        private ScaleWeightServiceInterface $scaleWeightService,
        private ScaleServiceInterface $scaleService
    ){}

    /**
     * Get scale details with pagination
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function getScaleDetailById(Request $request): JsonResponse
    {
        $data = $request->all();

        $scale = $this->scaleService->getScaleById($data["id"]);

        $details = $this
            ->scaleWeightService
            ->getAllScalesWeightWithPagination(1000, $data);

        return response()->json([
            'data' => ScaleWeightResource::collection($details),
            'count' => $details->total(),
            'scale' => ScaleShowResource::make($scale)
        ]);
    }
}
