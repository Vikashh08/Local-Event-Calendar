<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Notifications\RsvpConfirmed;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RsvpController extends Controller
{
    public function store(Request $request, Event $event)
    {
        $request->validate([
            'status' => 'required|in:yes,no,maybe',
        ]);

        $existingRsvp = $event->rsvps()->where('user_id', Auth::id())->first();

        // Enforce capacity limit if RSVPing 'yes' and wasn't already 'yes'
        if ($request->status === 'yes' && (! $existingRsvp || $existingRsvp->status !== 'yes')) {
            if ($event->capacity) {
                $yesCount = $event->rsvps()->where('status', 'yes')->count();
                if ($yesCount >= $event->capacity) {
                    return back()->with('error', 'Sorry, this event has reached its maximum capacity.');
                }
            }
        }

        $rsvp = $event->rsvps()->updateOrCreate(
            ['user_id' => Auth::id()],
            ['status' => $request->status]
        );

        if ($request->status === 'yes' && $rsvp->wasRecentlyCreated) {
            Auth::user()->notify(new RsvpConfirmed($event));
        }

        return back()->with('success', 'Your RSVP has been recorded.');
    }

    public function destroy(Event $event)
    {
        $event->rsvps()->where('user_id', Auth::id())->delete();
        return back()->with('success', 'Your RSVP has been removed.');
    }
}
