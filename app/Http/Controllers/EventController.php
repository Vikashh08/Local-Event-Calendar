<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Category;
use App\Http\Requests\StoreEventRequest;
use App\Http\Requests\UpdateEventRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class EventController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Event::with('category', 'user')->where(function($q) {
            $q->where('status', 'approved');
            if (Auth::check()) {
                $q->orWhere('user_id', Auth::id());
            }
        });

        if ($request->has('search')) {
            $query->where('title', 'like', '%' . $request->search . '%')
                  ->orWhere('location', 'like', '%' . $request->search . '%');
        }

        if ($request->has('category')) {
            $query->where('category_id', $request->category);
        }

        if ($request->has('date')) {
            $query->whereDate('date', $request->date);
        }

        $events = $query->orderBy('date', 'asc')->paginate(12);
        $categories = Category::all();

        return view('events.index', compact('events', 'categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (!Auth::user()->can('create', Event::class)) {
            return redirect()->route('events.index')->with('error', 'Only organizers can create events.');
        }

        $categories = Category::all();
        return view('events.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreEventRequest $request)
    {
        if (!Auth::user()->can('create', Event::class)) {
            return redirect()->route('events.index')->with('error', 'Only organizers can create events.');
        }

        $data = $request->validated();

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('events', 'public');
        }

        $event = Auth::user()->events()->create($data);

        return redirect()->route('events.show', $event)->with('success', 'Event created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Event $event)
    {
        $event->load('category', 'user', 'rsvps.user');
        return view('events.show', compact('event'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Event $event)
    {
        if (!Auth::user()->can('update', $event)) {
            return redirect()->route('events.index')->with('error', 'Unauthorized action.');
        }

        $categories = Category::all();
        return view('events.edit', compact('event', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateEventRequest $request, Event $event)
    {
        if (!Auth::user()->can('update', $event)) {
            return redirect()->route('events.index')->with('error', 'Unauthorized action.');
        }

        $data = $request->validated();

        if ($request->hasFile('image')) {
            // Delete old image if it exists
            if ($event->image) {
                Storage::disk('public')->delete($event->image);
            }
            $data['image'] = $request->file('image')->store('events', 'public');
        }

        $event->update($data);

        return redirect()->route('events.show', $event)->with('success', 'Event updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Event $event)
    {
        if (!Auth::user()->can('delete', $event)) {
            return redirect()->route('events.index')->with('error', 'Unauthorized action.');
        }

        $event->delete();

        return redirect()->route('events.index')->with('success', 'Event deleted successfully.');
    }

    /**
     * Display a list of attendees for the event.
     */
    public function attendees(Event $event)
    {
        if (!Auth::user()->can('update', $event)) {
            return redirect()->route('events.index')->with('error', 'Unauthorized action.');
        }

        $event->load(['rsvps.user' => function($query) {
            $query->orderBy('name');
        }]);

        return view('events.attendees', compact('event'));
    }
}
