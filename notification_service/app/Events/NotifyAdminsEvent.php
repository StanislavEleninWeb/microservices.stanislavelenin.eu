<?php

namespace App\Events;

class NotifyAdminsEvent extends Event
{

	private $data;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($data)
    {
        $this->data = $data;
    }
}
