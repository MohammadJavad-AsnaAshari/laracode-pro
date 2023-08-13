<?php

namespace App\Helpers\Cart;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Facade;
use Ramsey\Collection\Collection;

/**
 * @method static bool has($id);
 * @method static Collection all();
 * @method static array get($key);
 * @method static Cart put(array $value, Model $obj = null);
 * @method static Cart update($key, $options);
 * @method static int count($key);
 * @method static Cart instance(string $name);
 * @method static Cart flush();
 */
class Cart extends Facade
{
    protected static function getFacadeAccessor()
    {
        return "cart";
    }
}
