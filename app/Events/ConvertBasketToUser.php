<?php

namespace App\Events;

use App\Models\Basket;
use App\Models\User;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ConvertBasketToUser
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $user;
    public $basket;

    /**
     * Create a new event instance.
     */
    public function __construct(User $user, Basket $basket)
    {
        $this->user = $user;
        $this->basket = $basket;
    }

}
