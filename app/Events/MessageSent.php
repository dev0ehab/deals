<?php

namespace App\Events;

use App\Models\Conversation;
use App\Models\Message;
use Modules\Accounts\Entities\User;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class MessageSent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public function __construct(
        public  User $user,
        public  Message $message,
        public  Conversation $conversation,
        public  User $receiver
    ) {
    }

    public function broadcastWith()
    {
        return [
            'user_id' => $this->user->id,
            'message' => $this->message->id,
            'conversation_id' => $this->conversation->id,
            'receiver_id' => $this->receiver->id,
            'content' => $this->message?->body,
            'image' => asset($this->message->getFirstMediaUrl('image')),
            'sender_avatar' => $this->user->avatar,
        ];
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new Channel('chat.' . $this->conversation->id);
    }
    /**
     * > This function tells Laravel that when a new message is created, it should broadcast it as a
     * "new-message" event
     *
     * @return The name of the event.
     */
    public function broadcastAs()
    {
        return "new-message";
    }
}
