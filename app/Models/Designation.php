<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Designation extends Model
{
    protected $connection = 'tenant';

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
