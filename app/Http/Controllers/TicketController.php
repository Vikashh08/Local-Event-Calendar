<?php

namespace App\Http\Controllers;

use App\Models\Rsvp;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TicketController extends Controller
{
    /**
     * Display a listing of the user's tickets.
     */
    public function index()
    {
        $tickets = Auth::user()->rsvps()
            ->where('status', 'yes')
            ->with('event.category')
            ->whereHas('event', function($query) {
                $query->whereDate('date', '>=', now()->subDays(1));
            })
            ->orderBy('created_at', 'desc')
            ->get();

        return view('tickets.index', compact('tickets'));
    }

    /**
     * Display the specified ticket.
     */
    public function show(Rsvp $rsvp)
    {
        // Ensure the user owns this ticket
        if ($rsvp->user_id !== Auth::id()) {
            abort(403);
        }

        // Only allow viewing 'yes' RSVPs as tickets
        if ($rsvp->status !== 'yes') {
            return redirect()->route('tickets.index');
        }

        $rsvp->load('event.category', 'user');

        return view('tickets.show', compact('rsvp'));
    }
}
