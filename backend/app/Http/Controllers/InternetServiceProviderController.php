<?php

namespace App\Http\Controllers;

use App\Contracts\InternetServiceProvider\InternetServiceProviderServiceInterface;
use App\Http\Requests\InternetServiceProvider\InternetServiceProviderCollectionRequest;
use App\Http\Requests\InternetServiceProvider\InternetServiceProviderStoreRequest;
use App\Http\Requests\InternetServiceProvider\InternetServiceProviderUpdateRequest;
use App\Http\Resources\Admin\Dashboard\InternetServiceProvider\InternetServiceProviderCollectionResource;
use App\Http\Resources\Admin\Dashboard\InternetServiceProvider\InternetServiceProviderShowResource;
use App\Http\Resources\Admin\Dashboard\InternetServiceProvider\InternetServiceProviderStoreResource;
use App\Http\Resources\Admin\Dashboard\InternetServiceProvider\InternetServiceProviderUpdateResource;
use Inertia\Inertia;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class InternetServiceProviderController extends BaseController
{
    /**
     * @param InternetServiceProviderServiceInterface $internetServiceProviderService
     */
    public function __construct(
        private InternetServiceProviderServiceInterface $internetServiceProviderService
    ){}

    /**
     * @return \Inertia\Response
     */
    public function index(): \Inertia\Response
    {
        return Inertia::render('InternetServiceProvider/InternetServiceProviderIndex');
    }

    /**
     * @return \Inertia\Response
     */
    public function create(): \Inertia\Response
    {
        return Inertia::render('InternetServiceProvider/InternetServiceProviderCreate');
    }

    /**
     * Create internet store provider entity
     * @param InternetServiceProviderStoreRequest $request
     * @return JsonResponse
     */
    public function store(InternetServiceProviderStoreRequest $request): JsonResponse
    {
        $model = $this
            ->internetServiceProviderService
            ->createInternetServiceProvider($request->validated());

        return $this->response(
            ['isp' => InternetServiceProviderStoreResource::make($model)],
            'Internet service provider was created',
            true,
            Response::HTTP_CREATED
        );
    }

    /**
     * Get internet service provider by id
     * @param int $id
     * @return JsonResponse
     */
    public function show(int $id): JsonResponse
    {
        $model = $this
            ->internetServiceProviderService
            ->getInternetServiceProviderById($id);

        if (!$model)
        {
            return $this->response(
                ['isp' => []],
                'Internet service provider not found',
                false,
                Response::HTTP_OK
            );
        }

        return $this->response(
            ['isp' => InternetServiceProviderShowResource::make($model)],
            'Internet service provider by id:' . $id,
            true,
            Response::HTTP_OK
        );
    }

    /**
     * Return edit isp page view
     * @param int $id
     * @return \Inertia\Response
     */
    public function edit(int $id): \Inertia\Response
    {
        return Inertia::render('InternetServiceProvider/InternetServiceProviderEdit', ['id' => $id]);
    }

    /**
     * Update internet service provider by id
     * @param InternetServiceProviderUpdateRequest $request
     * @param int $id
     * @return JsonResponse
     */
    public function update(InternetServiceProviderUpdateRequest $request, int $id): JsonResponse
    {
        $model = $this
            ->internetServiceProviderService
            ->updateInternetServiceProvider($id, $request->validated());

        return $this->response(
            ['isp' => InternetServiceProviderUpdateResource::make($model)],
            'Internet service provider was updated',
            true,
            Response::HTTP_OK
        );
    }

    /**
     * Delete internet service provider by id
     * @param int $id
     * @return JsonResponse
     */
    public function destroy(int $id): JsonResponse
    {
        $isDelete = $this
            ->internetServiceProviderService
            ->deleteInternetServiceProvider($id);

        return $this->response(
            ['isDelete' => $isDelete],
            "Internet service provider was deleted with id:$id",
            true,
            Response::HTTP_OK
        );
    }

    /**
     * Get all internet service provider with pagination
     * @param InternetServiceProviderCollectionRequest $request
     * @return JsonResponse
     */
    public function getAllIspWithPagination(InternetServiceProviderCollectionRequest $request): JsonResponse
    {
        $data = $request->validated();

        $isp = $this
            ->internetServiceProviderService
            ->getAllInternetServiceProvidersWithPagination($data['limit'], $data);

        return response()->json([
            'data' => InternetServiceProviderCollectionResource::collection($isp),
            'count' => $isp->total()
        ]);
    }
}
