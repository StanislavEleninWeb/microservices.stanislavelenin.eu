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

        $failedJobs['user.service'] = Http::get(env('USER_SERVICE_URL') . 'failed/jobs');
        $failedJobs['page.service'] = Http::get(env('PAGE_SERVICE_URL') . 'failed/jobs');
        $failedJobs['image.service'] = Http::get(env('IMAGE_SERVICE_URL') . 'failed/jobs');
        $failedJobs['rating.service'] = Http::get(env('RATING_SERVICE_URL') . 'failed/jobs');
        $failedJobs['notification.service'] = Http::get(env('NOTIFICATION_SERVICE_URL') . 'failed/jobs');

        return response()->json($failedJobs);
    }

}
