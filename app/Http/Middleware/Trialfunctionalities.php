<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Trialfunctionalities
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
        $role_id=globalUserInfo()->role_id;
        $accepted_role_for_trail=[27,28,37,38,39,7,1,2];

        if(in_array($role_id,$accepted_role_for_trail))
         {
             
                
             return $next($request);
                
              
         }
         else
         {
            Auth::logout();
            return redirect('/login/page');
         }
        
    }
}
