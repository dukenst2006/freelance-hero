<?php

namespace App\Http\Middleware;

use Closure;
use Auth;

class Administrator
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
        $user_role = Auth::user()->role;
        if ($user_role != "Admin") {
            if ($request->ajax() || $request->wantsJson()) {
                return response('Unauthorized.', 401);
            } else {
                return redirect('unauthorized');
            }
        }
        return $next($request);
    }
}