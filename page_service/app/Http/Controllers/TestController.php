<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

use App\Jobs\ProcessCrawlerJob;
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
            // Test information
            $source = 4;
            $testable = 'https://bazar.bg/obiava-30374372/garsoniera-ot-sobstvenik';

            $page = new ProcessPageCrawlerJob($testable, Source::find($source));            
            
            $page->handle();
    	} catch(\Exception $e) {
            dd($e);
    		return new Response( $e->getMessage(), 403);
    	} catch(\Throwable $e){
            dd($e);
        }

        return new Response('Success!!!', Response::HTTP_OK);
    }

    public function testGenerateUrlRequest()
    {

        try {
            // Test information
            $source = 1;

            // Find Source
            $source = Source::findOrFail($source);

            $page = new $source->generate_url_request_class($source);
            $page->analyze();
            
            dd($page->getResult());
        } catch(\Exception $e) {
            dd($e);
            return new Response( $e->getMessage(), 403);
        } catch(\Throwable $e){
            dd($e);
        }

        return new Response('Success!!!', Response::HTTP_OK);
    }

    public function testAnalyzeContent()
    {

        try {
            // Test information
            $source = 1;
            $testable = 'https://www.alo.bg/7177269';

            // Find Source
            $source = Source::findOrFail($source);

            //Generate source url get/post http request
            $analyzer = new $source->analyze_content_class($testable);

            $analyzer->analyze();

            $results = $analyzer->getResult();

            dd($results);
            
        } catch(\Exception $e) {
            dd($e);
            return new Response( $e->getMessage(), 403);
        } catch(\Throwable $e){
            dd($e);
        }

        return new Response('Success!!!', Response::HTTP_OK);
    }

    public function failedJobs(){
        $failedJobs = app('db')->select('SELECT * FROM failed_jobs');
        dd($failedJobs);
        return $failedJobs;
    }

    public function images(){

        $arr = [
            "images" => [
                0 => "https://alo.bg/user_files/m/martoam/7095963_113174276_big.jpg",
                1 => "https://alo.bg/user_files/m/martoam/7095963_113174277_big.jpg",
                // 2 => "https://alo.bg/user_files/m/martoam/7095963_113174278_big.jpg",
                // 3 => "https://alo.bg/user_files/m/martoam/7095963_113174279_big.jpg",
                // 4 => "https://alo.bg/user_files/m/martoam/7095963_113174280_big.jpg",
                // 5 => "https://alo.bg/user_files/m/martoam/7095963_113174281_big.jpg",
                // 6 => "https://alo.bg/user_files/m/martoam/7095963_113174282_big.jpg",
                // 7 => "https://alo.bg/user_files/m/martoam/7095963_113174284_big.jpg",
                // 8 => "https://alo.bg/user_files/m/martoam/7095963_113174285_big.jpg",
                // 9 => "https://alo.bg/user_files/m/martoam/7095963_113174286_big.jpg",
                // 10 => "https://alo.bg/user_files/m/martoam/7095963_113174287_big.jpg",
                // 11 => "https://alo.bg/user_files/m/martoam/7095963_113174288_big.jpg",
                // 12 => "https://alo.bg/user_files/m/martoam/7095963_113174289_big.jpg",
                // 13 => "https://alo.bg/user_files/m/martoam/7095963_113174290_big.jpg",
                // 14 => "javascript://alo.bg/;",
            ]
        ];


        // Send post http request and process image urls
        $response = Http::post(env('IMAGE_SERVICE_URL') . '/images', [
            'page' => 13,
            'images' => $arr['images'],
        ]);

        dd($response->json());

        return response('Success', 200);
    }

}
