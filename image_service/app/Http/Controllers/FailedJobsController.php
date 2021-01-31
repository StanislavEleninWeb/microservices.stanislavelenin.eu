<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FailedJobsController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function getFailedJobs()
    {
        return DB::table('failed_jobs')->select('*')->orderBy('id', 'DESC')->get();
    }

}