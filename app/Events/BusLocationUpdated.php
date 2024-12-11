<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class BusLocationUpdated implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public string $busUuid;
    public float $latitude;
    public float $longitude;

    public function __construct(
        string $busUuid,
        float $latitude,
        float $longitude
    ) {
        $this->busUuid = $busUuid;
        $this->latitude = $latitude;
        $this->longitude = $longitude;
    }

    public function broadcastAs()
    {
        return "client-send";
    }

    public function broadcastOn()
    {
        return new Channel('bus-location');
        // return new Channel('bus-location.'.$this->busUuid);
    }
}
