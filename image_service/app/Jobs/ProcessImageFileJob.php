<?php

namespace App\Jobs;

use Intervention\Image\ImageManagerStatic as Image;
use App\Events\NotifyAdminsEvent;

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
        // From local
        // $contentType = mime_content_type($this->url);

        // From remote, arg 1 set keys
        $contentType = get_headers($this->url, 1)['Content-Type'];
        
        if(!in_array($contentType, $this->allowedMimeTypes))
            return;

        app('db')->transaction(function() use ($contentType){
            
            $filename = md5(microtime());
            $ext = explode('/', $contentType)[1];

            app('db')->insert("INSERT INTO images(page_id, filename, ext) VALUES(:page, :filename, :ext)", [
                ':page' => $this->page,
                ':filename' => $filename,
                ':ext' => $ext,
            ]);
            $id = app('db')->getPdo()->lastInsertId();

            $storage_path = app('path.storage') . DIRECTORY_SEPARATOR . 'images' . DIRECTORY_SEPARATOR . intval($id/1000) . DIRECTORY_SEPARATOR;

            if(!file_exists($storage_path) || !is_dir($storage_path))
                if(!mkdir($storage_path, 0775, true))
                    throw new \Exception("Could not create directory in storage path: " . $storage_path . PHP_EOL, 1);
                    
            if(!is_writable($storage_path))
                throw new \Exception("Storage Path is not writable: " . $storage_path . PHP_EOL, 1);

            // open an image file
            $img = Image::make($this->url);

            // save the image as a new file
            $img->save($storage_path . 'orig_' . $filename . '.' . $ext);

            // resize the image so that the largest side fits within the limit; the smaller
            // side will be scaled to maintain the original aspect ratio
            foreach(json_decode(env('IMAGE_SIZE')) as $width){
                $img->resize($width, null, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                });

                // save the resized image as a new file
                $img->save($storage_path . $width . '_' . $filename . '.' . $ext);
            }

        });
    }

    /**
     * Handle a job failure.
     *
     * @param  \Throwable  $exception
     * @return void
     */
    public function failed(\Throwable $exception)
    {
        event(new NotifyAdminsEvent($exception));
    }
}
