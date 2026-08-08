<?php

namespace App\Events;

use App\Models\Aspiration;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class AspirationCreated
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $aspiration;

    public function __construct(Aspiration $aspiration)
    {
        $this->aspiration = $aspiration;
    }
}
