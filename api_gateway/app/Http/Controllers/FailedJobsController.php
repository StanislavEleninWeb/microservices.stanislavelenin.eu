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

        $failedJobs['user.service'] = Http::get(env('USER_SERVICE_URL') . '/failed/jobs')->json();
        $failedJobs['page.service'] = Http::get(env('PAGE_SERVICE_URL') . '/failed/jobs')->json();
        $failedJobs['image.service'] = Http::get(env('IMAGE_SERVICE_URL') . '/failed/jobs')->json();
        $failedJobs['rating.service'] = Http::get(env('RATING_SERVICE_URL') . '/failed/jobs')->json();
        $failedJobs['notification.service'] = Http::get(env('NOTIFICATION_SERVICE_URL') . '/failed/jobs')->json();

        dd($failedJobs);

        return response()->json($failedJobs);
    }

}
