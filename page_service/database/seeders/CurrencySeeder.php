<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class CurrencySeeder extends Seeder
{

	/**
	* Currency array
	*/
	private $currency = [
		'BGN' => [
			'title' => 'Лев',
			'keywords' => 'Лев, BGN, бг, bg'
		],
		'EUR' => [
			'title' => 'Евро',
			'keywords' => 'Евро, Euro, EUR'
		],
		'USD' => [
			'title' => 'Долар',
			'keywords' => 'Долар, $, usd'
		]
	];

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	
    	$now = Carbon::now();

        foreach($this->currency as $slug => $itr){
        	DB::table('currencies')->insert([
        		'title' => $itr['title'],
        		'slug' => $slug,
        		'keywords' => $itr['keywords'],
        		'created_at' => $now,
	        	'updated_at' => $now,
        	]);
        }
    }
}
