<?php

namespace App\Http\Controllers;

use App\Helpers\Cart\Cart;
use App\Models\Payment;
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
                return $cart["discount_percent"] == 0
                    ? $cart["product"]->price * $cart["quantity"]
                    : $cart["product"]->price * $cart["quantity"] - ($cart["product"]->price * $cart["discount_percent"]) * $cart["quantity"];
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
//                    "amount" => $price,
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

//            test

            $order->update([
                "status" => "paid"
            ]);

//            end-test

            $cart->flush();
        }

//        ToDo send error message
        return back();
    }

    public function callback(Request $request)
    {
        $payment = Payment::where("resnumber", $request->clientrefid)->firstOrFail();

        $token = config('services.payping.token');

        $payping = new \PayPing\Payment($token);

        try {
//            $payment->price
            if ($payping->verify($request->refid, 1000)) {
                $payment->update([
                    "status" => 1
                ]);

                $payment->order()->update([
                    "status" => "paid"
                ]);

//                alert()->success()
//                return redirect()

            } else {
//                alert()->error()
//                return redirect()
            }
        } catch (PayPingException $e) {
            foreach (json_decode($e->getMessage(), true) as $msg) {
                echo $msg;
            }
        }
    }
}
