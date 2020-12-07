<?php

namespace App\Events;

class TestEvent extends Event
{

	public $test;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($test)
    {
        $this->test = $test;
    }
}
