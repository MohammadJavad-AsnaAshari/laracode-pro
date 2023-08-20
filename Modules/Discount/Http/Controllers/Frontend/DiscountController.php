<?php

namespace Modules\Discount\Http\Controllers\Frontend;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Discount\Entities\Discount;

class DiscountController extends Controller
{
    public function check(Request $request)
    {
        $data = $request->validate([
            "discount" => "required|exists:discounts,code",
            "cart" => "required"
        ]);

        if (!auth()->check()) {
            return back()->withErrors([
                "discount" => "برای اعمال کد تخفیف، لطفا ابتدا در سایت لاگین کنید."
            ]);
        }

        $discount = Discount::where("code", $data["discount"])->first();

        if ($discount->expired_at < now()) {
            return back()->withErrors([
                "discount" => "کد تخفیف منقضی شده است."
            ]);
        }

        if ($discount->users->count()) {
            if (! in_array(auth()->user()->id, $discount->users->pluck("id")->toArray())) {
                return back()->withErrors([
                    "discount" => "شما قادر به استفاده از این کد تخفیف نیستید."
                ]);
            }
        }

        return "ok";
    }
}
