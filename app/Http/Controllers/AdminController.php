<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function dashboard()
    {
        if (Auth::user()->role !== 'admin') {
            abort(403);
        }

        $pendingEvents = Event::where('status', 'pending')
            ->withCount('rsvps')
            ->with('user')
            ->get();

        $approvedEvents = Event::where('status', 'approved')
            ->withCount('rsvps')
            ->with('user', 'category')
            ->orderBy('date', 'asc')
            ->get();

        $users = User::all();

        return view('admin.dashboard', compact('pendingEvents', 'approvedEvents', 'users'));
    }

    public function updateRole(Request $request, User $user)
    {
        if (Auth::user()->role !== 'admin') {
            abort(403);
        }

        $request->validate([
            'role' => 'required|in:user,organizer,admin'
        ]);

        $user->update(['role' => $request->role]);

        return back()->with('success', 'User role updated.');
    }

    public function updateEventStatus(Request $request, Event $event)
    {
        if (Auth::user()->role !== 'admin') {
            abort(403);
        }

        $request->validate([
            'status' => 'required|in:approved,rejected'
        ]);

        $event->update(['status' => $request->status]);

        return back()->with('success', 'Event status updated.');
    }
}
