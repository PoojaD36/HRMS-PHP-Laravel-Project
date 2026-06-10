<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('companies', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();

            $table->string('company_code', 50)->unique();

            $table->string('name');
            $table->string('email')->unique();
            $table->string('phone', 20)->nullable();

            $table->string('database_name')->unique();
            $table->string('database_username');
            $table->text('database_password');

            $table->string('database_host')->default('127.0.0.1');
            $table->string('database_port')->default('3306');

            $table->enum('subscription_status', [
                'trial',
                'active',
                'expired',
                'cancelled'
            ])->default('trial');

            $table->boolean('status')->default(true);

            $table->timestamps();

            $table->index('company_code');
            $table->index('status');
            $table->index('subscription_status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('companies');
    }
};
