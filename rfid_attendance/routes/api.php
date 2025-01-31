<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Cache;

Route::post('/store-uid', function (Request $request) {
    $uid = $request->input('uid');

    if ($uid) {
        // Store UID in cache
        Cache::put('latest_uid', $uid, now()->addMinutes(5));

        // Trigger the event to broadcast the UID
        broadcast(new \App\Events\UidScanned($uid));

        return response()->json(['message' => 'UID stored successfully', 'uid' => $uid]);
    } else {
        return response()->json(['message' => 'UID missing'], 400);
    }
});
