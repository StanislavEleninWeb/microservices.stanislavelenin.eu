<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;

use App\Mail\NotifyAdminsMail;

class PageCreatedNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public $data;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($data)
    {
        $this->data = $data;
    }

    /**
	 * Get the notification's delivery channels.
	 * Notifications may be sent on the mail, database, broadcast, nexmo, and slack channels.
	 *
	 * @param  mixed  $notifiable
	 * @return array
	 */
	public function via($notifiable)
	{
	    return ['mail', 'database'];
	}

    /**
	 * Get the mail representation of the notification.
	 *
	 * @param  mixed  $notifiable
	 * @return \Illuminate\Notifications\Messages\MailMessage
	 */
	public function toMail($notifiable)
	{
	    return (new NotifyAdminsMail($this->data))->to($notifiable->email);
	}

	/**
	 * Get the array representation of the notification.
	 * toDatabase Vs. toArray
	 *
	 * @param  mixed  $notifiable
	 * @return array
	 */
	public function toArray($notifiable)
	{
	    return [
	        'data' => $this->data,
	    ];
	}

}