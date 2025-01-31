<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Illuminate\Support\Facades\Cache;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::resource('users', UserController::class);
});

Route::post('/store-uid', function (Request $request) {
    $uid = $request->input('uid');
    
    if ($uid) {
        // Store UID in cache for later retrieval (expires in 5 minutes)
        Cache::put('latest_uid', $uid, now()->addMinutes(5));
        
        return response()->json(['message' => 'UID stored successfully', 'uid' => $uid]);
    } else {
        return response()->json(['message' => 'UID missing'], 400);
    }
});
Route::get('/test', function () {
    return response()->json(['uid' => Cache::get('latest_uid', 'No UID received yet')]);
});


require __DIR__ . '/auth.php';
