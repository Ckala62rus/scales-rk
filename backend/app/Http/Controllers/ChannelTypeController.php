<?php

namespace App\Http\Controllers;

use App\Contracts\ChannelType\ChannelTypeServiceInterface;
use App\Http\Requests\ChannelType\ChannelTypeCollectionRequest;
use App\Http\Requests\ChannelType\ChannelTypeStoreRequest;
use App\Http\Requests\ChannelType\ChannelTypeUpdateRequest;
use App\Http\Resources\Admin\Dashboard\ChannelType\ChannelTypeCollectionResource;
use App\Http\Resources\Admin\Dashboard\ChannelType\ChannelTypeShowResource;
use App\Http\Resources\Admin\Dashboard\ChannelType\ChannelTypeStoreResource;
use App\Http\Resources\Admin\Dashboard\ChannelType\ChannelTypeUpdateResource;
use Inertia\Inertia;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class ChannelTypeController extends BaseController
{
    /**
     * @param ChannelTypeServiceInterface $channelTypeService
     */
    public function __construct(
        private ChannelTypeServiceInterface $channelTypeService
    ){}

    /**
     * Return index channel type view
     * @return \Inertia\Response
     */
    public function index(): \Inertia\Response
    {
        return Inertia::render('ChannelType/ChannelTypeIndex');
    }

    /**
     * Return create view
     * @return \Inertia\Response
     */
    public function create(): \Inertia\Response
    {
        return Inertia::render('ChannelType/ChannelTypeCreate');
    }

    /**
     * Create channel type entity
     * @param ChannelTypeStoreRequest $request
     * @return JsonResponse
     */
    public function store(ChannelTypeStoreRequest $request): JsonResponse
    {
        $data = $request->validated();

        $channelType = $this
            ->channelTypeService
            ->createChannelType($data);

        return $this->response(
            ['channelType' => ChannelTypeStoreResource::make($channelType)],
            'Channel type was created',
            true,
            Response::HTTP_CREATED
        );
    }

    /**
     * Get channel type entity by id
     * @param int $id
     * @return JsonResponse
     */
    public function show(int $id): JsonResponse
    {
        $model = $this
            ->channelTypeService
            ->getChannelTypeById($id);

        if (!$model) {
            return $this->response(
                ['channelType' => []],
                'Get channel-type entity by id:' . $id,
                false,
                Response::HTTP_OK
            );
        }

        return $this->response(
            ['channelType' => ChannelTypeShowResource::make($model)],
            'Channel type was created',
            true,
            Response::HTTP_OK
        );
    }

    /**
     * Return edit channel type view
     * @param int $id
     * @return \Inertia\Response
     */
    public function edit(int $id): \Inertia\Response
    {
        return Inertia::render('ChannelType/ChannelTypeEdit', ['id' => $id]);
    }

    /**
     * Update channel type entity by id
     * @param ChannelTypeUpdateRequest $request
     * @param int $id
     * @return JsonResponse
     */
    public function update(ChannelTypeUpdateRequest $request, int $id): JsonResponse
    {
        $model = $this
            ->channelTypeService
            ->updateChannelType($id, $request->validated());

        return $this->response(
            ['channelType' => ChannelTypeUpdateResource::make($model)],
            "Update channel-type by id:$id",
            true,
            Response::HTTP_OK
        );
    }

    /**
     * Delete channel type by id
     * @param int $id
     * @return JsonResponse
     */
    public function destroy(int $id): JsonResponse
    {
        $isDelete = $this
            ->channelTypeService
            ->deleteChannelType($id);

        return $this->response(
            ['delete' => $isDelete],
            "Channel type was deleted with id:$id",
            true,
            Response::HTTP_OK
        );
    }

    /**
     * Get all channel type with pagination
     * @param ChannelTypeCollectionRequest $request
     * @return JsonResponse
     */
    public function getAllChannelTypeWithPagination(ChannelTypeCollectionRequest $request): JsonResponse
    {
        $data = $request->validated();

        $isp = $this
            ->channelTypeService
            ->getAllChannelTypesWithPagination($data['limit'], $data);

        return response()->json([
            'data' => ChannelTypeCollectionResource::collection($isp),
            'count' => $isp->total()
        ]);
    }

    /**
     * Get all channel type collection
     * @return JsonResponse
     */
    public function getAllChannelTypeCollection(): JsonResponse
    {
        $days = $this
            ->channelTypeService
            ->getAllChannelTypesCollection([]);

        return $this->response(
            ['channelType' => ChannelTypeCollectionResource::collection($days)],
            'Channel type collection',
            true,
            Response::HTTP_OK
        );
    }
}
