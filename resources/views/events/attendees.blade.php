<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-bold text-2xl text-gray-800 leading-tight">
                <a href="{{ route('events.show', $event) }}" class="text-gray-900 hover:text-black mr-2 flex items-center inline-flex">
                    <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                    Back to Event
                </a>
            </h2>
        </div>
    </x-slot>

    <div class="py-12 bg-gray-50 min-h-screen">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-3xl border border-gray-100">
                <div class="p-8 border-b border-gray-100 bg-gray-900 text-white flex justify-between items-center">
                    <div>
                        <h3 class="text-2xl font-bold">{{ $event->title }} - Attendee List</h3>
                        <p class="text-gray-300 text-sm mt-1">Manage RSVPs for your event</p>
                    </div>
                    <div class="text-right">
                        <span class="block text-2xl font-bold">{{ $event->rsvps->where('status', 'yes')->count() }}</span>
                        <span class="text-sm text-gray-300">Total Going</span>
                    </div>
                </div>

                <div class="p-8">
                    @if($event->rsvps->isEmpty())
                        <div class="text-center py-12 text-gray-500">
                            <svg class="w-12 h-12 mx-auto text-gray-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                            <p class="text-lg">No RSVPs yet for this event.</p>
                        </div>
                    @else
                        <div class="overflow-x-auto">
                            <table class="w-full text-left text-sm text-gray-600">
                                <thead class="bg-gray-50 border-b border-gray-100 text-gray-700">
                                    <tr>
                                        <th class="px-6 py-4 font-semibold">Attendee Name</th>
                                        <th class="px-6 py-4 font-semibold">Email</th>
                                        <th class="px-6 py-4 font-semibold">RSVP Status</th>
                                        <th class="px-6 py-4 font-semibold">Date Responded</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-100">
                                    @foreach($event->rsvps as $rsvp)
                                        <tr class="hover:bg-gray-50 transition">
                                            <td class="px-6 py-4 font-medium text-gray-900 flex items-center">
                                                <div class="h-8 w-8 rounded-full bg-gray-200 flex items-center justify-center text-gray-700 font-bold mr-3">
                                                    {{ substr($rsvp->user->name, 0, 1) }}
                                                </div>
                                                {{ $rsvp->user->name }}
                                            </td>
                                            <td class="px-6 py-4">{{ $rsvp->user->email }}</td>
                                            <td class="px-6 py-4">
                                                @if($rsvp->status === 'yes')
                                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-green-100 text-green-800">Going</span>
                                                @elseif($rsvp->status === 'maybe')
                                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-yellow-100 text-yellow-800">Maybe</span>
                                                @else
                                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-red-100 text-red-800">Not Going</span>
                                                @endif
                                            </td>
                                            <td class="px-6 py-4 text-gray-500">
                                                {{ $rsvp->updated_at->format('M d, Y g:i A') }}
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
