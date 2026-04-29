<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RsvpController extends Controller
{
    public function store(Request $request, Event $event)
    {
        $request->validate([
            'status' => 'required|in:yes,no,maybe',
        ]);

        $event->rsvps()->updateOrCreate(
            ['user_id' => Auth::id()],
            ['status' => $request->status]
        );

        return back()->with('success', 'Your RSVP has been recorded.');
    }

    public function destroy(Event $event)
    {
        $event->rsvps()->where('user_id', Auth::id())->delete();
        return back()->with('success', 'Your RSVP has been removed.');
    }
}
