<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class UserSeeder extends Seeder
{

	/**
	* Building type array
	*/
	private $users = [
		[
			'name' => 'Stanislav Elenin',
			'email' => 'stanislaveleninweb@gmail.com',
			'password' => '15263400',

			'preferences' => [
				'cities' => [
					1,
				],
				'building_types' => [
					3, 4, 5
				],
				'build_types' => [
					1
				],

				'price_from' => 30000,
				'price_to' => 120000,

				'price_per_square_from' => null,
				'price_per_square_to' => 1100,

				'space_from' => 80,
				'space_to' => null,

				'regions' => null,

				'keywords' => [
					'собственик',
					'гараж',
					'паркомясто'
				],
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

    	foreach($this->users as $itr){
    		// create user
	        $user_id = DB::table('users')->insertGetId([
	        	'name' => $itr['name'],
	        	'email' => $itr['email'],
	        	'email_verified_at' => $now,
	            'password' => Hash::make($itr['password']),
	            'api_token' => Hash::make(microtime()),
	        	'created_at' => $now,
	        	'updated_at' => $now,
	        ]);	

	        // create user preferences
	        DB::table('user_preferences')->insert([
	        	'user_id' => $user_id,
	        	'cities' => json_encode($itr['preferences']['cities']),
	        	'building_types' => json_encode($itr['preferences']['building_types']),
	        	'build_types' => json_encode($itr['preferences']['build_types']),
	        	'price_from' => $itr['preferences']['price_from'],
	        	'price_to' => $itr['preferences']['price_to'],
	        	'price_per_square_from' => $itr['preferences']['price_per_square_from'],
	        	'price_per_square_to' => $itr['preferences']['price_per_square_to'],
	        	'space_from' => $itr['preferences']['space_from'],
	        	'space_to' => $itr['preferences']['space_to'],
	        	'regions' => $itr['preferences']['regions'],
	        	'keywords' => json_encode($itr['preferences']['keywords']),
	        	'created_at' => $now,
	        	'updated_at' => $now,
	        ]);
    	}
    }

}
