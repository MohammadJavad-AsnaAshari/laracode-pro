<?php

namespace App\Http\Controllers\Profile;

use App\Http\Controllers\Controller;
use App\Models\ActiveCode;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class TokenAuthController extends Controller
{

    public function getPhoneVerify(Request $request)
    {
        if (!$request->session()->has("phone")) {
            return redirect(route("profile.2fa.manage"));
        }

        $request->session()->reflash();

        return view("profile.phone_verify");
    }

    public function postPhoneVerify(Request $request)
    {
        $request->validate([
            "token" => "required"
        ]);

        if (!$request->session()->has("phone")) {
            return redirect(route("profile.2fa.manage"));
        }

        $status = ActiveCode::verifyCode($request->token, $request->user());

        if ($status) {
            $request->user()->ActiveCodes()->delete();
            $request->user()->update([
                "phone_number" => $request->session()->get("phone"),
                "two_factor_type" => "sms"
            ]);
            Alert::success("Success Message", "Phone Verify is Successful :)");
        } else {
            Alert::error("Error Message", "Phone Verify isn't Successful :(");
        }

//        Alert::error("Error Message", "You Have Error!");
        return redirect(route("profile.2fa.manage"));
    }
}
