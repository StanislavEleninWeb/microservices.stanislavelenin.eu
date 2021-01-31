<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;

class FailedJobsController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function getFailedJobs()
    {
        $failedJobs = [];

        // $failedJobs['user.service'] = Http::get('USER_SERVICE' . 'failed/jobs');
        $failedJobs['page.service'] = Http::get(env('PAGE_SERVICE') . 'failed/jobs');
        // $failedJobs['image.service'] = Http::get('IMAGE_SERVICE' . 'failed/jobs');
        // $failedJobs['rating.service'] = Http::get('RATING_SERVICE' . 'failed/jobs');
        // $failedJobs['notification.service'] = Http::get('NOTIFICATION_SERVICE' . 'failed/jobs');

        return response()->json($failedJobs);
    }

}
