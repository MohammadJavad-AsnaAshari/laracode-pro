<?php

namespace App\Http\Controllers;

use App\Models\ActiveCode;
use App\Models\User;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class ProfileController extends Controller
{
    public function __construct()
    {
        $this->middleware(["auth", "verified"]);
    }

    public function index()
    {
        $user = auth()->user();
        return view("profile.index", compact("user"));
    }

    public function manageTwoFactorAuth()
    {
        return view("profile.two-factor-auth");
    }

    public function postManageTwoFactorAuth(Request $request)
    {
        $data = $request->validate([
            "type" => "required|in:off,sms",
            "phone" => "required_unless:type,off|unique:users,phone_number"
        ]);

        if ($data["type"] === "sms") {
            // validation phone number

            if ($request->user()->phone_number !== $data["phone"]) {
                // create a new code
                $code = ActiveCode::generateCode($request->user());
                $request->session()->flash("phone", $data["phone"]);
                // send the code to the user phone number
                // TODO Send SMS

                return redirect(route("profile.2fa.phone"));
            } else {
                $request->user()->update([
                    "two_factor_type" => "sms"
                ]);
            }
        }

        if ($data["type"] === "off") {
            $request->user()->update([
                "two_factor_type" => "off"
            ]);
        }

        return back();
    }

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
