<?php

namespace App\Exports;

use App\Contracts\DeviceServiceInterface;
use App\Http\Resources\Excel\DeviceExportCollectionResource;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Color;

class DevicesExport implements FromCollection, WithHeadings, ShouldAutoSize, WithEvents
{
    /**
     * @var DeviceServiceInterface
     */
    private DeviceServiceInterface $deviceService;

    /**
     * @var array
     */
    protected array $filter;

    /**
     * @param Request $request
     * @param DeviceServiceInterface $deviceService
     */
    public function __construct(Request $request, DeviceServiceInterface $deviceService)
    {
        $this->deviceService = $deviceService;
        $this->filter = $request->all();
    }

    public function collection()
    {
        $data = $this
            ->deviceService
            ->getAllDevicesCollection($this->filter);

        return DeviceExportCollectionResource::collection($data);
    }

    public function headings(): array
    {
        return [
            'Id',
            'Org',
            'Type',
            'Hostname',
            'Model',
            'Description service',
            'Operation system',
            'Cpu',
            'Count core',
            'Count core with ht',
            'Memory',
            'Hdd',
            'Ssd',
            'Address',
            'Comment',
            'Date buy',
            'Date update',
            'User',
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class    => function(AfterSheet $event) {
                $event
                    ->sheet
                    ->getDelegate()
                    ->getStyle('A1:R1')
                    ->applyFromArray([
                        'font' => [
                            'bold' => true,
                            'color' => ['argb' => 'ffffff'],
                            'size' => 14,
                        ],
                    ])
                    ->getFill()
                    ->setFillType(Fill::FILL_SOLID)
                    ->getStartColor()
                    ->setARGB('217346');
            },
        ];
    }
}
