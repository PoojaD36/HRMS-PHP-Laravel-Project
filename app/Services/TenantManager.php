<?php

namespace App\Services;

use App\Models\Company;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;

class TenantManager
{
    public function setTenantConnection(Company $company): void
    {
        Config::set('database.connections.tenant.database', $company->database_name);
        Config::set('database.connections.tenant.username', $company->database_username);
        Config::set('database.connections.tenant.password', decrypt($company->database_password));
        Config::set('database.connections.tenant.host', $company->database_host);
        Config::set('database.connections.tenant.port', $company->database_port);

        DB::purge('tenant');
        DB::reconnect('tenant');
    }
}