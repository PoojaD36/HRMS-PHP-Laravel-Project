<?php

namespace App\Services;

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;

class TenantMigrationService
{
    public function run(string $databaseName): void
    {
        Config::set('database.connections.tenant.database', $databaseName);
        Config::set('database.connections.tenant.username', env('DB_USERNAME'));
        Config::set('database.connections.tenant.password', env('DB_PASSWORD'));
        Config::set('database.connections.tenant.host', env('DB_HOST'));
        Config::set('database.connections.tenant.port', env('DB_PORT'));

        DB::purge('tenant');
        DB::reconnect('tenant');

        Artisan::call('migrate', [
            '--database' => 'tenant',
            '--path' => 'database/tenant_migrations',
            '--force' => true,
        ]);
    }
}