<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DoptorUserActiveMiddlewire
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
        $doptor_user_active = globalUserInfo()->doptor_user_active;
        $doptor_user_flag = globalUserInfo()->doptor_user_flag;
        $role_id=globalUserInfo()->role_id;
        $peshkar_active=globalUserInfo()->peshkar_active;
        if($role_id == 39)
         {
             if($peshkar_active == 1)
             {
                return $next($request);
             }
             else
             {
                Auth::logout();
                
                return redirect('/disable/peshkar/39')->with('disable_messeage_middlewire','আপনাকে ডিজেবেল করে রাখা হয়েছে');
             }
         }
         elseif($role_id == 28) 
         {
            if($peshkar_active == 1)
            {
               return $next($request);
            }
            else
            {
               Auth::logout();
               
               return redirect('/disable/peshkar/28')->with('disable_messeage_middlewire','আপনাকে ডিজেবেল করে রাখা হয়েছে');
            }
         }

        if ($doptor_user_flag == 0) {
            return $next($request);
        } elseif ($doptor_user_flag == 1) {
            if ($doptor_user_active == 1) {
                return $next($request);
            } else {
                if($role_id == 37)
                {
                    Auth::logout();
                
                    return redirect('/disable/doptor/user/37')->with('disable_messeage_middlewire','আপনাকে ডিজেবেল করে রাখা হয়েছে');
                }
                elseif($role_id == 38)
                {
                    Auth::logout();
                
                    return redirect('/disable/doptor/user/38')->with('disable_messeage_middlewire','আপনাকে ডিজেবেল করে রাখা হয়েছে');
                }
                elseif($role_id == 27)
                {
                    Auth::logout();
                
                    return redirect('/disable/doptor/user/27')->with('disable_messeage_middlewire','আপনাকে ডিজেবেল করে রাখা হয়েছে');
                }
                

                //return response()->json('আপনাকে ডিজেবেল করে রাখা হয়েছে ');
            }
        }
    }
}
