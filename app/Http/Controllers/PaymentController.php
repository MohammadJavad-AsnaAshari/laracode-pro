<?php

namespace App\Http\Controllers;

use App\Helpers\Cart\Cart;
use Illuminate\Http\Request;
use Psy\Util\Str;

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

//      payment
            $payment_check = false;
            if ($payment_check) {
                $token = config('services.payping.token');
                $res_number = \Illuminate\Support\Str::random();
                $args = [
                    "amount" => 1000,
                    "payerName" => auth()->user()->name,
                    "returnUrl" => route('payment.callback'),
                    "clientRefId" => $res_number
                ];

                $payment = new \PayPing\Payment($token);

                try {
                    $payment->pay($args);
                } catch (\Exception $e) {
                    throw $e;
                }
                //echo $payment->getPayUrl();
                $order->payments()->create([
                    'resnumber' => $res_number,
                    'price' => $price
                ]);

                $cart->flush();

                return redirect($payment->getPayUrl());
            }
            $cart->flush();
        }

//        ToDo send error message
        return back();
    }

    public function callback()
    {

    }
}
