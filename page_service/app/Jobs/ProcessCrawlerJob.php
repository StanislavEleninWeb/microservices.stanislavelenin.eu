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
    	$sources->each(function($source){
            dispatch(new ProcessSourceCrawlerJob($source));
        });
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
