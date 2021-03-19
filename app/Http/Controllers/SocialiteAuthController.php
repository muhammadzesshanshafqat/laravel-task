<?php

namespace App\Http\Controllers;

use Laravel\Socialite\Facades\Socialite;
use Illuminate\Http\Request;
use App\Models\User;

class SocialiteAuthController extends Controller {
    public function redirectToGoogle() {
        return Socialite::driver('google')->redirect();
    }

    public function googleCallback() {
        $user = Socialite::driver('google')->user();
        $existingUser = User::where('email', $user->email)->first();
        if($existingUser) {
            auth()->login($existingUser, true); 
        } else {
            $newUser = new User;
            $newUser->name = $user->name;
            $newUser->email = $user->email;
            $newUser->password = "googlePassword";
            $newUser->save();
            auth()->login($newUser, true);
        }
    }
}
