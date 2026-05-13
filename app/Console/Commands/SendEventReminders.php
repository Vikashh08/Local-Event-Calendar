<?php

namespace App\Console\Commands;

use App\Models\Event;
use App\Notifications\EventReminder;
use Carbon\Carbon;
use Illuminate\Console\Command;

class SendEventReminders extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'events:send-reminders';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send daily reminders to attendees for events happening tomorrow';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $tomorrow = Carbon::tomorrow()->toDateString();

        $events = Event::whereDate('date', $tomorrow)
            ->where('status', 'approved')
            ->with(['rsvps' => function($query) {
                $query->where('status', 'yes')->with('user');
            }])->get();

        $count = 0;

        foreach ($events as $event) {
            foreach ($event->rsvps as $rsvp) {
                $rsvp->user->notify(new EventReminder($event));
                $count++;
            }
        }

        $this->info("Sent {$count} reminders for " . $events->count() . " events.");
    }
}
