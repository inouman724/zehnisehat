<?php

namespace App\Http\Middleware;

use Closure;

class CheckIsTherapist
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
        if(!$request->user()->is_therapist)
        {
            return response()->json([
                'status' => 400,
                'message' => 'Limited Previlige',
            ]);
        }
        return $next($request);
    }
}
