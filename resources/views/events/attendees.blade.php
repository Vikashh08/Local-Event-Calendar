<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-black text-2xl text-slate-900 tracking-tight">
                <a href="{{ route('events.show', $event) }}" class="text-slate-500 hover:text-indigo-655 mr-2 inline-flex items-center gap-2 text-xs font-bold uppercase tracking-widest">
                    <svg class="w-4 h-4 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    Back to Event
                </a>
            </h2>
        </div>
    </x-slot>

    <div class="py-12 bg-slate-50 min-h-screen">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">

            {{-- Header Stats Card --}}
            <div class="bg-white border border-slate-200 rounded-[32px] p-8 text-slate-800 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-6 shadow-sm">
                <div>
                    <div class="flex items-center gap-3 mb-2">
                        <p class="text-slate-400 text-[10px] font-black uppercase tracking-widest">Attendee Manager</p>
                        @if($event->rsvps->where('status', 'yes')->isNotEmpty())
                            <a href="{{ route('events.export', $event) }}" class="inline-flex items-center px-3 py-1 bg-indigo-50 border border-indigo-100 hover:bg-indigo-100 text-indigo-600 text-[9px] font-black uppercase tracking-widest rounded-full transition-colors">
                                <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                                </svg>
                                Export CSV
                            </a>
                        @endif
                    </div>
                    <h3 class="text-2xl font-black text-slate-900 tracking-tight leading-tight">{{ $event->title }}</h3>
                    <p class="text-slate-500 text-xs font-semibold mt-1">{{ \Carbon\Carbon::parse($event->date)->format('l, F j, Y') }}</p>
                </div>
                <div class="flex gap-4">
                    @php
                        $goingCount  = $event->rsvps->where('status', 'yes')->count();
                        $maybeCount  = $event->rsvps->where('status', 'maybe')->count();
                        $noCount     = $event->rsvps->where('status', 'no')->count();
                    @endphp
                    <div class="bg-indigo-50 border border-indigo-100 rounded-2xl px-5 py-3 text-center min-w-[70px]">
                        <p class="text-2xl font-black text-indigo-600 tracking-tight">{{ $goingCount }}</p>
                        <p class="text-[9px] font-bold text-slate-450 uppercase tracking-widest mt-0.5">Going</p>
                    </div>
                    <div class="bg-amber-50 border border-amber-100 rounded-2xl px-5 py-3 text-center min-w-[70px]">
                        <p class="text-2xl font-black text-amber-600 tracking-tight">{{ $maybeCount }}</p>
                        <p class="text-[9px] font-bold text-slate-450 uppercase tracking-widest mt-0.5">Maybe</p>
                    </div>
                    <div class="bg-rose-50 border border-rose-100 rounded-2xl px-5 py-3 text-center min-w-[70px]">
                        <p class="text-2xl font-black text-rose-600 tracking-tight">{{ $noCount }}</p>
                        <p class="text-[9px] font-bold text-slate-450 uppercase tracking-widest mt-0.5">No</p>
                    </div>
                </div>
            </div>

            {{-- Attendees Table --}}
            <div class="bg-white overflow-hidden shadow-sm rounded-[32px] border border-slate-200">
                @if($event->rsvps->isEmpty())
                    <div class="text-center py-20 bg-white">
                        <div class="w-16 h-16 mx-auto bg-slate-50 border border-slate-200 rounded-2xl flex items-center justify-center mb-4 text-slate-400">
                            <svg class="w-8 h-8 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                            </svg>
                        </div>
                        <h3 class="text-lg font-bold text-slate-900">No RSVPs yet</h3>
                        <p class="text-slate-500 text-xs font-semibold mt-1">Publish and share your event to start getting bookings!</p>
                    </div>
                @else
                    <div class="overflow-x-auto">
                        <table class="w-full text-left text-sm border-collapse">
                            <thead>
                                <tr class="bg-slate-50 border-b border-slate-200">
                                    <th class="px-6 py-4 text-[10px] font-black text-slate-450 uppercase tracking-widest">Attendee</th>
                                    <th class="px-6 py-4 text-[10px] font-black text-slate-450 uppercase tracking-widest">Email</th>
                                    <th class="px-6 py-4 text-[10px] font-black text-slate-450 uppercase tracking-widest">Status</th>
                                    <th class="px-6 py-4 text-[10px] font-black text-slate-450 uppercase tracking-widest">Responded</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($event->rsvps as $rsvp)
                                    <tr class="border-b border-slate-100 hover:bg-slate-50/50 transition-colors duration-150">
                                        <td class="px-6 py-4">
                                            <div class="flex items-center gap-3">
                                                <div class="h-9 w-9 rounded-xl bg-slate-800 flex items-center justify-center text-white font-bold text-xs shrink-0 uppercase shadow-sm">
                                                    {{ substr($rsvp->user->name, 0, 1) }}
                                                </div>
                                                <span class="font-bold text-slate-900">{{ $rsvp->user->name }}</span>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 text-xs font-semibold text-slate-550">{{ $rsvp->user->email }}</td>
                                        <td class="px-6 py-4">
                                            @if($rsvp->status === 'yes')
                                                <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded text-[9px] font-black bg-emerald-50 text-emerald-700 border border-emerald-250 uppercase tracking-wider">
                                                    Going
                                                </span>
                                            @elseif($rsvp->status === 'maybe')
                                                <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded text-[9px] font-black bg-amber-50 text-amber-700 border border-amber-250 uppercase tracking-wider">
                                                    Maybe
                                                </span>
                                            @else
                                                <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded text-[9px] font-black bg-rose-50 text-rose-700 border border-rose-250 uppercase tracking-wider">
                                                    Can't go
                                                </span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 text-slate-450 text-[10px] font-bold tracking-wider">
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
