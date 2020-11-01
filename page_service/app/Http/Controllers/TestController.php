<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Jobs\ProcessCrawlerJob;
use App\Jobs\ProcessSourceCrawlerJob;
use App\Jobs\ProcessPageCrawlerJob;
use App\Analyze\AnalyzeContentAloBg;
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
            $page = new ProcessPageCrawlerJob('http://127.0.1.2/test.html', Source::find(1));
            $page->handle();
    	} catch(\Exception $e) {
            dd($e);
    		return new Response( $e->getMessage(), 403);
    	} catch(\Throwable $e){
            dd($e);
        }

        return new Response('Success!!!', Response::HTTP_OK);
    }

}
