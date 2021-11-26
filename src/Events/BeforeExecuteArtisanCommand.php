<?php

namespace Pabloleone\ArtisanUi\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class BeforeExecuteArtisanCommand
{
    use Dispatchable;
    use InteractsWithSockets;
    use SerializesModels;

    public string $command;

    public array $parameters;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(string $command, array $parameters)
    {
        // TODO: check we can add listeners to laravel implementation
        $this->command = $command;
        $this->parameters = $parameters;
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
