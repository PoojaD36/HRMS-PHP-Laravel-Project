<?php

namespace App\Services;

use App\Enums\StatusEnum;
use App\Models\Department;
use App\Models\Designation;
use Illuminate\Validation\ValidationException;

class DesignationService extends BaseService
{
    public function create(array $data): Designation
    {
        $department = Department::find($data['department_id']);

        if (! $department) {
            throw ValidationException::withMessages([
                'department_id' => ['Selected department does not exist.']
            ]);
        }

        return Designation::create([
            'department_id' => $data['department_id'],
            'name' => $data['name'],
            'status' => $data['status']
                ?? StatusEnum::ACTIVE->value,
        ]);
    }

    public function update(
        Designation $designation,
        array $data
    ): Designation {

        $designation->update($data);

        return $designation->fresh();
    }

    public function getById(int $id): Designation
    {
        return $this->findOrFail(
            Designation::class,
            $id
        );
    }
}