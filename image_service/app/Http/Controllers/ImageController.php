<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;

use App\Jobs\ProcessImageFileJob;

class ImageController extends Controller
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
    public function index($id)
    {
        $images = app('db')
        ->select('SELECT * FROM images WHERE page_id = :page_id', ['page_id' => $id]);

        return $images;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Source  $source
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        

        return new Response('Show', 200);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
    	foreach($request->input('images') as $image){
    			dispatch(new ProcessImageFileJob($request->input('page'), $image));
    	}

        return new Response('Successfully queued for upload.', 200);
    }

}
