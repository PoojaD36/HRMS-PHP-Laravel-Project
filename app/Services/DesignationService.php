<?php

namespace App\Services;

use App\Enums\StatusEnum;
use App\Models\Designation;

class DesignationService
{
    public function create(array $data): Designation
    {
        return Designation::create([
            'department_id' => $data['department_id'],
            'name'          => $data['name'],
            'status'        => $data['status']
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
}