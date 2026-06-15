<?php

namespace App\Models;


class Employee extends BaseTenantModel
{
    protected $fillable = [
        'employee_code',
        'department_id',
        'designation_id',
        'reporting_manager_id',
        'first_name',
        'last_name',
        'email',
        'phone',
        'joining_date',
        'employment_type',
        'salary',
        'profile_image',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'joining_date' => 'date',
            'salary' => 'decimal:2',
            'status' => 'boolean',
        ];
    }

    public function department()
    {
        return $this->belongsTo(
            Department::class
        );
    }

    public function designation()
    {
        return $this->belongsTo(
            Designation::class
        );
    }

    public function manager()
    {
        return $this->belongsTo(
            Employee::class,
            'reporting_manager_id'
        );
    }

    public function subordinates()
    {
        return $this->hasMany(
            Employee::class,
            'reporting_manager_id'
        );
    }

    public function getFullNameAttribute(): string
    {
        return trim(
            $this->first_name . ' ' . $this->last_name
        );
    }
    
}
