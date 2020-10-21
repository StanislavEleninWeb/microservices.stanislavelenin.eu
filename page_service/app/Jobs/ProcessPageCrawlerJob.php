<?php

namespace App\Jobs;

use Spatie\Browsershot\Browsershot;

use Goutte\Client;

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
        // Craw main page
        $html = Browsershot::url($generated_url)
        ->device('iPhone X')
        ->bodyHtml();

        // Fetch info
        $client = new Client($html);

        // Analyze content

        // Record info
        $page = new Page;

        $page->title = $validated['title'];

        $page->save();

    }
}
