<?php

namespace App\Jobs;

use Spatie\Browsershot\Browsershot;

use App\Models\Source;

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
    public $timeout = 30;

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
        // Generate base url
        $generated_url = 'https://www.alo.bg/obiavi/imoti-prodajbi/apartamenti-stai/?region_id=16';

        // Craw main page
        $content = Browsershot::url($generated_url)
        ->device('iPhone X')
        ->bodyHtml();

        
        // Fetch dom

        // Analyze content and fetch urls

        // Check if already crawled

        // Dispatch process page url

    }

    /**
     * Handle a job failure.
     *
     * @param  \Throwable  $exception
     * @return void
     */
    public function failed(Throwable $exception)
    {
        dd($exception);
    }
}
