<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  ...$guards
     * @return mixed
     */
    public function handle(Request $request, Closure $next, ...$guards)
    {
        $guards = empty($guards) ? [null] : $guards;

        foreach ($guards as $guard) {
            // if (Auth::guard($guard)->check()) {
            //     // return redirect(RouteServiceProvider::HOME);
            //     $role = Auth::user()->role; 
            //     if ($user->role_id == 1) {
            //         return redirect('/dashboard');
            //     } else if ($user->role_id == 2) {
            //         return redirect('/author');
            //     } else {
            //         return redirect('/blog');
            //     }
            if (Auth::guard($guard)->check()) {
                $role = Auth::user()->role_id; 
                switch ($role) {
                  case 1:
                     return redirect('/dashboard');
                     break;
                  case 2:
                     return redirect('/chart_list');
                     break; 
                  case 3:
                     return redirect('/exam');
                     break; 
            
                  default:
                     echo ($role);
                     return redirect('/home'); 
                     break;
                }
        }
            }


        return $next($request);
    }
}
