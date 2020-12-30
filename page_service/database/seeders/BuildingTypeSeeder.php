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
			'keywords' => 'Четиристаен,4 стаен апартамент',
		],
		[
			'title' => 'Многостаен апартамент',
			'keywords' => 'Многостаен',
		],
		[
			'title' => 'Мезонет',
			'keywords' => 'Мезонет',
		],
		[
			'title' => 'Къща',
			'keywords' => 'Къша',
		],
		[
			'title' => 'Етаж от къща',
			'keywords' => 'етаж от къща',
		],
		[
			'title' => 'Ателие',
			'keywords' => 'Ателие',
		],
		[
			'title' => 'Студио',
			'keywords' => 'Студио',
		],
		[
			'title' => 'Таван',
			'keywords' => 'Таван',
		],
		[
			'title' => 'Парцел',
			'keywords' => 'Парцел',
		],
		[
			'title' => 'Вила',
			'keywords' => 'Вила',
		],
		[
			'title' => 'Офис',
			'keywords' => 'офис',
		],
		[
			'title' => 'Магазин',
			'keywords' => 'магазин',
		],
		[
			'title' => 'Заведение',
			'keywords' => 'Заведение',
		],
		[
			'title' => 'Склад',
			'keywords' => 'Склад',
		],
		[
			'title' => 'Гараж',
			'keywords' => 'гараж',
		],
		[
			'title' => 'Паркомясто',
			'keywords' => 'паркомясто',
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
