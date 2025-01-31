<?php
namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class UidScanned implements ShouldBroadcast
{
    use Dispatchable, SerializesModels;

    public $uid;

    public function __construct($uid)
    {
        $this->uid = $uid;
    }

    public function broadcastOn()
    {
        return new Channel('attendance');
    }
}
