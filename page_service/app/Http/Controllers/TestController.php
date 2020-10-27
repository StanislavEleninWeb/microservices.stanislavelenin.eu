<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Jobs\ProcessSourceCrawlerJob;
use App\Jobs\ProcessPageCrawlerJob;
use App\Models\Source;

class TestController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

    	try {
    		$source = Source::find(1);

    		// $job = new ProcessSourceCrawlerJob($source);
            // $job = new ProcessPageCrawlerJob('https://www.alo.bg/6979088');

        	// $job->handle();

            $analyzer = new $source->analyze_content_class('https://www.alo.bg/6090511');
            $analyzer->crawl();
            $analyzer->analyze();

            dd($analyzer->getAnalyzed());


    	} catch(\Exception $e) {
    		return new Response( $e->getMessage(), 403);
    	}

        return new Response('Success!!!', Response::HTTP_OK);
    }

}
