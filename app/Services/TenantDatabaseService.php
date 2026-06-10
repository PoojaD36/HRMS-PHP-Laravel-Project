<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;

class TenantDatabaseService
{
    public function createDatabase(string $databaseName): bool
    {
        DB::statement("
            CREATE DATABASE `$databaseName`
            CHARACTER SET utf8mb4
            COLLATE utf8mb4_unicode_ci
        ");

        return true;
    }
}