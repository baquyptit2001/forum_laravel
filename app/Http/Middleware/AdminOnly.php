<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use PHPUnit\Util\Exception;

class AdminOnly
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if ($request->bearerToken()) {
            try {
                $user = $request->user('sanctum');
                if ($user->role === 1) {
                    return $next($request);
                }
            } catch (Exception $e) {
                abort(403, 'Unauthorized action.');
            }
        }
        abort(403, 'Unauthorized action.');
    }
}
