<?php

namespace App\Events;

class PageCreatedEvent extends Event
{
    public $users;
	public $data;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($users, $data)
    {
        $this->users = $users;
        $this->data = $data;
    }
}
