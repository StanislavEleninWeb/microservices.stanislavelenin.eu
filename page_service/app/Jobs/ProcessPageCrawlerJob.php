<?php

namespace App\Jobs;

use Illuminate\Support\Facades\Validator;

use App\Models\Page;

class ProcessPageCrawlerJob extends Job
{
    /**
    * The source 
    *
    * @var url;
    */
    protected $url;

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
    public function __construct($url)
    {
        $this->url = $url;;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        /**
        * Analyze content
        *
        * @return array
        */
        $analyzed = AnalyzeContent($html);

        $validator = Validator::make($analyzed, [
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
