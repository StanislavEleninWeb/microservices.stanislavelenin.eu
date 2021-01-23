<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ExampleController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function getFailedJobs()
    {
        $failedJobs = DB::table('failed_jobs')->select('*');
    }

}