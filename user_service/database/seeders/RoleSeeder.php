<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class RoleSeeder extends Seeder
{

	/**
	* Building type array
	*/
	private $roles = [
		[
			'name' => 'guest',
			'guard_name' => 'web',
		],
		[
			'name' => 'subscriber',
			'guard_name' => 'web',
		],
		[
			'name' => 'admin',
			'guard_name' => 'web',
		],
		[
			'name' => 'owner',
			'guard_name' => 'web',
		],
		[
			'name' => 'developer',
			'guard_name' => 'web',
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

    	foreach($this->roles as $itr){
	        DB::table('roles')->insert([
	        	'name' => $itr['name'],
	        	'guard_name' => $itr['guard_name'],
	        	'created_at' => $now,
	        	'updated_at' => $now,
	        ]);	
    	}
    }
}
