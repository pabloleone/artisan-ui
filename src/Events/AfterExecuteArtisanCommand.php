<?php

namespace Pabloleone\ArtisanUi\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class AfterExecuteArtisanCommand
{
    use Dispatchable;
    use InteractsWithSockets;
    use SerializesModels;

    public string $exitCode;

    public string $output;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(string $exitCode, string $output)
    {
        // TODO: check we can add listeners to laravel implementation
        $this->exitCode = $exitCode;
        $this->output = $output;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}
