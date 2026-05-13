<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Event;
use Illuminate\Http\Request;

class EventController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Event::with('category');

        if ($request->has('search')) {
            $query->where('title', 'like', '%' . $request->search . '%')
                  ->orWhere('location', 'like', '%' . $request->search . '%');
        }

        if ($request->has('category')) {
            $query->where('category_id', $request->category);
        }

        $events = $query->orderBy('date', 'asc')->paginate(15);

        return response()->json($events);
    }

    public function show(Event $event)
    {
        $event->load('category', 'user:id,name');
        return response()->json($event);
    }

    public function store(\App\Http\Requests\StoreEventRequest $request)
    {
        if (!$request->user()->can('create', Event::class)) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $data = $request->validated();
        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('events', 'public');
        }

        $event = $request->user()->events()->create($data);

        return response()->json($event, 201);
    }

    public function update(\App\Http\Requests\UpdateEventRequest $request, Event $event)
    {
        if (!$request->user()->can('update', $event)) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $data = $request->validated();
        if ($request->hasFile('image')) {
            if ($event->image) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($event->image);
            }
            $data['image'] = $request->file('image')->store('events', 'public');
        }

        $event->update($data);

        return response()->json($event);
    }

    public function destroy(Request $request, Event $event)
    {
        if (!$request->user()->can('delete', $event)) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $event->delete();

        return response()->json(['message' => 'Event deleted successfully']);
    }
}
