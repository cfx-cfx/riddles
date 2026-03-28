<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use App\Models\Game;
use App\Models\Message;

class MessageSent implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Create a new event instance.
     */
    public function __construct(public Message $message, public ?Game $game) {}

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        return [
            new PresenceChannel('game.' . $this->game->id),
        ];
    }
    public function broadcastWith(): array
    {
        return [
            'id' => $this->message->id,
            'type' => $this->message->type,
            'content' => $this->message->content,
            'user' => $this->message->user
                ? [
                    'id' => $this->message->user->id,
                    'name' => $this->message->user->name,
                ]
                : null,
            'parent_id' => $this->message->parent_id,
            'created_at' => $this->message->created_at->toISOString(),
            'has_no_replies' => $this->message->replies->isEmpty(),
            'stage' => $this->message->stage,
        ];
    }

    // название сообщения - в Echo указывать с точкой впереди
    public function broadcastAs(): string
    {
        return 'message.sent';
    }
}
