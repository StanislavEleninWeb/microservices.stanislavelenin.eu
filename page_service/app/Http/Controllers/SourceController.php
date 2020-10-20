<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use App\Jobs\ProcessCrawlerJob;

use App\Models\Source;

class SourceController extends Controller
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
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validated = $this->validate($request, [
            'title' => 'required|string',
            'slug' => 'required|string',
            'base_url' => 'required',
        ]);

        $source = new Source;

        $source->title = $validated['title'];
        $source->slug = $validated['slug'];
        $source->base_url = $validated['base_url'];

        try {
            $source->save();
        } catch (\PDOException $e) {
            return response('Duplicate entry.', 403);
        }

        return response('Successfully created.', 201);
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
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Source  $source
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $source = Source::findOrFail($id);

        $validated = $this->validate($request, [
            'title' => 'required|string',
            'slug' => 'required|string',
            'base_url' => 'required',
        ]);

        $source->title = $validated['title'];
        $source->slug = $validated['slug'];
        $source->base_url = $validated['base_url'];

        if($source->isDirty())
            $source->save();

        return response('Successfully updated.', 204);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Page  $page
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Source::destroy($id);

        return response('Successfully deleted.', 204);
    }

}
