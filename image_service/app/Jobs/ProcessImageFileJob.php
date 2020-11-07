<?php

namespace App\Jobs;

use Illuminate\Support\Facades\Http;
use Intervention\Image\Image;

class ProcessImageFileJob extends Job
{
    private $page;
    private $url;

    private $allowedMimeTypes = [
        'image/jpeg',
        'image/gif',
        'image/png',
        'image/bmp',
    ];

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($page, $url)
    {
        $this->page = $page;
        $this->url = $url;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $contentType = mime_content_type($this->url);

        if(!in_array($contentType, $this->allowedMimeTypes))
            return;

        app('db')->transaction(function() use ($contentType){

            app('db')->insert("INSERT INTO images(page_id, filename, ext) VALUES(:page, :filename, :ext)", [
                ':page' => $this->page,
                ':filename' => $filename,
                ':ext' => $ext,
            ]);
            $id = app('db')->getPdo()->lastInsertId();

            $storage_path = app('path.storage') . DIRECTORY_SEPARATOR . 'images' . DIRECTORY_SEPARATOR . intval($id/1000) . DIRECTORY_SEPARATOR;
            $filename = md5(microtime());
            $ext = explode('/', $contentType)[1];

            // open an image file
            $img = Image::make($this->url);

            // save the image as a new file
            $img->save($storage_path . 'orig_' . $filename . '.' . $ext);

            // resize the image so that the largest side fits within the limit; the smaller
            // side will be scaled to maintain the original aspect ratio
            $img->resize(400, null, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            });

            // save the resized image as a new file
            $img->save($storage_path . '400' . $filename . '.' . $ext);

        });
    }

    /**
     * Handle a job failure.
     *
     * @param  \Throwable  $exception
     * @return void
     */
    public function failed(Throwable $exception)
    {
        Http::post(env('NOTIFICATION_SERVICE_URL') . '/notify/admin', [
            'url' = $this->url, 
            'page' => $this->page,
            'exception' => $exception,
        ]);
    }
}
