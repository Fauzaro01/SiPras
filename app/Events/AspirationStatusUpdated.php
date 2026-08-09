<?php

namespace App\Events;

use App\Models\Aspiration;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class AspirationStatusUpdated
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $aspiration;

    public $oldStatus;

    public $newStatus;

    public function __construct(Aspiration $aspiration, $oldStatus, $newStatus)
    {
        $this->aspiration = $aspiration;
        $this->oldStatus = $oldStatus;
        $this->newStatus = $newStatus;
    }
}
