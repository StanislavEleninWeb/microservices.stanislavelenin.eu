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
    * Pass exception variable
    *
    * @var array|null
    */
    public $data;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($exception, $data)
    {
        $this->exception = $exception;
        $this->data = $data;
    }
}
