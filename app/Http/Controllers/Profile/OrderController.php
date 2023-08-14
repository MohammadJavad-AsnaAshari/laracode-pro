<?php

namespace App\Http\Controllers\Profile;

use App\Helpers\Cart\Cart;
use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index()
    {
        $orders = auth()->user()->orders()->latest("created_at")->paginate(10);
        return view("profile.orders-list", compact("orders"));
    }

    public function showDetails(Order $order)
    {
        $this->authorize("view", $order);
        return view("profile.orders-detail", compact("order"));
    }

    public function payment(Order $order)
    {
        $this->authorize("view", $order);

//        ToDo add payment

//            test

        $order->update([
            "status" => "paid"
        ]);

//            end-test


//        ToDo send error message
        return back();
    }
}
