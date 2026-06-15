<?php

namespace App\Models;

class Department extends BaseTenantModel
{

    protected $fillable = [
        'name',
        'description',
        'status',
    ];

    public function designations()
    {
        return $this->hasMany(Designation::class);
    }
}
