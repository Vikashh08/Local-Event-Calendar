<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-3xl text-gray-800 leading-tight tracking-tight">
            {{ __('Admin Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-12">
            
            <!-- Pending Events Section -->
            <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="p-6 border-b border-gray-100 bg-gray-900 text-white flex justify-between items-center">
                    <h3 class="text-xl font-bold flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path></svg>
                        Pending Event Approvals
                    </h3>
                    <span class="bg-gray-700 text-sm font-bold px-3 py-1 rounded-full">{{ $pendingEvents->count() }} Pending</span>
                </div>
                
                @if($pendingEvents->isEmpty())
                    <div class="p-12 text-center text-gray-500">
                        <svg class="w-12 h-12 mx-auto text-gray-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                        <p class="text-lg">All caught up! No pending events to review.</p>
                    </div>
                @else
                    <div class="overflow-x-auto">
                        <table class="w-full text-left text-sm text-gray-600">
                            <thead class="bg-gray-50 border-b border-gray-100 text-gray-700">
                                <tr>
                                    <th class="px-6 py-4 font-semibold">Event Title</th>
                                    <th class="px-6 py-4 font-semibold">Organizer</th>
                                    <th class="px-6 py-4 font-semibold">Date</th>
                                    <th class="px-6 py-4 font-semibold text-right">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                @foreach($pendingEvents as $event)
                                    <tr class="hover:bg-gray-50 transition">
                                        <td class="px-6 py-4 font-medium text-gray-900">
                                            <a href="{{ route('events.show', $event) }}" class="hover:text-gray-600 underline" target="_blank">{{ $event->title }}</a>
                                        </td>
                                        <td class="px-6 py-4">{{ $event->user->name }}</td>
                                        <td class="px-6 py-4">{{ \Carbon\Carbon::parse($event->date)->format('M d, Y') }}</td>
                                        <td class="px-6 py-4 flex justify-end space-x-2">
                                            <form action="{{ route('admin.events.status', $event) }}" method="POST">
                                                @csrf
                                                @method('PATCH')
                                                <input type="hidden" name="status" value="approved">
                                                <button type="submit" class="bg-emerald-100 text-emerald-800 hover:bg-emerald-200 px-4 py-1.5 rounded-lg font-semibold text-xs transition">Approve</button>
                                            </form>
                                            <form action="{{ route('admin.events.status', $event) }}" method="POST">
                                                @csrf
                                                @method('PATCH')
                                                <input type="hidden" name="status" value="rejected">
                                                <button type="submit" class="bg-red-100 text-red-800 hover:bg-red-200 px-4 py-1.5 rounded-lg font-semibold text-xs transition">Reject</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>

            <!-- User Management Section -->
            <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="p-6 border-b border-gray-100 bg-gray-900 text-white flex justify-between items-center">
                    <h3 class="text-xl font-bold flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                        User Management
                    </h3>
                </div>
                
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-sm text-gray-600">
                        <thead class="bg-gray-50 border-b border-gray-100 text-gray-700">
                            <tr>
                                <th class="px-6 py-4 font-semibold">Name</th>
                                <th class="px-6 py-4 font-semibold">Email</th>
                                <th class="px-6 py-4 font-semibold">Current Role</th>
                                <th class="px-6 py-4 font-semibold text-right">Update Role</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @foreach($users as $user)
                                <tr class="hover:bg-gray-50 transition">
                                    <td class="px-6 py-4 font-medium text-gray-900">{{ $user->name }}</td>
                                    <td class="px-6 py-4">{{ $user->email }}</td>
                                    <td class="px-6 py-4">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold {{ $user->role === 'admin' ? 'bg-gray-900 text-white' : ($user->role === 'organizer' ? 'bg-gray-200 text-gray-800' : 'bg-gray-100 text-gray-600') }}">
                                            {{ ucfirst($user->role) }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 flex justify-end">
                                        <form action="{{ route('admin.users.role', $user) }}" method="POST" class="flex items-center space-x-2">
                                            @csrf
                                            @method('PATCH')
                                            <select name="role" class="text-sm rounded-lg border-gray-300 py-1.5 pl-3 pr-8 focus:border-gray-900 focus:ring-gray-900">
                                                <option value="user" {{ $user->role === 'user' ? 'selected' : '' }}>User</option>
                                                <option value="organizer" {{ $user->role === 'organizer' ? 'selected' : '' }}>Organizer</option>
                                                <option value="admin" {{ $user->role === 'admin' ? 'selected' : '' }}>Admin</option>
                                            </select>
                                            <button type="submit" class="bg-gray-900 text-white hover:bg-gray-800 px-4 py-1.5 rounded-lg font-semibold text-xs transition">Update</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
