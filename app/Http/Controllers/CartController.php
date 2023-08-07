<?php

namespace App\Http\Controllers;

use App\Helpers\Cart\Cart;
use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function addToCart(Product $product)
    {
//        return session()->get("cart");
        if(!Cart::has($product)) {
            Cart::put([
                "quantity" => 100,
                "price" => $product->price,
            ],
                $product
            );
        }
        return "ok";
    }
}
