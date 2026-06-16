<?php

namespace App\Services;

use App\Helpers\CompanyCodeGenerator;
use App\Models\Company;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class CompanyService
{
    public function __construct(
        private TenantDatabaseService $tenantDatabaseService,
        private TenantMigrationService $tenantMigrationService
    ) {}

    public function register(array $data)
    {
        $databaseName =
            'tenant_' .
            strtolower(
                preg_replace('/[^A-Za-z0-9]/', '_', $data['company_name'])
            );

        $this->tenantDatabaseService
            ->createDatabase($databaseName);

        $this->tenantMigrationService
            ->run($databaseName);

        $company = Company::create([
            'uuid' => Str::uuid(),
            'company_code' => CompanyCodeGenerator::generate(
                $data['company_name']
            ),
            'name' => $data['company_name'],
            'email' => $data['company_email'],
            'phone' => $data['phone'] ?? null,
            'database_name' => $databaseName,
            'database_username' => env('DB_USERNAME'),
            'database_password' => encrypt(env('DB_PASSWORD')),
            'database_host' => env('DB_HOST'),
            'database_port' => env('DB_PORT'),
        ]);

        $user = User::create([
            'company_id' => $company->id,
            'name' => $data['admin_name'],
            'email' => $data['admin_email'],
            'password' => Hash::make($data['password']),
        ]);

        return [
            'company' => $company,
            'user' => $user,
        ];
    }
}