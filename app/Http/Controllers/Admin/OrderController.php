<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use RealRashid\SweetAlert\Facades\Alert;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $orders = Order::query();

        if ($search = \request('search')) {
            $orders->where('id', $search)->orWhere('tracking_serial', $search);
        }

        $orders = $orders->where("status", \request("type"))->latest()->paginate(10);

        return view("admin.orders.all", compact('orders'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Order $order)
    {
        $products = $order->products()->paginate(10);
        return view("admin.orders.details", compact(["products", "order"]));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Order $order)
    {
        return view("admin.orders.edit", compact("order"));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Order $order)
    {
        $data = $this->validate($request, [
            "status" => ["required", Rule::in(["unpaid", "paid", "preparation", "posted", "received", "canceled"])],
            "tracking_serial" => "required"
        ]);

        $order->update($data);

        Alert::success('Order Successfully Update !', 'Success Message');
        return redirect(route("admin.orders.index") . "?type=$order->status");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Order $order)
    {
        $order->delete();

        Alert::success('Order Successfully Delete !', 'Warning Message');
        return back();
    }

    public function payments(Order $order)
    {
        $payments = $order->payments()->latest()->paginate(10);
        return view("admin.orders.payments", compact(["payments", "order"]));
    }
}
