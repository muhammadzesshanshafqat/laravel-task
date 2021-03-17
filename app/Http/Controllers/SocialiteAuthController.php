<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SocialiteAuthController extends Controller {
    public function redirectToGoogle() {
        return Socialite::driver('google')->redirect();
    }

    public function googleCallback() {
        $user = Socialite::driver('google')->user();
        echo $user->token;
    }
}