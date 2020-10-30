<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Carbon\Carbon;

class SourceSeeder extends Seeder
{

	/**
	* Currency array
	*/
	private $sources = [
		[
			'title' => 'Alo.bg',
			'base_url' => 'https://alo.bg',
			'generate_url_request_class' => 'App\GenerateUrlRequest\GenerateUrlRequestAloBg',
			'analyze_content_class' => 'App\Analyze\AnalyzeContentAloBg',
		],
	];

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	
    	$now = Carbon::now();

        foreach($this->sources as $itr){
        	DB::table('sources')->insert([
        		'title' => $itr['title'],
        		'slug' => Str::slug($itr['title']),
        		'base_url' => $itr['base_url'],
        		'generate_url_request_class' => $itr['generate_url_request_class'],
        		'analyze_content_class' => $itr['analyze_content_class'],
        		'created_at' => $now,
	        	'updated_at' => $now,
        	]);
        }
    }
}