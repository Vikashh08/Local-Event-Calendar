<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\RsvpController;
use App\Http\Controllers\BookmarkController;
use Illuminate\Support\Facades\Route;

use App\Models\Event;
use App\Models\Category;

Route::get('/', function () {
    $upcomingEvents = Event::with('category')->whereDate('date', '>=', now())->orderBy('date', 'asc')->take(6)->get();
    $categories = Category::all();
    return view('welcome', compact('upcomingEvents', 'categories'));
})->name('home');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/events', [EventController::class, 'index'])->name('events.index');
Route::get('/events/{event}', [EventController::class, 'show'])->name('events.show');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Event Management (Organizers/Admins)
    Route::resource('events', EventController::class)->except(['index', 'show']);

    // RSVPs
    Route::post('/events/{event}/rsvp', [RsvpController::class, 'store'])->name('rsvps.store');
    Route::delete('/events/{event}/rsvp', [RsvpController::class, 'destroy'])->name('rsvps.destroy');

    // Bookmarks
    Route::get('/bookmarks', [BookmarkController::class, 'index'])->name('bookmarks.index');
    Route::post('/events/{event}/bookmark', [BookmarkController::class, 'store'])->name('bookmarks.store');
    Route::delete('/events/{event}/bookmark', [BookmarkController::class, 'destroy'])->name('bookmarks.destroy');
});

require __DIR__.'/auth.php';
