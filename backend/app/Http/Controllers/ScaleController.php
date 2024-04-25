<?php

namespace App\Http\Controllers;

use App\Contracts\Scale\ScaleServiceInterface;
use App\Http\Requests\Scale\ScaleCollectionRequest;
use App\Http\Requests\Scale\ScaleStoreRequest;
use App\Http\Requests\Scale\ScaleUpdateRequest;
use App\Http\Resources\Admin\Dashboard\Scale\ScaleCollectionResource;
use App\Http\Resources\Admin\Dashboard\Scale\ScaleShowResource;
use App\Http\Resources\Admin\Dashboard\Scale\ScaleStoreResource;
use Inertia\Inertia;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class ScaleController extends BaseController
{
    /**
     * @param ScaleServiceInterface $scaleService
     */
    public function __construct(
        private ScaleServiceInterface $scaleService
    ){}

    /**
     * Return vue component for index page
     *
     * @return \Inertia\Response
     */
    public function index(): \Inertia\Response
    {
        return Inertia::render('Scale/ScaleIndex');
    }

    /**
     * Return vue component for create page
     *
     * @return \Inertia\Response
     */
    public function create(): \Inertia\Response
    {
        return Inertia::render('Scale/ScaleCreate');
    }

    /**
     * Create new scale and return json model or error
     *
     * @param ScaleStoreRequest $request
     * @return JsonResponse
     */
    public function store(ScaleStoreRequest $request): JsonResponse
    {
        $data = $request->validated();
        try {
            $scale = $this
                ->scaleService
                ->createScale($data);
        } catch (\Exception $exception) {
            return $this->response(
                ['scale' => null],
                $exception->getMessage(),
                false,
                Response::HTTP_OK
            );
        }
        return $this->response(
            ['scale' => ScaleStoreResource::make($scale)],
            "Scale was created",
            true,
            Response::HTTP_OK
        );
    }

    /**
     * Get scale by id
     *
     * @param int $id
     * @return JsonResponse
     */
    public function show(int $id): JsonResponse
    {
        $scale = $this
            ->scaleService
            ->getScaleById($id);

        if (!$scale) {
            return $this->response(
                ['scale' => null],
                "Scale with id:$id not found!",
                false,
                Response::HTTP_OK
            );
        }

        return $this->response(
            ['scale' => ScaleShowResource::make($scale)],
            "Scale was created",
            true,
            Response::HTTP_OK
        );
    }

    /**
     * Return vue component for edit page
     *
     * @param int $id
     * @return \Inertia\Response
     */
    public function edit(int $id): \Inertia\Response
    {
        return Inertia::render('Scale/ScaleEdit', ['id' => $id]);
    }

    /**
     * Update scale entity by id
     *
     * @param ScaleUpdateRequest $request
     * @param int $id
     * @return JsonResponse
     */
    public function update(ScaleUpdateRequest $request, int $id): JsonResponse
    {
        $scale = $this
            ->scaleService
            ->updateScale($id, $request->validated());

        return $this->response(
            ['scale' => ScaleShowResource::make($scale)],
            "Scale was updated",
            true,
            Response::HTTP_OK
        );
    }

    /**
     * Delete scale by it
     *
     * @param int $id
     * @return JsonResponse
     */
    public function destroy(int $id): JsonResponse
    {
        try {
            $scale = $this
                ->scaleService
                ->deleteScale($id);

        } catch (\Exception $exception) {
            return $this->response(
                ['delete' => false],
                $exception->getMessage(),
                false,
                Response::HTTP_OK
            );
        }
        return $this->response(
            ['delete' => $scale],
            'Scale was deleted',
            true,
            Response::HTTP_OK
        );
    }

    /**
     * Get all scales with pagination
     *
     * @param ScaleCollectionRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getAllScalesWithPagination(ScaleCollectionRequest $request): JsonResponse
    {
        $data = $request->all();

        $scales = $this
            ->scaleService
            ->getAllScalesWithPagination($data['limit'], $data);

        return response()->json([
            'data' => ScaleCollectionResource::collection($scales),
            'count' => $scales->total()
        ]);
    }

    /**
     * Get scale detail page with ChartJs and table details
     *
     * @param int $id
     * @return \Inertia\Response
     */
    public function getScaleDetail(int $id): \Inertia\Response
    {
        return Inertia::render('Scale/ScaleDetail', ['id' => $id]);
    }
}
