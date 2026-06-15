<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\DepartmentController;
use App\Http\Controllers\Api\DesignationController;
use App\Http\Controllers\Api\LoginController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/register-company', [AuthController::class, 'register']);
Route::post('/login', [LoginController::class, 'login']);

Route::middleware(['auth:sanctum', 'tenant'])->group(function () {

    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    Route::get('/test-tenant', function () {
        return [
            'database' => DB::connection('tenant')->getDatabaseName()
        ];
    });

    Route::post('/logout', function (Request $request) {

        $request->user()->tokens()->delete();

        return response()->json([
            'success' => true,
            'message' => 'Logged out successfully'
        ]);
    });

    Route::apiResource('departments', DepartmentController::class);
    Route::apiResource('designations', DesignationController::class);
});