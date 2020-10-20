<?php

namespace App\Jobs;

use App\Models\Page;

class ProcessPageCrawlerJob extends Job
{
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(Url $url)
    {
        
        // Craw page url

        // Fetch info

        // Analyze content

        // Record info
        $page = new Page;

        $page->title = $validated['title'];

        $page->save();

    }
}
