<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'image',
        'quantity',
        'price',
        'discount_price',
    ];


    /**
     * Define the relationship between Product and Basket models
     */
    public function baskets()
    {
        return $this->belongsToMany(Basket::class, 'basket_items')->withPivot('quantity', 'removed', 'total', 'price');
    }
}
