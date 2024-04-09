<?php

namespace App\Http\Controllers;

use App\Contracts\EquipmentServiceInterface;
use App\Http\Requests\Equipment\EquipmentCollectionRequest;
use App\Http\Requests\Equipment\EquipmentStoreRequest;
use App\Http\Requests\Equipment\EquipmentUpdateRequest;
use App\Http\Resources\Admin\Dashboard\Equipment\EquipmentCollectionResource;
use App\Http\Resources\Admin\Dashboard\Equipment\EquipmentStoreResource;
use App\Http\Resources\Admin\Dashboard\EquipmentShowResource;
use Inertia\Inertia;
use Inertia\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class EquipmentController extends BaseController
{
    /**
     * @var EquipmentServiceInterface
     */
    private EquipmentServiceInterface $equipmentService;

    public function __construct(EquipmentServiceInterface $equipmentService)
    {
        $this->equipmentService = $equipmentService;
    }

    /**
     * Return index view
     * @return Response
     */
    public function index(): Response
    {
        return Inertia::render('Equipment/EquipmentIndex');
    }

    /**
     * Return create view
     * @return Response
     */
    public function create(): Response
    {
        return Inertia::render('Equipment/EquipmentCreate');
    }

    /**
     * Create equipment
     * @param EquipmentStoreRequest $request
     * @return JsonResponse
     */
    public function store(EquipmentStoreRequest $request): JsonResponse
    {
        $data = $request->validated();
        $equipment = $this->equipmentService->createEquipment($data);
        return $this->response(
            ['equipment' => EquipmentStoreResource::make($equipment)],
            'Equipment was created',
            true,
            ResponseAlias::HTTP_CREATED
        );
    }

    /**
     * Get equipment by id
     * @param int $id
     * @return JsonResponse
     */
    public function show(int $id):JsonResponse
    {
        $equipment = $this->equipmentService->getEquipmentById($id);

        if (!$equipment) {
            return $this->response(
                ['equipment' => null],
                'Equipment by id ' . $id,
                false,
                ResponseAlias::HTTP_OK
            );
        }

        return $this->response(
            ['equipment' => EquipmentShowResource::make($equipment)],
            'Equipment by id ' . $id,
            true,
            ResponseAlias::HTTP_OK
        );
    }

    /**
     * Return edit view
     * @param int $id
     * @return Response
     */
    public function edit(int $id): Response
    {
        return Inertia::render('Equipment/EquipmentEdit', ['id' => $id]);
    }

    /**
     * Edit equipment by id
     * @param EquipmentUpdateRequest $request
     * @param int $id
     * @return JsonResponse
     */
    public function update(EquipmentUpdateRequest $request, int $id): JsonResponse
    {
        $data = $request->validated();
        $equipment = $this->equipmentService->updateEquipment($id, $data);
        return $this->response(
            ['equipment' => EquipmentShowResource::make($equipment)],
            'Update equipment by id ' . $id,
            true,
            ResponseAlias::HTTP_OK
        );
    }

    /**
     * Delete equipment by id
     * @param int $id
     * @return JsonResponse
     */
    public function destroy(int $id): JsonResponse
    {
        $isDelete = $this->equipmentService->deleteEquipment($id);
        return $this->response(
            [$isDelete],
            'Equipment was deleted',
            true,
            ResponseAlias::HTTP_OK
        );
    }

    /**
     * Get all equipment collection with paginate
     * @param EquipmentCollectionRequest $request
     * @return JsonResponse
     */
    public function getAllEquipmentsWithPagination(EquipmentCollectionRequest $request): JsonResponse
    {
        $data = $request->validated();

        $equipments = $this
            ->equipmentService
            ->getAllEquipmentsWithPagination($data['limit']);

        return response()->json([
            'data' => EquipmentCollectionResource::collection($equipments),
            'count' => $equipments->total()
        ]);
    }

    /**
     * Get all equipments collection
     * @return JsonResponse
     */
    public function getAllEquipmentsCollection(): JsonResponse
    {
        $equipments = $this
            ->equipmentService
            ->getAllEquipmentsCollection();

        return $this->response(
            ['equipments' => $equipments],
            'Organization was deleted',
            true,
            ResponseAlias::HTTP_OK
        );
    }
}
