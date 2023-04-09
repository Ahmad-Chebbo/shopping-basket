<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Basket extends Model
{
    use HasFactory;

    protected $fillable = [
        'session_id',
        'user_id',
    ];


    /**
     * Define the relationship between Basket and User models
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Define the relationship between Basket and Product models
     */
    public function products()
    {
        return $this->belongsToMany(Product::class, 'basket_items')->withPivot('quantity', 'removed', 'total', 'price')->wherePivot('removed', false);;
    }
}

