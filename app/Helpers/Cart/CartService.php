<?php

namespace App\Helpers\Cart;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class CartService
{
    protected $cart;

    public function __construct()
    {
        $this->cart = session()->get("cart") ?? collect([]);
    }

    /**
     * @param array $value
     * @param $obj
     * @return $this
     */
    public function put(array $value, $obj = null)
    {
        if (!is_null($obj) && $obj instanceof Model) {
            $value = array_merge($value, [
                "id" => Str::random(10),
                "subject_id" => $obj->id,
                "subject_type" => get_class($obj)
            ]);
        } else {
            $value = array_merge($value, [
                "id" => Str::random(10)
            ]);
        }

        $this->cart->put($value["id"], $value);
        session()->put("cart", $this->cart);

        return $this;
    }

    /**
     * @param $key
     * @return bool
     */
    public function has($key)
    {
        if ($key instanceof Model) {
            return !is_null(
                $this->cart->where("subject_id", $key->id)->where("subject_type", get_class($key))->first()
            );
        }
        return !is_null(
            $this->cart->firstWhere("id", $key)
        );
    }

    /**
     * @param $key
     * @return null
     */
    public function get($key)
    {
        $item = $key instanceof Model
            ? $this->cart->where("subject_id", $key->id)->where("subject_type", get_class($key))->first()
            : $this->cart->firstWhere("id", $key);

        return $item;
    }

    /**
     * @return \Closure|\Illuminate\Support\Collection|mixed|object
     */
    public function all()
    {
        return $this->cart;
    }
}
