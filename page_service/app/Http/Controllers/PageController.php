<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Page;
use App\Models\PageInfo;

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

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Example  $example
     * @return \Illuminate\Http\Response
     */
    public function lastQuarterRating(Request $request)
    {
        $array = [];
        $quarter = Carbon::now()->subMonths(4);

        $info = PageInfo::where('created_at', '>=', $quarter);
        if(isset($request->city_id) && is_numeric($request->city_id))
            $info->where('city_id', $request->city_id);      

        // Average
        $array['price']['avg'] = round($info->avg('price'), 2);
        $array['price_per_square']['avg'] = round($info->avg('price_per_square'), 2);
        $array['space']['avg'] = round($info->avg('space'), 2);

        // Set query limit
        $info->limit(10);

        // Min
        $array['price']['min'] = round(clone($info)->orderBy('price', 'ASC')->pluck('price')->avg(), 2);
        $array['price_per_square']['min'] = round(clone($info)-orderBy('price_per_square', 'ASC')->pluck('price_per_square')->avg(), 2);
        $array['space']['min'] = round(clone($info)->orderBy('space', 'ASC')->pluck('space')->avg(), 2);

        // Max
        $array['price']['max'] = round(clone($info)->orderBy('price', 'DESC')->pluck('price')->avg(), 2);        
        $array['price_per_square']['max'] = round(clone($info)->orderBy('price_per_square', 'DESC')->pluck('price_per_square')->avg(), 2);
        $array['space']['max'] = round(clone($info)->orderBy('space', 'DESC')->pluck('space')->avg(), 2);

        return response()->json($array);
    }

}
