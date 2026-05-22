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
        
        $categories = \App\Models\Category::withCount('events')->get();

        $stats = [
            'total_users' => User::count(),
            'total_events' => Event::where('status', 'approved')->count(),
            'pending_events' => $pendingEvents->count(),
            'total_rsvps' => \App\Models\Rsvp::where('status', 'yes')->count(),
        ];

        return view('admin.dashboard', compact('pendingEvents', 'approvedEvents', 'users', 'stats', 'categories'));
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

    public function toggleBlock(User $user)
    {
        if (Auth::user()->role !== 'admin') {
            abort(403);
        }

        if (Auth::id() === $user->id) {
            return back()->with('error', 'You cannot block yourself.');
        }

        $user->update(['is_blocked' => !$user->is_blocked]);

        $status = $user->is_blocked ? 'blocked' : 'unblocked';
        return back()->with('success', "User has been {$status}.");
    }

    public function storeCategory(Request $request)
    {
        if (Auth::user()->role !== 'admin') {
            abort(403);
        }

        $request->validate([
            'name' => 'required|string|max:255|unique:categories,name'
        ]);

        \App\Models\Category::create([
            'name' => $request->name,
            'slug' => \Illuminate\Support\Str::slug($request->name)
        ]);

        return back()->with('success', 'Category created successfully.');
    }

    public function updateCategory(Request $request, \App\Models\Category $category)
    {
        if (Auth::user()->role !== 'admin') {
            abort(403);
        }

        $request->validate([
            'name' => 'required|string|max:255|unique:categories,name,' . $category->id
        ]);

        $category->update([
            'name' => $request->name,
            'slug' => \Illuminate\Support\Str::slug($request->name)
        ]);

        return back()->with('success', 'Category updated successfully.');
    }

    public function destroyCategory(\App\Models\Category $category)
    {
        if (Auth::user()->role !== 'admin') {
            abort(403);
        }

        // Optional: Ensure no events are using this category before deleting,
        // or let the database foreign key constraints handle it.
        if ($category->events()->count() > 0) {
            return back()->with('error', 'Cannot delete category that is assigned to events.');
        }

        $category->delete();

        return back()->with('success', 'Category deleted successfully.');
    }
}
