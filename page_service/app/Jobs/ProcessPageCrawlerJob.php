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

        $analyzer->analyze();

        $results = $analyzer->getResult();

        $page_validator = Validator::make($results, [
            'url' => 'required|url',
        ])->validate();

        $page_info_validator = Validator::make($results, [
            'title' => 'required|string',
            'price'
        ])->validate();

        // Page Model
        $page = new Page;
        $page->url = $page_validator['url'];
        $page->source_id = $this->source->id;
        $page->save();

        // Page Info Model
        $page_info = new PageInfo;

        $page_info->title = $page_info_validator['title'];
        $page_info->price = $page_info_validator['price'];
        $page_info->price_per_square = $page_info_validator['price_per_square'];
        $page_info->content = $page_info_validator['content'];

        // // notify users

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
