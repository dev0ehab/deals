<?php

use Illuminate\Support\Facades\Broadcast;
use Modules\Chats\Entities\Chat;

/*
|--------------------------------------------------------------------------
| Broadcast Channels
|--------------------------------------------------------------------------
|
| Here you may register all of the event broadcasting channels that your
| application supports. The given channel authorization callbacks are
| used to check if an authenticated user can listen to the channel.
|
*/



Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});

// Broadcast::channel('private-chat-channel.{id}', function ($user, $id) {
//     $chat  = Chat::find($id);

//     return $chat->sendable->is($user) || $chat->receivable->is($user) ;

// });
