<?php

namespace App\Http\Controllers;

use App\Helpers\Cart\Cart;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function payment()
    {
        $cart = Cart::instance("cart");
        $cartItems = $cart->all();
        if ($cartItems->count()) {
            $price = $cartItems->sum(function ($cart) {
                return $cart["product"]->price * $cart["quantity"];
            });

            $order = auth()->user()->orders()->create([
                "status" => "unpaid",
                "price" => $price
            ]);

            $orderItems = $cartItems->mapWithKeys(function ($cart) {
                return [$cart["product"]->id => ["quantity" => $cart["quantity"]]];
            });

            $order->products()->attach($orderItems);

            return "ok";
        }

//        ToDo send error message
        return back();
    }
}
