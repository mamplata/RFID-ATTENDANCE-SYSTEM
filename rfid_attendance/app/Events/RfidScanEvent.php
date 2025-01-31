<?php
namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class RfidScanEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $scanData;

    public function __construct($scanData)
    {
        $this->scanData = $scanData;
    }

    public function broadcastOn()
    {
        // This is the channel the event will be broadcast on
        return new Channel('attendance');
    }
}
