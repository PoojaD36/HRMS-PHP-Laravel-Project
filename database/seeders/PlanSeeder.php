<?php

namespace Database\Seeders;

use App\Models\Plan;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PlanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Plan::insert([
            [
                'name' => 'Trial',
                'monthly_price' => 0,
                'yearly_price' => 0,
                'employee_limit' => 10,
                'storage_limit' => 1024,
                'status' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Basic',
                'monthly_price' => 29,
                'yearly_price' => 290,
                'employee_limit' => 50,
                'storage_limit' => 5120,
                'status' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
    }
}
