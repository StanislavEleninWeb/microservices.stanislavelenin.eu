<?php

namespace App\Jobs;

use Illuminate\Support\Facades\Cache;
use App\Models\Source;

class ProcessCrawlerJob extends Job
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
    public function handle()
    {
        // Fetch all sources
    	$sources = Cache::get('sources', Source::all());

    	// Iterate over sources
    	foreach($sources as $source){
    		// Dispatch Source jobs on queue 'crawler'
    		ProcessSourceCrawlerJob::dispatch($source);
    	}
    }
}
