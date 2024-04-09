<?php

namespace App\Http\Controllers;

use App\Contracts\BackupPriority\BackupPriorityServiceInterface;
use App\Http\Requests\BackupPriority\BackupPriorityCollectionRequest;
use App\Http\Requests\BackupPriority\BackupPriorityStoreRequest;
use App\Http\Requests\BackupPriority\BackupPriorityUpdateRequest;
use App\Http\Resources\Admin\Dashboard\BackupPriority\BackupPriorityCollectionResource;
use App\Http\Resources\Admin\Dashboard\BackupPriority\BackupPriorityShowResource;
use App\Http\Resources\Admin\Dashboard\BackupPriority\BackupPriorityStoreResource;
use App\Http\Resources\Admin\Dashboard\BackupPriority\BackupPriorityUpdateResource;
use Inertia\Inertia;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class BackupPriorityController extends BaseController
{
    /**
     * @param BackupPriorityServiceInterface $backupPriorityService
     */
    public function __construct(
        private BackupPriorityServiceInterface $backupPriorityService
    ){}

    /**
     * Return backup priority index page
     * @return \Inertia\Response
     */
    public function index(): \Inertia\Response
    {
        return Inertia::render('BackupPriority/BackupPriorityIndex');
    }

    /**
     * Return backup priority create page
     * @return \Inertia\Response
     */
    public function create(): \Inertia\Response
    {
        return Inertia::render('BackupPriority/BackupPriorityCreate');
    }

    /**
     * Create backup priority and return entity
     * @param BackupPriorityStoreRequest $request
     * @return JsonResponse
     */
    public function store(BackupPriorityStoreRequest $request): JsonResponse
    {
        $data = $request->validated();

        $priority = $this
            ->backupPriorityService
            ->createBackupPriority($data);

        return $this->response(
            ['backupPriority' => BackupPriorityStoreResource::make($priority)],
            'Backup priority was created',
            true,
            Response::HTTP_CREATED
        );
    }

    /**
     * Get backup priority by id
     * @param int $id
     * @return JsonResponse
     */
    public function show(int $id): JsonResponse
    {
        $priority = $this
            ->backupPriorityService
            ->getBackupPriorityById($id);

        if (!$priority) {
            return $this->response(
                ['backupPriority' => []],
                'Backup priority by id:' . $id,
                false,
                Response::HTTP_OK
            );
        }

        return $this->response(
            ['backupPriority' => BackupPriorityShowResource::make($priority)],
            "Backup priority by id:$id",
            true,
            Response::HTTP_OK
        );
    }

    /**
     * @param int $id
     * @return \Inertia\Response
     */
    public function edit(int $id): \Inertia\Response
    {
        return Inertia::render('BackupPriority/BackupPriorityEdit', ['id'=>$id]);
    }

    /**
     * Update backup priority by id
     * @param BackupPriorityUpdateRequest $request
     * @param int $id
     * @return JsonResponse
     */
    public function update(BackupPriorityUpdateRequest $request, int $id)
    {
        $data = $request->validated();

        $model = $this
            ->backupPriorityService
            ->updateBackupPriority($id, $data);

        return $this->response(
            ['backupPriority' => BackupPriorityUpdateResource::make($model)],
            "Updated backup priority by id:$id",
            true,
            Response::HTTP_OK
        );
    }

    /**
     * Delete backup priority by id
     * @param int $id
     * @return JsonResponse
     */
    public function destroy(int $id): JsonResponse
    {
        $isDelete = $this
            ->backupPriorityService
            ->deleteBackupPriority($id);

        return $this->response(
            ['delete' => $isDelete],
            "Backup priority was deleted with id:$id",
            true,
            Response::HTTP_OK
        );
    }

    /**
     * Get all backup priority entities with pagination
     * @param BackupPriorityCollectionRequest $request
     * @return JsonResponse
     */
    public function getAllBackupPriorityWithPagination(BackupPriorityCollectionRequest $request): JsonResponse
    {
        $data = $request->validated();

        $priorities = $this
            ->backupPriorityService
            ->getAllBackupPrioritiesWithPagination($data['limit'], $data);

        return response()->json([
            'data' => BackupPriorityCollectionResource::collection($priorities),
            'count' => $priorities->total()
        ]);
    }

    /**
     * Get all backup priority collection
     * @return JsonResponse
     */
    public function getAllBackupPriorityCollection(): JsonResponse
    {
        $priorities = $this
            ->backupPriorityService
            ->getAllBackupPrioritiesCollection([]);

        return $this->response(
            ['backupPriorities' => BackupPriorityCollectionResource::collection($priorities)],
            'Backup priority  collection',
            true,
            Response::HTTP_OK
        );
    }
}
