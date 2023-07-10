<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;
use Mockery\Exception;
use RealRashid\SweetAlert\Facades\Alert;

class GoogleAuthController extends Controller
{
    public function redirect()
    {
        return Socialite::driver("google")->redirect();
    }

    public function callback()
    {
        try {
            $googleUser = Socialite::driver("google")->user();
            $user = User::where("email", $googleUser->email)->first();
//            return "test";
            if ($user) {
                auth()->loginUsingId($user->id);
            } else {
                $newUser = User::create([
                    "name" => $googleUser->name,
                    "email" => $googleUser->email,
                    "password" => bcrypt(Str::random(16))
                ]);
                auth()->loginUsingId($newUser->id);
            }
            return redirect("/");

        } catch (\Exception $e) {
            // TODO show Error Message
            Alert::error('Error Message', 'Login / Register with google was not success :(')->persistent();
//            Alert::error('! ارور داری', '): ورود با گوگل موفق نبود')->persistent("بسیار خب");
            return redirect("/login");
        }
    }
}
