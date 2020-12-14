<?php

namespace App\Jobs;

use Illuminate\Support\Facades\Http;
use App\Events\NotifyAdminsEvent;
use App\Models\Source;
use App\Models\Page;

class ProcessSourceCrawlerJob extends Job
{

    /**
    * The source 
    *
    * @var App\Models\Source;
    */
    protected $source;

    /**
     * The number of times the job may be attempted.
     *
     * @var int
     */
    public $tries = 2;

    /**
     * The number of seconds the job can run before timing out.
     *
     * @var int
     */
    public $timeout = 60;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Source $source)
    {
        $this->source = $source;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        //Generate source url get/post http request
        $generator = new $this->source->generate_url_request_class($this->source);
        $generator->analyze();

        // Filter unique results
        $crawled = Page::whereIn('url', $generator->getResult())->pluck('url');        
        $unique_results = $generator->getResult()->diff($crawled);
        
        // Dispatch 
        $unique_results->each(function($url){
            dispatch(new ProcessPageCrawlerJob($url, $this->source));
        });
    }

    /**
     * Handle a job failure.
     *
     * @param  \Throwable  $exception
     * @return void
     */
    public function failed(\Throwable $exception)
    {
        event(new NotifyAdminsEvent($exception, [
            'data' => 'Process Crawler Job',
        ]));
    }
}
