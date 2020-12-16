<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class BuildingTypeSeeder extends Seeder
{

	/**
	* Building type array
	*/
	private $building_type = [
		[
			'title' => 'Едностаен апартамент',
			'keywords' => 'Едностаен',
		],
		[
			'title' => 'Двустаен апартамент',
			'keywords' => 'Двустаен',
		],
		[
			'title' => 'Тристаен апартамент',
			'keywords' => 'Тристаен',
		],
		[
			'title' => 'Четиристаен апартамент',
			'keywords' => 'Четиристаен',
		],
		[
			'title' => 'Многостаен апартамент',
			'keywords' => 'Многостаен',
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

    	foreach($this->building_type as $itr){
	        DB::table('building_types')->insert([
	        	'title' => $itr['title'],
	        	'keywords' => $itr['keywords'],
	        	'created_at' => $now,
	        	'updated_at' => $now,
	        ]);	
    	}
    }
}
