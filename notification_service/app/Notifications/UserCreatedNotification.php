<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;

use App\Mail\PageRecordedMail;

class PageRecordedNotification extends Notification implements ShouldQueue
{
    use Queueable;

    /**
	 * Get the notification's delivery channels.
	 * Notifications may be sent on the mail, database, broadcast, nexmo, and slack channels.
	 *
	 * @param  mixed  $notifiable
	 * @return array
	 */
	public function via($notifiable)
	{
	    return ['mail'];
	}

    /**
	 * Get the mail representation of the notification.
	 *
	 * @param  mixed  $notifiable
	 * @return \Illuminate\Notifications\Messages\MailMessage
	 */
	public function toMail($notifiable)
	{
	    return (new UserCreatedMail())->to($notifiable->email);
	}

}