<?php

namespace App\Services;

use App\Helpers\CodeGenerator;
use App\Enums\EmployeeStatusEnum;
use App\Models\Employee;
use App\Models\Department;
use App\Models\Designation;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;

class EmployeeService extends BaseService
{
    public function create(array $data): Employee
    {
        $this->validateRelations($data);

        $employeeCode = $this->generateEmployeeCode();

        $profileImage = null;

        if (
            isset($data['profile_image']) &&
            $data['profile_image']
        ) {
            $profileImage = $this->uploadProfileImage(
                $data['profile_image']
            );
        }

        return Employee::create([
            'employee_code' => $employeeCode,

            'department_id' => $data['department_id'],
            'designation_id' => $data['designation_id'],
            'reporting_manager_id' => $data['reporting_manager_id'] ?? null,

            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'] ?? null,

            'email' => $data['email'],
            'phone' => $data['phone'] ?? null,

            'joining_date' => $data['joining_date'] ?? null,

            'employment_type' => $data['employment_type'],

            'salary' => $data['salary'] ?? null,

            'profile_image' => $profileImage,

            'status' => $data['status']
                ?? EmployeeStatusEnum::ACTIVE->value,
        ]);
    }

    protected function validateRelations(
        array $data
    ): void {

        if (
            ! Department::find($data['department_id'])
        ) {
            throw ValidationException::withMessages([
                'department_id' => [
                    'Department not found.'
                ]
            ]);
        }

        if (
            ! Designation::find($data['designation_id'])
        ) {
            throw ValidationException::withMessages([
                'designation_id' => [
                    'Designation not found.'
                ]
            ]);
        }

        if (
            ! empty($data['reporting_manager_id']) &&
            ! Employee::find(
                $data['reporting_manager_id']
            )
        ) {
            throw ValidationException::withMessages([
                'reporting_manager_id' => [
                    'Manager not found.'
                ]
            ]);
        }
    }

    protected function generateEmployeeCode(): string
    {
        $companyCode = Auth::user()
            ->company
            ->company_code;

        $lastEmployee = Employee::latest('id')
            ->first();

        $lastId = $lastEmployee?->id ?? 0;

        return CodeGenerator::generate(
            $companyCode . '-EMP-',
            $lastId
        );
    }

    protected function uploadProfileImage(
        $image
    ): string {

        return $image->store(
            'employees',
            'public'
        );
    }

    public function getById(int $id): Employee
    {
        return $this->findOrFail(
            Employee::class,
            $id
        );
    }

    public function update(
    Employee $employee,
    array $data
    ): Employee {

        $this->validateRelationsForUpdate($data);

        if (
            isset($data['profile_image']) &&
            $data['profile_image']
        ) {

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

            $data['profile_image'] =
                $this->uploadProfileImage(
                    $data['profile_image']
                );
        }

        $employee->update($data);

        return $employee->fresh([
            'department',
            'designation',
            'manager',
        ]);
    }

    protected function validateRelationsForUpdate(
    array $data
    ): void {

        if (
            isset($data['department_id']) &&
            ! Department::find(
                $data['department_id']
            )
        ) {
            throw ValidationException::withMessages([
                'department_id' => [
                    'Department not found.'
                ]
            ]);
        }

        if (
            isset($data['designation_id']) &&
            ! Designation::find(
                $data['designation_id']
            )
        ) {
            throw ValidationException::withMessages([
                'designation_id' => [
                    'Designation not found.'
                ]
            ]);
        }

        if (
            isset($data['reporting_manager_id']) &&
            ! Employee::find(
                $data['reporting_manager_id']
            )
        ) {
            throw ValidationException::withMessages([
                'reporting_manager_id' => [
                    'Manager not found.'
                ]
            ]);
        }
    }
}