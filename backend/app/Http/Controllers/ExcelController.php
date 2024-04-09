<?php

namespace App\Http\Controllers;

use App\Contracts\Backup\BackupServiceInterface;
use App\Contracts\DeviceServiceInterface;
use App\Exports\BackupsExport;
use App\Exports\DevicesExport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class ExcelController extends Controller
{
    /**
     * @var DeviceServiceInterface
     */
    private DeviceServiceInterface $deviceService;

    /**
     * @param DeviceServiceInterface $deviceService
     * @param BackupServiceInterface $backupService
     */
    public function __construct(
        DeviceServiceInterface $deviceService,
        private BackupServiceInterface $backupService
    ) {
        $this->deviceService = $deviceService;
    }

    /**
     * @param Request $request
     * @return BinaryFileResponse
     */
    public function exportDevice(Request $request): BinaryFileResponse
    {
        return Excel::download(new DevicesExport($request, $this->deviceService),'devices.xlsx');
    }

    /**
     * @param Request $request
     * @return BinaryFileResponse
     */
    public function exportBackup(Request $request): BinaryFileResponse
    {
        return Excel::download(new BackupsExport($request, $this->backupService), 'backup.xlsx');
    }
}
