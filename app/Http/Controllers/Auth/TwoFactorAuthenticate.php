<?php

namespace App\Http\Controllers\Auth;

use App\Models\ActiveCode;
use App\Notifications\ActiveCodeNotification;
use Illuminate\Http\Request;

trait TwoFactorAuthenticate
{
    public function loggedin(Request $request, $user)
    {
        if ($user->hasTwoFactorAuthenicatedEnabled()) {
            auth()->logout();

            $request->session()->flash("auth", [
                "user_id" => $user->id,
                "using_sms" => false,
                "remember" => $request->has("remember")
            ]);

            if ($user->two_factor_type == "sms") {
                $code = ActiveCode::generateCode($user);
                //TODO send the code to the user phone number
//                $request->user()->notify(new ActiveCodeNotification($code, ));

                $request->session()->push("auth.using_sms", true);
            }

            return redirect(route("2fa.token"));
        }

        return false;
    }
}
