<?php

namespace App\Http\Controllers\Api;

use App\Constants\AppConstants;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreDesignationRequest;
use App\Http\Requests\UpdateDesignationRequest;
use App\Http\Resources\DesignationResource;
use App\Models\Designation;
use App\Services\DesignationService;
use Illuminate\Http\Request;

class DesignationController extends Controller
{
    public function __construct(
        private DesignationService $designationService
    ) {}

    public function index(Request $request)
    {
        $perPage = min(
            $request->integer(
                'per_page',
                AppConstants::DEFAULT_PER_PAGE
            ),
            AppConstants::MAX_PER_PAGE
        );

        $designations = Designation::query()
            ->with('department')
            ->when(
                $request->search,
                function ($query) use ($request) {

                    $query->where('name', 'like', "%{$request->search}%")
                        ->orWhereHas(
                            'department',
                            fn ($department) =>
                            $department->where(
                                'name',
                                'like',
                                "%{$request->search}%"
                            )
                        );
                }
            )
            ->latest()
            ->paginate($perPage);

        return DesignationResource::collection(
            $designations
        );
    }

    public function store(
        StoreDesignationRequest $request
    ) {
        $designation = $this->designationService
            ->create($request->validated());

        return $this->successResponse(
            new DesignationResource(
                $designation->load('department')
            ),
            'Designation created successfully'
        );
    }

    public function show($id)
    {
        $designation = $this->designationService->getById($id);

        return $this->successResponse(
            new DesignationResource($designation)
        );
    }

    public function update(
        UpdateDesignationRequest $request,
        $id
    ) {
        $designation = $this->designationService->getById($id);

        $designation = $this->designationService
            ->update(
                $designation,
                $request->validated()
            );

        return $this->successResponse(
            new DesignationResource(
                $designation->load('department')
            ),
            'Designation updated successfully'
        );
    }

    public function destroy($id)
    {
        $designation = $this->designationService->getById($id);

        $designation->delete();

        return $this->successResponse(
            null,
            'Designation deleted successfully'
        );
    }
}
