<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BasketItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'basket_id',
        'product_id',
        'price',
        'quantity',
        'removed',
        'total',
    ];


    /**
     * Get the product associated with the basket item.
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * Get the basket associated with the basket item.
     */
    public function basket()
    {
        return $this->belongsTo(Basket::class);
    }

}
