<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // Load upcoming RSVPs with event details (only future events)
        $rsvps = $user->rsvps()
            ->with(['event.category'])
            ->whereHas('event', fn($q) => $q->whereDate('date', '>=', now()))
            ->orderBy('created_at', 'desc')
            ->get();

        // Load all bookmarks with event details
        $bookmarks = $user->bookmarks()
            ->with(['event.category'])
            ->get();

        return view('dashboard', compact('rsvps', 'bookmarks'));
    }
}
