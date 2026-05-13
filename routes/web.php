<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\RsvpController;
use App\Http\Controllers\BookmarkController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Auth\AdminLoginController;
use App\Http\Controllers\Auth\AdminRegisterController;
use Illuminate\Support\Facades\Route;

use App\Models\Event;
use App\Models\Category;

Route::get('/', function () {
    $upcomingEvents = Event::approved()->with('category')->whereDate('date', '>=', now())->orderBy('date', 'asc')->take(6)->get();
    $categories = Category::all();
    return view('welcome', compact('upcomingEvents', 'categories'));
})->name('home');

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

// Public event listing (no auth required)
Route::get('/events', [EventController::class, 'index'])->name('events.index');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::middleware('verified')->group(function () {
        // Event Management (Organizers/Admins)
        // IMPORTANT: resource must be registered before the public wildcard show route
        Route::resource('events', EventController::class)->except(['index', 'show']);

        // RSVPs
        Route::post('/events/{event}/rsvp', [RsvpController::class, 'store'])->name('rsvps.store');
        Route::delete('/events/{event}/rsvp', [RsvpController::class, 'destroy'])->name('rsvps.destroy');

        // Bookmarks
        Route::get('/bookmarks', [BookmarkController::class, 'index'])->name('bookmarks.index');
        Route::post('/events/{event}/bookmark', [BookmarkController::class, 'store'])->name('bookmarks.store');
        Route::delete('/events/{event}/bookmark', [BookmarkController::class, 'destroy'])->name('bookmarks.destroy');

        // Admin
        Route::get('/admin', [AdminController::class, 'dashboard'])->name('admin.dashboard');
        Route::patch('/admin/users/{user}/role', [AdminController::class, 'updateRole'])->name('admin.users.role');
        Route::patch('/admin/users/{user}/block', [AdminController::class, 'toggleBlock'])->name('admin.users.block');
        Route::patch('/admin/events/{event}/status', [AdminController::class, 'updateEventStatus'])->name('admin.events.status');
    });
});

// Public event detail — registered AFTER the auth resource group so
// /events/create is caught by the resource route above, not this wildcard.
Route::get('/events/{event}', [EventController::class, 'show'])->name('events.show');

Route::middleware('guest')->group(function () {
    Route::get('/admin/login', [AdminLoginController::class, 'create'])->name('admin.login');
    Route::post('/admin/login', [AdminLoginController::class, 'store']);
    
    Route::get('/admin/register', [AdminRegisterController::class, 'create'])->name('admin.register');
    Route::post('/admin/register', [AdminRegisterController::class, 'store']);
});

require __DIR__.'/auth.php';
