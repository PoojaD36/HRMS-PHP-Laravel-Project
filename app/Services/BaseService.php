<?php

namespace App\Services;

use Illuminate\Database\Eloquent\Model;

abstract class BaseService
{
    protected function findOrFail(
        string $model,
        int $id
    ): Model {

        return $model::query()
            ->findOrFail($id);
    }
}