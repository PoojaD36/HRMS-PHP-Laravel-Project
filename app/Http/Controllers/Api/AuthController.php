<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\CompanyService;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function register(
        Request $request,
        CompanyService $companyService
    ) {
        $request->validate([
            'company_name' => 'required',
            'company_email' => 'required|email',
            'admin_name' => 'required',
            'admin_email' => 'required|email',
            'password' => 'required|min:6',
        ]);

        $data = $companyService->register(
            $request->all()
        );

        return response()->json([
            'success' => true,
            'data' => $data
        ]);
    }
}
