<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use App\Events\NotifyAdminsEvent;
use App\Models\Source;

class ProcessCrawlerJob extends Job implements ShouldBeUnique
{
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
    public function failed(\Throwable $exception)
    {
        event(new NotifyAdminsEvent($exception, [
            'data' => 'Process Crawler Job'
        ]));
    }
}
