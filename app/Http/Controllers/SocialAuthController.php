<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;

class SocialAuthController extends Controller
{
    public function redirect($provider) {
        return Socialite::driver($provider)->redirect();
    }
    
    public function callback($provider) {
        $socialUser = Socialite::driver($provider)->stateless()->user();
        $user = \App\Models\User::updateOrCreate(
            ['email' => $socialUser->getEmail()],
            ['name' => $socialUser->getName() ?? $socialUser->getNickname()]
        );
        auth()->login($user);
        return redirect('/cabinet');
    }    
}
