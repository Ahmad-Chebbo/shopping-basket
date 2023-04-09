<?php

namespace App\Listeners;

use App\Events\ConvertBasketToUser;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class UpdateBasketUserIdListener
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(ConvertBasketToUser $event)
    {
        $event->basket->update([
            'user_id' => $event->user->id,
            'session_id' => session()->getId(),
        ]);
    }
}
