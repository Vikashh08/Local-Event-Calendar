<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BookmarkController extends Controller
{
    public function index()
    {
        $events = Auth::user()->bookmarks()->with('event.category')->get()->pluck('event');
        return view('bookmarks.index', compact('events'));
    }

    public function store(Event $event)
    {
        Auth::user()->bookmarks()->firstOrCreate(['event_id' => $event->id]);
        return back()->with('success', 'Event bookmarked.');
    }

    public function destroy(Event $event)
    {
        Auth::user()->bookmarks()->where('event_id', $event->id)->delete();
        return back()->with('success', 'Bookmark removed.');
    }
}
