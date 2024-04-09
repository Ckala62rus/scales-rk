<?php

namespace App\Exports;

use App\Contracts\Backup\BackupServiceInterface;
use App\Http\Resources\Excel\BackupExportCollectionResource;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;

class BackupsExport implements FromCollection, WithHeadings, ShouldAutoSize//, WithEvents
{
    public function __construct(
        private Request $request,
        private BackupServiceInterface $backupService,
    ){}

    public function collection()
    {
        $data = $this
            ->backupService
            ->getAllBackupsCollection($this->request->all());

        return BackupExportCollectionResource::collection($data);
    }

    public function registerEvents(): array
    {
        // TODO: Implement registerEvents() method.
    }

    public function headings(): array
    {
        return [
            'Id',
            'Organization',
            'Service',
            'Owner',
            'Hostname',
            'Object',
            'Tool',
            'BD',
            'Restricted point',
            'Type',
            'Day',
            'Time start',
            'Storage server',
            'Storage long time',
            'Description storage long time',
            'Created at',
            'Updated at',
        ];
    }
}
