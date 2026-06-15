<?php

namespace App\Http\Middleware;

use App\Services\TenantManager;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class TenantMiddleware
{
    public function __construct(
        private TenantManager $tenantManager
    ) {}
    
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        if (!$user) {
            return response()->json([
                'message' => 'Unauthenticated'
            ], 401);
        }

        $company = $user->company;

        if (!$company) {
            return response()->json([
                'message' => 'Company not found'
            ], 404);
        }

        $this->tenantManager->setTenantConnection($company);

        return $next($request);
    }
}
