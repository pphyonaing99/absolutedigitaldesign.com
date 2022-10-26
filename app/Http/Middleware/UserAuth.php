<?php

namespace App\Http\Middleware;

use Closure;

class UserAuth {
	/**
	 * Handle an incoming request.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \Closure  $next
	 * @return mixed
	 */
	public function handle($request, Closure $next) {

		if (is_null($request->session()->get('user'))) {
            /*alert()->error('You are not Authenticate!');
			return redirect()->route('userlogin');*/
			abort(404);
		}

		return $next($request);
	}

}
