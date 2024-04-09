<?php

namespace App\Http\Controllers;

use App\Contracts\Day\BackupDayServiceInterface;
use App\Http\Requests\BackupDay\BackupDayCollectionRequest;
use App\Http\Requests\BackupDay\BackupDayStoreRequest;
use App\Http\Requests\BackupDay\BackupDayUpdateRequest;
use App\Http\Requests\BackupTool\BackupToolCollectionRequest;
use App\Http\Resources\Admin\Dashboard\BackupDay\BackupDayCollectionResource;
use App\Http\Resources\Admin\Dashboard\BackupDay\BackupDayShowResource;
use App\Http\Resources\Admin\Dashboard\BackupDay\BackupDayStoreResource;
use Inertia\Inertia;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class BackupDayController extends BaseController
{
    /**
     * @param BackupDayServiceInterface $backupDayService
     */
    public function __construct(
        private BackupDayServiceInterface $backupDayService,
    ){}

    /**
     * Return index backup day view
     * @return \Inertia\Response
     */
    public function index(): \Inertia\Response
    {
        return Inertia::render('BackupDay/BackupDayIndex');
    }

    /**
     * Return create backup day view
     * @return \Inertia\Response
     */
    public function create(): \Inertia\Response
    {
        return Inertia::render('BackupDay/BackupDayCreate');
    }

    /**
     * Create backup day entity
     * @param BackupDayStoreRequest $request
     * @return JsonResponse
     */
    public function store(BackupDayStoreRequest $request): JsonResponse
    {
        $data = $request->validated();

        $backupDay = $this
            ->backupDayService
            ->createBackupDay($data);

        return $this->response(
            ['backupDay' => BackupDayStoreResource::make($backupDay)],
            'backupDay was created',
            true,
            Response::HTTP_CREATED
        );
    }

    /**
     * Get backup entity by id
     * @param int $id
     * @return JsonResponse
     */
    public function show(int $id): JsonResponse
    {
        $day = $this
            ->backupDayService
            ->getBackupDayById($id);

        if (!$day)
        {

            return $this->response(
                ['backupDay' => []],
                "BackupDay by id:{$id} not found",
                false,
                Response::HTTP_OK
            );
        }

        return $this->response(
            ['backupDay' => BackupDayShowResource::make($day)],
            "Find backupDay by id:{$id}",
            true,
            Response::HTTP_OK
        );
    }

    /**
     * Return edit backup day view
     * @param int $id
     * @return \Inertia\Response
     */
    public function edit(int $id): \Inertia\Response
    {
        return Inertia::render('BackupDay/BackupDayEdit', ['id' => $id]);
    }

    /**
     * Update backup day by id
     * @param BackupDayUpdateRequest $request
     * @param int $id
     * @return JsonResponse
     */
    public function update(BackupDayUpdateRequest $request, int $id): JsonResponse
    {
        $data = $request->validated();

        $day = $this
            ->backupDayService
            ->updateBackupDay($id, $data);

        if (!$day)
        {
            return $this->response(
                ['backupDay' => []],
                "BackupDay by id:{$id} not found",
                false,
                Response::HTTP_OK
            );
        }

        return $this->response(
            ['backupDay' => BackupDayShowResource::make($day)],
            "Update backupDay by id:{$id}",
            true,
            Response::HTTP_OK
        );
    }

    /**
     * Delete backup day entity by id
     * @param int $id
     * @return JsonResponse
     */
    public function destroy(int $id): JsonResponse
    {
        $isDelete = $this
            ->backupDayService
            ->deleteBackupDay($id);

        return $this->response(
            ['isDelete' => $isDelete],
            "Delete backupDay by id:{$id}",
            true,
            Response::HTTP_OK
        );
    }

    /**
     * Get all backup day collection with pagination
     * @param BackupDayCollectionRequest $request
     * @return JsonResponse
     */
    public function getAllBackupDaysWithPagination(BackupDayCollectionRequest $request): JsonResponse
    {
        $data = $request->all();

        $days = $this
            ->backupDayService
            ->getAllBackupDaysWithPagination($data["limit"], $data);

        return response()->json([
            'data' => BackupDayCollectionResource::collection($days),
            'count' => $days->total()
        ]);
    }

    /**
     * Get all backup day collection
     * @return JsonResponse
     */
    public function getAllBackupDayCollection(): JsonResponse
    {
        $days = $this
            ->backupDayService
            ->getAllBackupDaysCollection([]);

        return $this->response(
            ['backupDays' => BackupDayCollectionResource::collection($days)],
            'BackupDays collection',
            true,
            Response::HTTP_OK
        );
    }
}
