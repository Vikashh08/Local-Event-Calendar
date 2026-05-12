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

    /**
     * Display the specified resource.
     */
    public function show(Event $event)
    {
        $event->load('category', 'user:id,name');
        return response()->json($event);
    }
}
