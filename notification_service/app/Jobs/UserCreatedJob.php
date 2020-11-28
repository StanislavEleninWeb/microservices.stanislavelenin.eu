<?php

namespace App\Jobs;

use App\Notifications\UserCreatedNotification;
use App\Models\User;

class ExampleJob extends Job
{

    /**
    * Request data container
    */
    private $data;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($data)
    {
        $this->data = $data;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $user = new User;

        $user->id = $data['id'];
        $user->name = $data['name'];
        $user->email = $data['email'];

        $user->save();

        $user->notify(new UserCreatedNotification());        
    }
}
