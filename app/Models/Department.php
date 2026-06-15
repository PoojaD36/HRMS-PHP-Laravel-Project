<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    protected $connection = 'tenant';

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
