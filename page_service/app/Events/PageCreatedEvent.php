<?php

namespace App\Events;

class PageCreatedEvent extends Event
{

	public $page;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($page)
    {
        $this->page = $page;
    }
}
