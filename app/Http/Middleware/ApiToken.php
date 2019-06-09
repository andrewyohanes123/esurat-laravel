<?php

namespace App\Http\Middleware;

use Closure;
use App\User;

class ApiToken
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
        $token = $request->headers->get('USER-TOKEN', '');
        $user = User::where('api_token', $token)->get()->pluck('id')->toArray();

        if (sizeof($user) > 0) {
            return $next($request);
        }

        return response()->json(['msg' => 'unathorized']);
    }
}
