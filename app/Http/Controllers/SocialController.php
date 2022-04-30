<?php

namespace App\Http\Controllers;

use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Laravel\Socialite\Facades\Socialite;
use Laravel\Socialite\Two\InvalidStateException;

class SocialController extends Controller
{
    public function facebookRedirect(Request $req)
    {
        return Socialite::driver('facebook')->redirect();
    }
    public function loginWithFacebook()
    {
        try {

            $user = Socialite::driver('facebook')->stateless()->user();
            $isUser = User::where('email', $user->email)->first();
            if ($isUser) {
                Auth::login($isUser);
                return redirect('/dashboard');
            } else {
                $createUser = User::create([
                    'name' => $user->name,
                    'email' => $user->email,
                    'fb_id' => $user->id,
                    // 'password' => encrypt('admin@123')
                    'password' => Hash::make($user->id)
                ]);

                Auth::login($createUser);
                return redirect('/dashboard');
                //return view('welcome', ['message' => "Email Not Register...!!!"]);
            }
        } catch (InvalidStateException $exception) {
            echo "InvalidStateException";
            echo $exception;
        }
    }
}
