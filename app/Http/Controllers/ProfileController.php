<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
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

        return $data;
    }
}
