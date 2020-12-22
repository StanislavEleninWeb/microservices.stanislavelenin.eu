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
			'keywords' => 'Лев, BGN, бг, bg',
			'rate' => 1
		],
		'EUR' => [
			'title' => 'Евро',
			'keywords' => 'Евро, Euro, EUR',
			'rate' => 1.96
		],
		'USD' => [
			'title' => 'Долар',
			'keywords' => 'Долар, $, usd',
			'rate' => 1.60
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
        		'rate' => $itr['rate'],
        		'created_at' => $now,
	        	'updated_at' => $now,
        	]);
        }
    }
}
