<?php

namespace App\Http\Middleware;

use Closure;

class ProcurementPermission
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
        $request->session()->get('user');

		if (!$request->session()->get('user')->hasRole('Procurement Officer')) {

			abort(403);
		}
        return $next($request);
    }
}
