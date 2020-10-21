<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Jobs\ProcessSourceCrawlerJob;
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

    		$job = new ProcessSourceCrawlerJob($source);

        	$job->handle();

    	} catch(\Exception $e) {
    		return $e->getMessage();
    	}

        return 'Success!!!';
    }

}