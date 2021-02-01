<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class ClearRabbitMqQueueCommand extends Command
{

    private $queues = [
        // 'user.service',
        'page.service',
        'image.service',
        'rating.service',
        'notification.service',
    ];

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'rabbitmq:purge {queues?*}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Queue-purge recorded services';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @param  \App\Support\DripEmailer  $drip
     * @return mixed
     */
    public function handle()
    {
        $queues = $this->argument('queues');

        if(isset($queues) && count($queues))
            $this->queues = array_intersect($this->queues, $queues);

        foreach($this->queues as $queue){
            $this->callSilently('rabbitmq:queue-purge', [
                'queue' => $queue,
                '--confirm' => true,
            ]);
        }

        $this->info('RabbitMQ queues purged!');
    }

}