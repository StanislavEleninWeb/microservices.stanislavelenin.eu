<?php

namespace App\Events;

class NotifyAdminsEvent extends Event
{

	/**
	* Pass exception variable
	*
    * @var string|\Throwable
	*/
	public $exception;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($exception)
    {
        $this->exception = $exception;
    }
}
