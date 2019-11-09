<?php

namespace App\Http\Middleware;

use App\Enums\RoleIds;
use Closure;
use Illuminate\Auth\Middleware\Authenticate as Middleware;

class CheckBusinessRole extends Middleware
{
    public function handle($request, Closure $next, ...$guards)
    {
        $user = auth()->user();
        $userRole = $user->role->id;

        if (!empty($user) && $userRole === RoleIds::BUSINESS_ID) {
            return $next($request);
        } else {
            return response()->json(['message' => 'Unauthorized.'], 401);
        }
    }
}
