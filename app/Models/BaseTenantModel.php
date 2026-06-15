<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BaseTenantModel extends Model
{
    protected $connection = 'tenant';
}
