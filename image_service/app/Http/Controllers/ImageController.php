<?php

namespace App\Http\Controllers;

class ExampleController extends Controller
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
        $sources = Cache::remember('sources', 120, function(){
            return Source::all();
        });

        return $sources;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Source  $source
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $sources = Cache::get('sources');

        if($sources)
            $source = $sources->filter(function($item){return $item->id == 1;})->first();
        else
            $source = Source::findOrFail($id);

        return $source;
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {


        try {
            $source->save();
        } catch (\PDOException $e) {
            return new Response('Duplicate entry.', 403);
        }

        return new Response('Successfully created.', 201);
    }

}
