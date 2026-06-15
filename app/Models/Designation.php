<?php

namespace App\Models;

class Designation extends BaseTenantModel
{

    protected $fillable = [
        'department_id',
        'name',
        'status',
    ];

    public function department()
    {
        return $this->belongsTo(Department::class);
    }
}
