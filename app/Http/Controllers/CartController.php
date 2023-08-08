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
           if (Cart::cout($product) < $product->inventory){
               Cart::update($product, 1);
           }
        } else {
            Cart::put([
                "quantity" => 1,
                "price" => $product->price,
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
}
