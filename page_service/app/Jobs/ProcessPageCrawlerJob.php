<?php

namespace App\Jobs;

use Illuminate\Support\Facades\Validator;

use App\Models\Page;
use App\Models\Source;

class ProcessPageCrawlerJob extends Job
{
    /**
    * The url address 
    *
    * @var url;
    */
    protected $url;

    /**
    * The source 
    *
    * @var source;
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
    public function __construct($url, Source $source)
    {
        $this->url = $url;
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
        $analyzer = new $this->source->analyze_content_class($this->url);
        $analyzer->crawl();
        $analyzer->analyze();

        $validator = Validator::make($analyzer->getAnalyzed(), [
            'title' => 'required|string',
        ]);

        if($validator->fails()){
            return;
        }

        // Record info
        $page = new Page;

        $page->title = $validator['title'];
        $page->content = $validator['content'];


        $page->save();

        // notify users

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
