<?php

namespace App\Http\Controllers;

use App\Contracts\ScaleWeight\ScaleWeightServiceInterface;
use App\Exports\ScaleWeightExport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class ExcelController extends Controller
{
    public function __construct(
        private ScaleWeightServiceInterface $scaleWeightService
    ) {}

    /**
     * @param Request $request
     * @return BinaryFileResponse
     */
    public function exportScaleWeight(Request $request): BinaryFileResponse
    {
        return Excel::download(
            new ScaleWeightExport($this->scaleWeightService, $request),
            'scales-weight.xlsx'
        );
    }
}
