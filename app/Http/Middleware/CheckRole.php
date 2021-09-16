<?php

namespace App\Http\Middleware;

use Closure;
use App\User;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        dd($request->id);
        $user = User::first();
        if ($user->is_patient == false) {
            return $next($request);
        }
            return response()->json('Unauthorized Access');
        // return $next($request);
    }
}
