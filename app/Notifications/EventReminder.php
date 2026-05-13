<?php

namespace App\Notifications;

use App\Models\Event;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Carbon\Carbon;

class EventReminder extends Notification implements ShouldQueue
{
    use Queueable;

    public $event;

    /**
     * Create a new notification instance.
     */
    public function __construct(Event $event)
    {
        $this->event = $event;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        $date = Carbon::parse($this->event->date)->format('F j, Y');
        $time = Carbon::parse($this->event->time)->format('g:i A');

        return (new MailMessage)
            ->subject('Reminder: Upcoming Event - ' . $this->event->title)
            ->greeting('Hello ' . $notifiable->name . '!')
            ->line('This is a friendly reminder that an event you RSVP\'d to is happening tomorrow!')
            ->line('**Event:** ' . $this->event->title)
            ->line('**Date:** ' . $date)
            ->line('**Time:** ' . $time)
            ->line('**Location:** ' . ($this->event->location ?? 'To Be Announced'))
            ->action('View Event Details', url(route('events.show', $this->event->id)))
            ->line('We look forward to seeing you there!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'event_id' => $this->event->id,
            'message' => 'Reminder for event: ' . $this->event->title,
        ];
    }
}
