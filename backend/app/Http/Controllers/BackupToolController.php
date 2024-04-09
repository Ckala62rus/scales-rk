<?php

namespace App\Http\Controllers;

use App\Contracts\BackupTool\BackupToolServiceInterface;
use App\Http\Requests\BackupTool\BackupToolCollectionRequest;
use App\Http\Requests\BackupTool\BackupToolStoreRequest;
use App\Http\Requests\BackupTool\BackupToolUpdateRequest;
use App\Http\Resources\Admin\Dashboard\BackupTool\BackupToolCollectionResource;
use App\Http\Resources\Admin\Dashboard\BackupTool\BackupToolShowResource;
use App\Http\Resources\Admin\Dashboard\BackupTool\BackupToolStoreResource;
use App\Http\Resources\Admin\Dashboard\BackupTool\BackupToolUpdateResource;
use Inertia\Inertia;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class BackupToolController extends BaseController
{
    /**
     * @param BackupToolServiceInterface $backupToolService
     */
    public function __construct(
        private BackupToolServiceInterface $backupToolService
    ){}

    /**
     * @return \Inertia\Response
     */
    public function index(): \Inertia\Response
    {
        return Inertia::render('BackupTool/BackupToolIndex');
    }

    /**
     * @return \Inertia\Response
     */
    public function create(): \Inertia\Response
    {
        return Inertia::render('BackupTool/BackupToolCreate');
    }

    /**
     * Create backup tool entity
     * @param BackupToolStoreRequest $request
     * @return JsonResponse
     */
    public function store(BackupToolStoreRequest $request): JsonResponse
    {
        $tool = $this
            ->backupToolService
            ->createBackupTool($request->validated());

        return $this->response(
            ['backupTool' => BackupToolStoreResource::make($tool)],
            'backupTool was create',
            true,
            Response::HTTP_CREATED
        );
    }

    /**
     * Get backup tool by id
     * @param int $id
     * @return JsonResponse
     */
    public function show(int $id): JsonResponse
    {
        $tool = $this
            ->backupToolService
            ->getBackupToolById($id);

        if (!$tool)
        {
            return $this->response(
                ['backupTool' => []],
                'Backup tool not found by id:' . $id,
                false,
                Response::HTTP_OK
            );
        }

        return $this->response(
            ['backupTool' => BackupToolShowResource::make($tool)],
            'Find backup tool by id:' . $id,
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
        return Inertia::render('BackupTool/BackupToolEdit', ['id' => $id]);
    }

    /**
     * Update backup tool by id
     * @param BackupToolUpdateRequest $request
     * @param int $id
     * @return JsonResponse
     */
    public function update(BackupToolUpdateRequest $request, int $id): JsonResponse
    {
        $tool = $this
            ->backupToolService
            ->updateBackupTool($id, $request->validated());

        return $this->response(
            ['backupTool' => BackupToolUpdateResource::make($tool)],
            'Updated backup tool by id:' . $id,
            true,
            Response::HTTP_OK
        );
    }

    /**
     * Delete backup tool by id
     * @param int $id
     * @return JsonResponse
     */
    public function destroy(int $id): JsonResponse
    {
        $isDelete = $this
            ->backupToolService
            ->deleteBackupTool($id);

        return $this->response(
            ['isDelete' => $isDelete],
            'Delete backup tool by id:' . $id,
            true,
            Response::HTTP_OK
        );
    }

    /**
     * Get all backup tool with pagination
     * @param BackupToolCollectionRequest $request
     * @return JsonResponse
     */
    public function getAllBackupObjectsWithPagination(BackupToolCollectionRequest $request): JsonResponse
    {
        $data = $request->validated();

        $tools = $this
            ->backupToolService
            ->getAllBackupToolsWithPagination($data['limit'], $data);

        return response()->json([
            'data' => BackupToolCollectionResource::collection($tools),
            'count' => $tools->total()
        ]);
    }

    /**
     * Get all backup tools collection
     * @return JsonResponse
     */
    public function getAllBackupToolCollection(): JsonResponse
    {
        $objects = $this
            ->backupToolService
            ->getAllBackupToolsCollection([]);

        return $this->response(
            ['backupTools' => BackupToolCollectionResource::collection($objects)],
            'BackupTools collection',
            true,
            Response::HTTP_OK
        );
    }
}
