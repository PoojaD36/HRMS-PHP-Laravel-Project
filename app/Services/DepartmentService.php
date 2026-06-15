<?php

namespace App\Services;

use App\Enums\StatusEnum;
use App\Models\Department;

class DepartmentService extends BaseService
{
    public function create(array $data): Department
    {
        return Department::create([
            'name' => $data['name'],
            'description' => $data['description'] ?? null,
            'status' => $data['status']
                ?? StatusEnum::ACTIVE->value,
        ]);
    }

    public function getById(int $id): Department
    {
        return $this->findOrFail(
            Department::class,
            $id
        );
    }

    public function update(
        Department $department,
        array $data
    ): Department {
        $department->update($data);

        return $department->fresh();
    }
}