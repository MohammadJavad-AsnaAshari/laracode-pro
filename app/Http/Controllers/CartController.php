<?php

namespace App\Http\Controllers;

use App\Helpers\Cart\Cart;
use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function addToCart(Product $product)
    {
        if (Cart::has($product)) {
            if (Cart::cout($product) < $product->inventory) {
                Cart::update($product, 1);
            }
        } else {
            Cart::put([
                "quantity" => 1,
            ],
                $product
            );
        }
        return redirect("/cart");
    }

    public function cart()
    {
        return view("home.cart");
    }

    public function quantityChange(Request $request)
    {
        $data = $request->validate([
            "quantity" => ["required"],
            "id" => ["required"],
        ]);

        if (Cart::has($data["id"])) {
            Cart::update($data["id"], [
                "quantity" => $data["quantity"]
            ]);

            return response(["status" => "success"]);
        }

        return response(["status" => "error"], 404);
    }

    public function deleteFromCart($id)
    {
        Cart::delete($id);

        return back();
    }
}
