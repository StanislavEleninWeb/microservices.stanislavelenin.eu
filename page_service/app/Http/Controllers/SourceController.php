<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
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
        return Source::all();
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

        $source->save();

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
        return $id;
    }

}
