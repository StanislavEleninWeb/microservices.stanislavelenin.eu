<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Models\City;
use App\Models\Region;

class CitiesSeeder extends Seeder
{

	/**
	* Building type array
	*/
	private $cities = [
		[
			'prefix' => 'гр',
			'title' => 'Пловдив',
			'regions' => [
				'Център',
				'Широк център',
				'Въстанически',
				'Кючук Париж',
				'Тракия',
				'Бунарджика',
				'Каменница',
				'Смирненски',
				'Изгрев',
				'Индустриална зона - Юг',
				'Индустриална зона - Изток',
				'Индустриална зона - Север',
				'Прослав',
				'Коматево',
				'Гагарин',
				'Кършияка',
			],
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

    	foreach($this->cities as $itr){
	        $city_id = DB::table('cities')->insertGetId([
	        	'prefix' => $itr['prefix'],
	        	'title' => $itr['title'],
	        	'created_at' => $now,
	        	'updated_at' => $now,
	        ]);

	        foreach($itr['regions'] as $jtr){
		        DB::table('regions')->insert([
		        	'city_id' => $city_id,
		        	'title' => $jtr,
		        	'created_at' => $now,
		        	'updated_at' => $now,
		        ]);
	        }
    	}
    }
}
