<?php

namespace App\Models;

use App\ProductAttributeValue;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        "title", "description", "price", "inventory", "view_count"
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function comments()
    {
        return $this->morphMany(Comment::class, "commentable");
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }

    public function attributes()
    {
        return $this->belongsToMany(Attribute::class)->using(ProductAttributeValue::class)->withPivot(['value_id']);
    }

    public function orders()
    {
        return $this->belongsToMany(Order::class);
    }

    public function value()
    {
        //ToDo attribute_product relationship
    }
}
