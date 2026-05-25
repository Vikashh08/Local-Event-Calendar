<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Rsvp;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // Load data based on role
        if ($user->role === 'organizer') {
            $hostedEvents = $user->events()->withCount(['rsvps as attendees_count' => function ($query) {
                $query->where('status', 'yes');
            }])->orderBy('date', 'desc')->get();

            $totalEvents = $hostedEvents->count();
            $totalAttendees = $hostedEvents->sum('attendees_count');
            
            // Calculate revenue for paid events
            $totalRevenue = $hostedEvents->sum(function($event) {
                return $event->price > 0 ? $event->price * $event->attendees_count : 0;
            });

            // Get recent registrations across all their events
            $recentRegistrations = Rsvp::with(['user', 'event'])
                ->where('status', 'yes')
                ->whereHas('event', function ($query) use ($user) {
                    $query->where('user_id', $user->id);
                })
                ->orderBy('created_at', 'desc')
                ->take(5)
                ->get();

            return view('dashboard', compact(
                'hostedEvents', 'totalEvents', 'totalAttendees', 'totalRevenue', 'recentRegistrations'
            ));
        }

        // For regular users (attendees)
        $rsvps = $user->rsvps()
            ->with(['event.category'])
            ->orderBy('created_at', 'desc')
            ->get();

        $bookmarks = $user->bookmarks()
            ->with(['event.category'])
            ->get();

        return view('dashboard', compact('rsvps', 'bookmarks'));
    }
}
