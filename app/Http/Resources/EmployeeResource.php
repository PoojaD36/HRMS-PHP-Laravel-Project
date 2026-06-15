<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class EmployeeResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,

            'employee_code' => $this->employee_code,

            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'full_name' => $this->full_name,

            'email' => $this->email,
            'phone' => $this->phone,

            'joining_date' => $this->joining_date,

            'employment_type' => $this->employment_type,

            'salary' => $this->salary,

            'profile_image' => $this->profile_image
                ? asset('storage/' . $this->profile_image)
                : null,

            'department' => $this->department
                ? [
                    'id' => $this->department->id,
                    'name' => $this->department->name,
                ]
                : null,

            'designation' => $this->designation
                ? [
                    'id' => $this->designation->id,
                    'name' => $this->designation->name,
                ]
                : null,

            'manager' => $this->manager
                ? [
                    'id' => $this->manager->id,
                    'name' => $this->manager->full_name,
                ]
                : null,

            'status' => (bool) $this->status,

            'created_at' => $this->created_at,
        ];
    }
}
