<?php

namespace App\Exports;

use App\Contracts\ScaleWeight\ScaleWeightServiceInterface;
use App\Http\Resources\Admin\Dashboard\ScaleWeight\ScaleWeightExcelCollectionResource;
use App\Http\Resources\Admin\Dashboard\ScaleWeight\ScaleWeightResource;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ScaleWeightExport implements FromCollection, WithHeadings, ShouldAutoSize
{
    /**
     * @param ScaleWeightServiceInterface $scaleWeightService
     * @param Request $request
     */
    public function __construct(
        private ScaleWeightServiceInterface $scaleWeightService,
        private Request $request,
    ) {
        $this->filter = $request;
    }

    public function collection()
    {
        $data = $this
            ->scaleWeightService
            ->getAllScalesWeightCollection($this->request->all());

        return ScaleWeightExcelCollectionResource::collection($data);
    }

    public function headings(): array
    {
        return [
            'Id',
            'Идентификатор весов (scale_id)',
            'Вес',
            'Дата создания записи',
        ];
    }
}
