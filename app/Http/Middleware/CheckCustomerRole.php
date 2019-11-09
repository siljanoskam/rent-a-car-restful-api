<?php

namespace App\Http\Middleware;

use App\Enums\RoleIds;
use Closure;
use Illuminate\Auth\Middleware\Authenticate as Middleware;

class CheckCustomerRole extends Middleware
{
    public function handle($request, Closure $next, ...$guards)
    {
        $user = auth()->user();
        $userRole = $user->role->id;

        if (!empty($user) && $userRole === RoleIds::CUSTOMER_ID) {
            return $next($request);
        } else {
            return response()->json(['message' => 'Unauthorized.'], 401);
        }
    }
}
