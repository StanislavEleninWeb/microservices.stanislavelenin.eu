<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class BuildTypeSeeder extends Seeder
{

	
	/**
	* Building type array
	*/
	private $build_type = [
		[
			'title' => 'Тухла',
			'keywords' => ''
		],
		[
			'title' => 'Панел',
			'keywords' => ''
		],
		[
			'title' => 'Гредоред',
			'keywords' => ''
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

    	foreach($this->build_type as $itr){
	        DB::table('build_types')->insert([
	        	'title' => $itr['title'],
	        	'keywords' => $itr['keywords'],
	        	'created_at' => $now,
	        	'updated_at' => $now,
	        ]);	
    	}
    }
}
