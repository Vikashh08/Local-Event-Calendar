<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class RsvpConfirmed extends Notification implements ShouldQueue
{
    use Queueable;

    public $event;

    /**
     * Create a new notification instance.
     */
    public function __construct(\App\Models\Event $event)
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
        return (new MailMessage)
            ->subject('RSVP Confirmed: ' . $this->event->title)
            ->greeting('Hello ' . $notifiable->name . '!')
            ->line('Your RSVP for **' . $this->event->title . '** has been confirmed.')
            ->line('**Date:** ' . \Carbon\Carbon::parse($this->event->date)->format('l, F j, Y'))
            ->line('**Time:** ' . \Carbon\Carbon::parse($this->event->time)->format('g:i A'))
            ->line('**Location:** ' . ($this->event->location ?? 'To Be Announced'))
            ->action('View Event Details', route('events.show', $this->event))
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
            //
        ];
    }
}
