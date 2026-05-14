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
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8 space-y-6">

            {{-- Header Card --}}
            <div class="bg-gray-900 rounded-3xl p-8 text-white flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                <div>
                    <p class="text-gray-400 text-xs font-semibold uppercase tracking-widest mb-1">Attendee List</p>
                    <h3 class="text-2xl font-black tracking-tight">{{ $event->title }}</h3>
                    <p class="text-gray-300 text-sm mt-1">{{ \Carbon\Carbon::parse($event->date)->format('l, F j, Y') }}</p>
                </div>
                <div class="flex gap-4">
                    @php
                        $goingCount  = $event->rsvps->where('status', 'yes')->count();
                        $maybeCount  = $event->rsvps->where('status', 'maybe')->count();
                        $noCount     = $event->rsvps->where('status', 'no')->count();
                    @endphp
                    <div class="bg-white/10 rounded-2xl px-5 py-3 text-center">
                        <p class="text-2xl font-black">{{ $goingCount }}</p>
                        <p class="text-xs text-gray-400 mt-0.5">Going</p>
                    </div>
                    <div class="bg-white/10 rounded-2xl px-5 py-3 text-center">
                        <p class="text-2xl font-black">{{ $maybeCount }}</p>
                        <p class="text-xs text-gray-400 mt-0.5">Maybe</p>
                    </div>
                    <div class="bg-white/10 rounded-2xl px-5 py-3 text-center">
                        <p class="text-2xl font-black">{{ $noCount }}</p>
                        <p class="text-xs text-gray-400 mt-0.5">Not Going</p>
                    </div>
                </div>
            </div>

            {{-- Attendees Table --}}
            <div class="bg-white overflow-hidden shadow-sm rounded-3xl border border-gray-100">
                @if($event->rsvps->isEmpty())
                    <div class="text-center py-20">
                        <div class="w-16 h-16 mx-auto bg-gray-100 rounded-2xl flex items-center justify-center mb-4">
                            <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                        </div>
                        <h3 class="text-lg font-bold text-gray-700">No RSVPs yet</h3>
                        <p class="text-sm text-gray-400 mt-1">Share your event to start getting attendees!</p>
                    </div>
                @else
                    <div class="overflow-x-auto">
                        <table class="w-full text-left text-sm">
                            <thead>
                                <tr class="border-b border-gray-100">
                                    <th class="px-6 py-4 text-xs font-bold text-gray-400 uppercase tracking-widest">Attendee</th>
                                    <th class="px-6 py-4 text-xs font-bold text-gray-400 uppercase tracking-widest">Email</th>
                                    <th class="px-6 py-4 text-xs font-bold text-gray-400 uppercase tracking-widest">Status</th>
                                    <th class="px-6 py-4 text-xs font-bold text-gray-400 uppercase tracking-widest">Responded</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-50">
                                @foreach($event->rsvps as $rsvp)
                                    <tr class="hover:bg-gray-50/80 transition-colors duration-150">
                                        <td class="px-6 py-4">
                                            <div class="flex items-center gap-3">
                                                <div class="h-9 w-9 rounded-xl bg-gray-900 flex items-center justify-center text-white font-bold text-sm shrink-0">
                                                    {{ strtoupper(substr($rsvp->user->name, 0, 1)) }}
                                                </div>
                                                <span class="font-semibold text-gray-900">{{ $rsvp->user->name }}</span>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 text-gray-500">{{ $rsvp->user->email }}</td>
                                        <td class="px-6 py-4">
                                            @if($rsvp->status === 'yes')
                                                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-emerald-50 text-emerald-700 ring-1 ring-emerald-200">
                                                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>Going
                                                </span>
                                            @elseif($rsvp->status === 'maybe')
                                                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-yellow-50 text-yellow-700 ring-1 ring-yellow-200">
                                                    <span class="w-1.5 h-1.5 rounded-full bg-yellow-500"></span>Maybe
                                                </span>
                                            @else
                                                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-red-50 text-red-700 ring-1 ring-red-200">
                                                    <span class="w-1.5 h-1.5 rounded-full bg-red-500"></span>Not Going
                                                </span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 text-gray-400 text-xs">
                                            {{ $rsvp->updated_at->format('M d, Y · g:i A') }}
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
</x-app-layout>
