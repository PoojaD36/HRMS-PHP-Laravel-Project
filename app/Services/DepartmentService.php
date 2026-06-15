<?php

namespace App\Services;

use App\Enums\StatusEnum;
use App\Models\Department;

class DepartmentService
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

    public function update(Department $department, array $data): Department
    {
        $department->update($data);

        return $department->fresh();
    }
}