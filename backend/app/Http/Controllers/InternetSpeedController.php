<?php

namespace App\Http\Controllers;

use App\Contracts\InternetSpeed\InternetSpeedServiceInterface;
use App\Http\Requests\InternetSpeed\InternetSpeedCollectionRequest;
use App\Http\Requests\InternetSpeed\InternetSpeedStoreRequest;
use App\Http\Requests\InternetSpeed\InternetSpeedUpdateRequest;
use App\Http\Resources\Admin\Dashboard\InternetSpeed\InternetSpeedCollectionResource;
use App\Http\Resources\Admin\Dashboard\InternetSpeed\InternetSpeedShowResource;
use App\Http\Resources\Admin\Dashboard\InternetSpeed\InternetSpeedStoreResource;
use App\Http\Resources\Admin\Dashboard\InternetSpeed\InternetSpeedUpdateResource;
use Inertia\Inertia;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class InternetSpeedController extends BaseController
{
    /**
     * @param InternetSpeedServiceInterface $internetSpeedService
     */
    public function __construct(
        private InternetSpeedServiceInterface $internetSpeedService
    ){}

    /**
     * Return internet speed view
     * @return \Inertia\Response
     */
    public function index(): \Inertia\Response
    {
        return Inertia::render('InternetSpeed/InternetSpeedIndex');
    }

    /**
     * Return internet speed view
     * @return \Inertia\Response
     */
    public function create(): \Inertia\Response
    {
        return Inertia::render('InternetSpeed/InternetSpeedCreate');
    }

    /**
     * Create internet speed entity
     * @param InternetSpeedStoreRequest $request
     * @return JsonResponse
     */
    public function store(InternetSpeedStoreRequest $request): JsonResponse
    {
        $data = $request->validated();

        $model = $this
            ->internetSpeedService
            ->createInternetSpeed($data);

        return $this->response(
            ['internetSpeed' => InternetSpeedStoreResource::make($model)],
            'Internet-speed was created',
            true,
            Response::HTTP_CREATED
        );
    }

    /**
     * Get internet speed entity by id
     * @param int $id
     * @return JsonResponse
     */
    public function show(int $id): JsonResponse
    {
        $model = $this
            ->internetSpeedService
            ->getInternetSpeedById($id);

        if (!$model) {
            return $this->response(
                ['internetSpeed' => []],
                'Get internet-speed entity by id:' . $id,
                false,
                Response::HTTP_OK
            );
        }

        return $this->response(
            ['internetSpeed' => InternetSpeedShowResource::make($model)],
            "Find internet-speed by id:$id",
            true,
            Response::HTTP_OK
        );
    }

    /**
     * Return internet speed view
     * @param int $id
     * @return \Inertia\Response
     */
    public function edit(int $id): \Inertia\Response
    {
        return Inertia::render('InternetSpeed/InternetSpeedEdit', ['id' => $id]);
    }

    /**
     * Update internet speed entity by id
     * @param InternetSpeedUpdateRequest $request
     * @param int $id
     * @return JsonResponse
     */
    public function update(InternetSpeedUpdateRequest $request, int $id): JsonResponse
    {
        $data = $request->validated();

        $model = $this
            ->internetSpeedService
            ->updateInternetSpeed($id, $data);

        return $this->response(
            ['internetSpeed' => InternetSpeedUpdateResource::make($model)],
            "Update internet-speed by id:$id",
            true,
            Response::HTTP_OK
        );
    }

    /**
     * Delete internet-speed entity by id
     * @param int $id
     * @return JsonResponse
     */
    public function destroy(int $id): JsonResponse
    {
        $isDelete = $this
            ->internetSpeedService
            ->deleteInternetSpeed($id);

        return $this->response(
            ['delete' => $isDelete],
            "Internet-speed was deleted with id:$id",
            true,
            Response::HTTP_OK
        );
    }

    /**
     * Get all internet speed entity with collection
     * @param InternetSpeedCollectionRequest $request
     * @return JsonResponse
     */
    public function getAllInternetSpeedWithPagination(InternetSpeedCollectionRequest $request): JsonResponse
    {
        $data = $request->validated();

        $models = $this
            ->internetSpeedService
            ->getAllInternetSpeedsWithPagination($data['limit'], $data);

        return response()->json([
            'data' => InternetSpeedCollectionResource::collection($models),
            'count' => $models->total()
        ]);
    }

    /**
     * Get all internet speed collection
     * @return JsonResponse
     */
    public function getAllInternetSpeedCollection(): JsonResponse
    {
        $models = $this
            ->internetSpeedService
            ->getAllInternetSpeedsCollection([]);

        return $this->response(
            ['internetSpeed' => InternetSpeedCollectionResource::collection($models)],
            'Internet-speed collection',
            true,
            Response::HTTP_OK
        );
    }
}
