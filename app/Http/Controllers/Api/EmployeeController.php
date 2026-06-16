<?php

namespace App\Http\Controllers\Api;

use App\Constants\AppConstants;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreEmployeeRequest;
use App\Http\Requests\UpdateEmployeeRequest;
use App\Http\Resources\EmployeeResource;
use App\Models\Employee;
use App\Services\EmployeeService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class EmployeeController extends Controller
{
    public function __construct(
        private EmployeeService $employeeService
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

        $query = Employee::query()
            ->with([
                'department',
                'designation',
                'manager',
            ]);

        // Search
        $query->when(
            $request->search,
            function ($query) use ($request) {

                $search = $request->search;

                $query->where(function ($q) use ($search) {

                    $q->where(
                        'employee_code',
                        'like',
                        "%{$search}%"
                    )
                    ->orWhere(
                        'first_name',
                        'like',
                        "%{$search}%"
                    )
                    ->orWhere(
                        'last_name',
                        'like',
                        "%{$search}%"
                    )
                    ->orWhere(
                        'email',
                        'like',
                        "%{$search}%"
                    )
                    ->orWhere(
                        'phone',
                        'like',
                        "%{$search}%"
                    );
                });
            }
        );

        // Filters
        $query->when(
            $request->department_id,
            fn ($q) => $q->where(
                'department_id',
                $request->department_id
            )
        );

        $query->when(
            $request->designation_id,
            fn ($q) => $q->where(
                'designation_id',
                $request->designation_id
            )
        );

        $query->when(
            $request->filled('status'),
            fn ($q) => $q->where(
                'status',
                $request->status
            )
        );

        // Sorting
        $allowedSorts = [
            'first_name',
            'joining_date',
            'employee_code',
            'created_at',
        ];

        $sort = in_array(
            $request->sort,
            $allowedSorts
        )
            ? $request->sort
            : 'created_at';

        $employees = $query
            ->orderBy($sort, 'desc')
            ->paginate($perPage);

        return EmployeeResource::collection(
            $employees
        );
    }

    public function store(
        StoreEmployeeRequest $request
    ) {
        $employee = $this->employeeService
            ->create(
                $request->validated()
            );

        return $this->successResponse(
            new EmployeeResource(
                $employee->load([
                    'department',
                    'designation',
                    'manager',
                ])
            ),
            'Employee created successfully',
            201
        );
    }

    public function show($id)
    {
        $employee = $this->employeeService
            ->getById($id)
            ->load([
                'department',
                'designation',
                'manager',
            ]);

        return $this->successResponse(
            new EmployeeResource($employee)
        );
    }

    public function update(
    UpdateEmployeeRequest $request,
    $id
    ) {

        $employee = $this->employeeService
            ->getById($id);

        $employee = $this->employeeService
            ->update(
                $employee,
                $request->validated()
            );

        return $this->successResponse(
            new EmployeeResource($employee),
            'Employee updated successfully'
        );
    }

    public function destroy($id)
    {
        $employee = $this->employeeService
            ->getById($id);

        if (
            $employee->profile_image &&
            Storage::disk('public')->exists(
                $employee->profile_image
            )
        ) {
            Storage::disk('public')->delete(
                $employee->profile_image
            );
        }

        $employee->delete();

        return $this->successResponse(
            null,
            'Employee deleted successfully'
        );
    }
}
