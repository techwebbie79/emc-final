<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;

class FacebookLoginController extends Controller
{
    public function redirectToFacebook()
    {
        return Socialite::driver('facebook')->redirect();
    }
    public function redirectFromFaceboookSSO()
    {
        $facebook_user=Socialite::driver('facebook')->stateless()->user();
        dd($facebook_user);
       
    }
    



}
