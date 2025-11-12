<?php

namespace App\Http\Middleware;

use Auth;
use Closure;
use Illuminate\Http\Request;
use Modules\Accounts\Entities\User;

class ForntendLoginMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $user = User::where('email', $request->email)->first();
        if ($user && ($user->type == 'admin' || $user->hasRole('admin'))) {
            return redirect()->route('frontend.login');
        }elseif($request->user() && ($request->user()->type == 'admin' || $request->user()->hasRole('admin'))){
            Auth::logout();
            return redirect()->route('frontend.login');
        }
        return $next($request);
    }
}
