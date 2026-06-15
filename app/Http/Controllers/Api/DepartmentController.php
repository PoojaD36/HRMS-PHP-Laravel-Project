<?php

namespace App\Http\Controllers\Api;

use App\Constants\AppConstants;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreDepartmentRequest;
use App\Http\Requests\UpdateDepartmentRequest;
use App\Http\Resources\DepartmentResource;
use App\Models\Department;
use App\Services\DepartmentService;
use Illuminate\Http\Request;

class DepartmentController extends Controller
{
    public function __construct(
        private DepartmentService $departmentService
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

        $departments = Department::query()
            ->when(
                $request->search,
                fn ($query) =>
                $query->where(
                    'name',
                    'like',
                    "%{$request->search}%"
                )
            )
            ->latest()
            ->paginate($perPage);

        return DepartmentResource::collection(
            $departments
        );
    }

    public function store(
        StoreDepartmentRequest $request
    ) {
        $department = $this->departmentService
            ->create($request->validated());

        return $this->successResponse(
            new DepartmentResource($department),
            'Department created successfully'
        );
    }

    public function show($id)
    {
        $department = $this->departmentService->getById($id);

        return new DepartmentResource(
            $department
        );
    }

    public function update(
        UpdateDepartmentRequest $request,
        $id
    ) {
        $department = $this->departmentService->getById($id);

        $department = $this->departmentService
            ->update(
                $department,
                $request->validated()
            );

        return $this->successResponse(
            new DepartmentResource($department),
            'Department updated successfully'
        );
    }

    public function destroy($id)
    {
        $department = $this->departmentService->getById($id);

        $department->delete();

        return $this->successResponse(
            null,
            'Department deleted successfully'
        );
    }

}
