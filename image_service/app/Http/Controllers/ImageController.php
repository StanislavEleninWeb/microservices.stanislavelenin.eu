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
        ->select('SELECT * FROM images WHERE page_id = :page_id', [
            ':page_id' => intval($id),
        ]);

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
        $image = app('db')
        ->select('SELECT * FROM images WHERE id = :id LIMIT 1', [
            ':id' => intval($id),
        ]);

        return $image;
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

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {
        $image = $app('db')
        ->select('SELECT * FROM images WHERE id = :id', [
            ':id' => intval($id),
        ]);
        
        if($image){

            $path = app('storage_path') . DIRECTORY_SEPARATOR . intval($image->id/1000) . DIRECTORY_SEPARATOR;
            $file = $image->filename . '.' . $image->ext;
            
            unlink($path . 'orig_' . $file);
            unlink($path . '400' . $file);

            $app('db')->delete();

        }

        return new Response('Successfully deleted.', 200);
    }

}
