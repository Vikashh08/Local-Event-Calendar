<x-mail::message>
# RSVP Confirmation

Hi {{ Auth::user()->name }},

Your RSVP for **{{ $event->title }}** has been recorded successfully.

**Status:** {{ ucfirst($status) }}
**Date:** {{ \Carbon\Carbon::parse($event->date)->format('F j, Y') }}
**Time:** {{ \Carbon\Carbon::parse($event->time)->format('g:i A') }}
**Location:** {{ $event->location }}

<x-mail::button :url="route('events.show', $event)">
View Event Details
</x-mail::button>

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
