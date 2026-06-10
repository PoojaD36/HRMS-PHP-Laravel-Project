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
        Schema::create('employees', function (Blueprint $table) {
            $table->id();
            $table->string('employee_code')->unique();

            $table->foreignId('department_id')
                ->nullable()
                ->constrained()
                ->nullOnDelete();

            $table->foreignId('designation_id')
                ->nullable()
                ->constrained()
                ->nullOnDelete();

            $table->unsignedBigInteger('reporting_manager_id')
                ->nullable();

            $table->string('first_name');
            $table->string('last_name')->nullable();

            $table->string('email')->unique();
            $table->string('phone', 20)->nullable();

            $table->date('joining_date')->nullable();

            $table->enum('employment_type', [
                'full_time',
                'part_time',
                'contract',
                'intern'
            ])->default('full_time');

            $table->decimal('salary', 12, 2)->default(0);

            $table->string('profile_image')->nullable();

            $table->boolean('status')->default(true);
            
            $table->timestamps();

            $table->foreign('reporting_manager_id')
                ->references('id')
                ->on('employees')
                ->nullOnDelete();

            $table->index('employee_code');
            $table->index('department_id');
            $table->index('designation_id');
            $table->index('reporting_manager_id');
            $table->index('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employees');
    }
};
