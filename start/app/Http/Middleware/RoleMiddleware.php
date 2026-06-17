<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
   
    public function handle(Request $request, Closure $next, string ...$roles): mixed
    {   
        $user = Auth::guard('api')->user();
        //ensure user is fits one of the role before gg to controller
        if (!$user || !in_array($user->role, $roles)) { //if NO user or wrong role !user
            return response()->json([
                'message' => 'Unauthorised - insufficient permissions'
            ], 403);

        }
        return $next($request);
    }
}
