<?php

namespace Modules\Cart\Helpers;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Str;
use Modules\Discount\Entities\Discount;

class CartService
{
    protected $cart;
    protected $name = "cart";

    public function __construct()
    {
        $cart = session()->get($this->name) ?? collect([]);
        $this->cart = $cart->count() ? $cart : collect([
            "items" => [],
            "discount" => null
        ]);

//        $this->cart = collect(json_decode(request()->cookie($this->name) , true)) ?? collect([]);
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
                "subject_type" => get_class($obj),
                "discount_percent" => 0
            ]);
        } elseif (!isset($value["id"])) {
            $value = array_merge($value, [
                "id" => Str::random(10)
            ]);
        }

        $this->cart["items"] = collect($this->cart["items"])->put($value["id"], $value);
        $this->storeSession();
//        $this->storeCookie();

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
                collect($this->cart["items"])->where("subject_id", $key->id)->where("subject_type", get_class($key))->first()
            );
        }
        return !is_null(
            collect($this->cart["items"])->firstWhere("id", $key)
        );
    }

    /**
     * @param $key
     * @param $options
     * @return $this
     */
    public function update($key, $options)
    {
        $item = collect($this->get($key, false));

        if (is_numeric($options)) {
            $item = $item->merge([
                "quantity" => $item["quantity"] + $options,
            ]);
        }

        if (is_array($options)) {
            $item = $item->merge($options);
        }

        $this->put($item->toArray());
        return $this;
    }

    /**
     * @param $key
     * @return null
     */
    public function get($key, $withRelationShip = true)
    {
        $item = $key instanceof Model
            ? collect($this->cart["items"])->where("subject_id", $key->id)->where("subject_type", get_class($key))->first()
            : collect($this->cart["items"])->firstWhere("id", $key);

        return $withRelationShip ? $this->withRelationshipIfExist($item) : $item;
    }

    /**
     * @return \Closure|\Illuminate\Support\Collection|mixed|object
     */
    public function all()
    {
        $cart = $this->cart;
        $cart = collect($this->cart["items"])->map(function ($item) use ($cart) {
            $item = $this->withRelationshipIfExist($item);
            $item = $this->checkDiscountValidate($item, $cart["discount"]);
            return $item;
        });

        return $cart;
    }

    /**
     * @param $key
     * @return bool
     */
    public function delete($key)
    {
        if ($this->has($key)) {
            $this->cart["items"] = collect($this->cart["items"])->filter(function ($item) use ($key) {
                if ($key instanceof Model) {
                    return ($item["subject_id"] != $key->id && $item["subject_type"] != get_class($key));
                }
                return $key != $item["id"];
            });

            $this->storeSession();
//            $this->storeCookie();;
            return true;
        }

        return false;
    }

    /**
     * @return $this
     */
    public function flush()
    {
        $this->cart = collect([
            "items" => [],
            "discount" => null
        ]);
        $this->storeSession();
//        $this->storeCookie();

        return $this;
    }

    /**
     * @param $key
     * @return int|mixed
     */
    public function count($key)
    {
        if (!$this->has($key)) return 0;

        return $this->get($key)["quantity"];
    }

    /**
     * @param $item
     * @return mixed
     */
    protected function withRelationshipIfExist($item)
    {
        if (isset($item["subject_id"]) && isset($item["subject_type"])) {
            $class = $item["subject_type"];
            $subject = (new $class())->find($item["subject_id"]);

            $item[strtolower(class_basename($subject))] = $subject;

            unset($item["subject_id"]);
            unset($item["subject_type"]);

            return $item;
        };
        return $item;
    }

    /**
     * @param string $name
     * @return $this
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function instance(string $name)
    {
        $cart = session()->get($this->name) ?? collect([]);
        $this->cart = $cart->count() ? $cart : collect([
            "items" => [],
            "discount" => null
        ]);
        $this->name = $name;
        return $this;
    }

    /**
     * @return void
     */
    protected function storeCookie(): void
    {
        Cookie::queue($this->name, $this->cart->toJson(), 60 * 24 * 7);
    }

    /**
     * @return void
     */
    protected function storeSession(): void
    {
        session()->put($this->name, $this->cart);
    }

    /**
     * @param $discount
     * @return void
     */
    public function addDiscount($discount)
    {
        $this->cart["discount"] = $discount;
        $this->storeSession();
    }

    /**
     * @return mixed
     */
    public function getDiscount()
    {
        return Discount::whereId($this->cart["discount"])->first();
    }

    protected function checkDiscountValidate($item, $discount)
    {
        $discount = Discount::where("id", $discount)->first();
        if ($discount && $discount->expired_at > now()) {
            if (
                (!$discount->products()->count() && !$discount->categories()->count()) ||
                (in_array($item["product"]->id, $discount->products->pluck("id")->toArray())) ||
                (array_intersect($item["product"]->categories->pluck("id")->toArray(), $discount->categories->pluck("id")->toArray()))
            ) {
                $item["discount_percent"] = $discount->percent / 100;
            }
        }

        return $item;
    }
}
