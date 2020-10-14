<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Page;

class PageController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Page::all();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validated = $validate($request, [

        ]);

        $page = new Page;

        $page->title = $validated['title'];

        $page->save();

        return response('Successfully created.', 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Example  $example
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $page = Page::findOrFail($id);

        return $page;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Example  $example
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $page = Page::findOrFail($id);

        $page->title = $validated['title'];

        if($page->isDirty())
            $page->save();

        return response('Successfully updated.', 204);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Example  $example
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
