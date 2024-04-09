<?php

namespace App\Http\Controllers;

use App\Contracts\OrganizationServiceInterface;
use App\Http\Requests\Organization\OrganizationStoreRequest;
use App\Http\Requests\Organization\OrganizationUpdateRequest;
use App\Http\Requests\OrganizationCollectionRequest;
use App\Http\Resources\Admin\Dashboard\Organization\OrganizationCollectionResource;
use App\Http\Resources\Admin\Dashboard\Organization\OrganizationCreateResource;
use App\Http\Resources\Admin\Dashboard\Organization\OrganizationShowResource;
use Inertia\Inertia;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class OrganizationController extends BaseController
{
    private OrganizationServiceInterface $organizationService;

    public function __construct(OrganizationServiceInterface $organizationService)
    {
        $this->organizationService = $organizationService;
    }

    /**
     * Return index view
     * @return \Inertia\Response
     */
    public function index()
    {
        return Inertia::render('Organization/OrganizationIndex');
    }

    /**
     * Return create page
     * @return \Inertia\Response
     */
    public function create()
    {
        return Inertia::render('Organization/OrganizationCreate');
    }

    /**
     * Create organization
     * @param OrganizationStoreRequest $request
     * @return mixed
     */
    public function store(OrganizationStoreRequest $request): JsonResponse
    {
        $data = $request->validated();
        $organization = $this->organizationService->createOrganizations($data);
        return $this->response(
            [OrganizationCreateResource::make($organization)],
            'Organization was created',
            true,
            Response::HTTP_CREATED
        );
    }

    /**
     * Get organization by id
     * @param int $id
     * @return JsonResponse
     */
    public function show(int $id): JsonResponse
    {
        $organization = $this->organizationService->getOrganizationsById($id);

        if (!$organization) {
            return $this->response(
                ['organization' => null],
                'Organization by id ' . $id,
                false,
                Response::HTTP_OK
            );
        }

        return $this->response(
            ['organization' => OrganizationShowResource::make($organization)],
            'Organization by id',
            true,
            Response::HTTP_OK
        );
    }

    /**
     * Return edit page
     * @param int $id
     * @return \Inertia\Response
     */
    public function edit(int $id)
    {
        return Inertia::render('Organization/OrganizationEdit', ['id' => $id]);
    }

    /**
     * Update organization by id
     * @param OrganizationUpdateRequest $request
     * @param int $id
     * @return JsonResponse
     */
    public function update(OrganizationUpdateRequest $request, int $id): JsonResponse
    {
        $data = $request->validated();
        $organization = $this->organizationService->updateOrganizations($id, $data);
        return $this->response(
            ['organization' => OrganizationShowResource::make($organization)],
            'Update organization by id',
            true,
            Response::HTTP_OK
        );
    }

    /**
     * Delete organization by id
     * @param int $id
     * @return JsonResponse
     */
    public function destroy(int $id): JsonResponse
    {
        $isDelete = $this->organizationService->deleteOrganizations($id);
        return $this->response(
            [$isDelete],
            'Organization was deleted',
            true,
            Response::HTTP_OK
        );
    }

    /**
     * Get organization collection
     * @param OrganizationCollectionRequest $request
     * @return JsonResponse
     */
    public function getAllOrganizationsWithPagination(OrganizationCollectionRequest $request): JsonResponse
    {
        $data = $request->validated();

        $organizations = $this
            ->organizationService
            ->getAllOrganizationsWithPagination($data['limit']);

        return response()->json([
            'data' => OrganizationCollectionResource::collection($organizations),
            'count' => $organizations->total()
        ]);
    }

    /**
     * Get all organization collection
     * @return JsonResponse
     */
    public function getOrganizationsCollection(): JsonResponse
    {
        $organizations = $this
            ->organizationService
            ->getAllOrganizationsCollection();

        return $this->response(
            ['organizations' => $organizations],
            'Organization was deleted',
            true,
            Response::HTTP_OK
        );
    }
}
