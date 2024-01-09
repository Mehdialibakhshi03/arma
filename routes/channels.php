<?php

use Illuminate\Support\Facades\Broadcast;

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

//Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
//    return (int) $user->id === (int) $id;
//});

Broadcast::channel('reza', function ($user, $id) {
    return (int) $user->id === (int) $id;
});
Broadcast::channel('new_bid_created', function ($user, $id) {
    return (int) $user->id === (int) $id;
});
Broadcast::channel('market-status-updated', function ($user, $id) {
    return (int) $user->id === (int) $id;
});
Broadcast::channel('change-sales-offer', function ($user, $id) {
    return (int) $user->id === (int) $id;
});

Broadcast::channel('market-setting-updated-channel', function ($user, $id) {
    return (int) $user->id === (int) $id;
});

//
//
//Broadcast::channel('test', function ($user) {
//   return ['ok'];
//});

