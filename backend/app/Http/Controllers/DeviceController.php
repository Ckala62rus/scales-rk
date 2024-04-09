<?php

namespace App\Http\Controllers;

use App\Contracts\DeviceServiceInterface;
use App\Http\Requests\Device\DeviceCollectionRequest;
use App\Http\Requests\Device\DeviceStoreRequest;
use App\Http\Requests\Device\DeviceUpdateRequest;
use App\Http\Resources\Admin\Dashboard\Device\DeviceCollectionResource;
use App\Http\Resources\Admin\Dashboard\Device\DeviceShowResource;
use App\Http\Resources\Admin\Dashboard\Device\DeviceStoreResource;
use Inertia\Inertia;
use Inertia\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class DeviceController extends BaseController
{
    /**
     * @var DeviceServiceInterface
     */
    private DeviceServiceInterface $deviceService;

    /**
     * @param DeviceServiceInterface $deviceService
     */
    public function __construct(DeviceServiceInterface $deviceService)
    {
        $this->deviceService = $deviceService;
    }

    /**
     * Return index devices page
     * @return Response
     */
    public function index(): Response
    {
        return Inertia::render('Device/DeviceIndex');
    }

    /**
     * Return create device page
     * @return Response
     */
    public function create(): Response
    {
        return Inertia::render('Device/DeviceCreate');
    }

    /**
     * Create device
     * @param DeviceStoreRequest $request
     * @return JsonResponse
     */
    public function store(DeviceStoreRequest $request): JsonResponse
    {
        $data = $request->validated();
        try
        {
            $device = $this
                ->deviceService
                ->createDevice($data);
        }
        catch (\Exception $exception)
        {
            return $this->response(
                ['device' => null],
                $exception->getMessage(),
                false,
                ResponseAlias::HTTP_OK
            );
        }
        return $this->response(
            ['device' => DeviceStoreResource::make($device)],
            'Device was created',
            true,
            ResponseAlias::HTTP_CREATED
        );
    }

    /**
     * Get device by id
     * @param int $id
     * @return JsonResponse
     */
    public function show(int $id): JsonResponse
    {
        $device = $this
            ->deviceService
            ->getDeviceById($id);

        if (!$device) {
            return $this->response(
                ['device' => null],
                "Device with id:$id not found!",
                false,
                ResponseAlias::HTTP_OK
            );
        }

        return $this->response(
            ['device' => DeviceShowResource::make($device)],
            'Device with id:' . $id,
            true,
            ResponseAlias::HTTP_OK
        );
    }

    /**
     * Return edit page
     * @param int $id
     * @return Response
     */
    public function edit(int $id): Response
    {
        return Inertia::render('Device/DeviceEdit', ['id' => $id]);
    }

    /**
     * Update device by id
     * @param DeviceUpdateRequest $request
     * @param int $id
     * @return JsonResponse
     */
    public function update(DeviceUpdateRequest $request, int $id): JsonResponse
    {
        $data = $request->validated();

        $device = $this
            ->deviceService
            ->updateDevice($id, $data);

        return $this->response(
            ['device' => DeviceShowResource::make($device)],
            'Device was updated',
            true,
            ResponseAlias::HTTP_OK
        );
    }

    /**
     * Delete device by id
     * @param int $id
     * @return JsonResponse
     */
    public function destroy(int $id): JsonResponse
    {
        try
        {
            $isDelete = $this
                ->deviceService
                ->deleteDevice($id);
        }
        catch (\Exception $exception)
        {
            return $this->response(
                ['delete' => false],
                $exception->getMessage(),
                false,
                ResponseAlias::HTTP_OK
            );
        }

        return $this->response(
            ['delete' => $isDelete],
            'Device was deleted',
            true,
            ResponseAlias::HTTP_OK
        );
    }

    /**
     * Get all devices with pagination
     * @param DeviceCollectionRequest $request
     * @return JsonResponse
     */
    public function getAllDeviceWithPagination(DeviceCollectionRequest $request): JsonResponse
    {
        $data = $request->validated();

        $devices = $this
            ->deviceService
            ->getAllDevicesWithPagination($data['limit'], $data);

        return response()->json([
            'data' => DeviceCollectionResource::collection($devices),
            'count' => $devices->total()
        ]);
    }
}
