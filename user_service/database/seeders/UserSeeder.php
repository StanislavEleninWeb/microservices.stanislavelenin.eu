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
	        DB::table('users')->insert([
	        	'name' => $itr['name'],
	        	'email' => $itr['email'],
	        	'email_verified_at' => $now,
	            'password' => Hash::make($itr['password']),
	            'api_token' => Hash::make(microtime()),
	        	'created_at' => $now,
	        	'updated_at' => $now,
	        ]);	
    	}
    }
}
