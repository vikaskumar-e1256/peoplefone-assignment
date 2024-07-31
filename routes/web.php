<?php

use App\Http\Controllers\{
    ProfileController,
    UserController,
    NotificationController
};
use App\Http\Middleware\AdminMiddleware;
use Illuminate\Support\Facades\Route;

Route::impersonate();

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth', AdminMiddleware::class])->group(function(){

    Route::controller(UserController::class)
    ->prefix('users')
    ->name('users.')
    ->group(
        function () {
            Route::get('', 'index')
                ->name('index')
                ->middleware('impersonate.protect');
        }
    );

    Route::controller(NotificationController::class)
    ->name('notifications.')
    ->prefix('notifications')
    ->group(
        function () {
            Route::get('', 'index')
                ->name('index');
            Route::get('/create', 'create')
                ->name('create');
            Route::post('', 'store')
                ->name('store');
            Route::delete('/{notification}', 'destroy')
                ->name('destroy');

            // Fetch notifications
            Route::get('/fetch', 'fetchNotifications')
                ->name('fetch')
                ->withoutMiddleware([AdminMiddleware::class]);

            // Mark a notification as read
            Route::patch('mark-as-read/notifications/{notification}', 'markAsRead')
                ->name('markAsRead')
                ->withoutMiddleware([AdminMiddleware::class]);

            // Mark all notifications as read
            Route::post('/mark-all-read', 'markAllRead')
                ->name('markAllRead')
                ->withoutMiddleware([AdminMiddleware::class]);
        }
    );
});




require __DIR__.'/auth.php';
