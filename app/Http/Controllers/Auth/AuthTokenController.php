<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\ActiveCode;
use App\Models\User;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class AuthTokenController extends Controller
{
    public function getToken(Request $request)
    {
        if (!$request->session()->has("auth")) {
            return redirect(route("login"));
        }

        $request->session()->reflash();

        return view("auth.token");
    }

    public function postToken(Request $request)
    {
        $request->validate([
            "token" => "required"
        ]);

        if (!$request->session()->has("auth")) {
            return redirect(route("login"));
        }

        $user = User::findOrFail($request->session()->get("auth.user_id"));

        $status = ActiveCode::verifyCode($request->token, $user);

        if (!$status) {
            Alert::error("Error Message", "Phone Verify isn't Successful :(");
            return redirect(route("login"));
        }

        if (auth()->loginUsingId($user->id, $request->session()->get("auth.remember"))) {
            $user->activeCodes()->delete();

            Alert::success("Success Message", "Phone Verify is Successful :)");
            return redirect(route("home"));
        }

        return redirect(route("login"));
    }
}
