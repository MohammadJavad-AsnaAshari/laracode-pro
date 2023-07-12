<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

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
            "phone" => "required_unless:type,off"
        ]);

        if ($data["type"] === "sms") {
            // validation phone number

            if ($request->user()->phone_number !== $data["phone"]){
                // create a new code
                // send the code to the user phone number
                return redirect(route("profile.2fa.phone"));
            }

            else{
                $request->user()->update([
                    "two_factor_type" => "sms"
                ]);
            }
        }

        if ($data["type"] === "off"){
            $request->user()->update([
                "two_factor_type" => "off"
            ]);
        }

        return back();
    }

    public function getPhoneVerify()
    {
        return view("profile.phone_verify");
    }

    public function postPhoneVerify(Request $request)
    {
        $request->validate([
            "token" => "required"
        ]);

        return $request;
    }
}
