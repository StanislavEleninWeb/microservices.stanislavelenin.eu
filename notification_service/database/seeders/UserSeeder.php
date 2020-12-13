<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{

	/**
	* Currency array
	*/
	private $users = [
		[
            'id' => 1,
			'name' => 'Stanislav Elenin',
			'email' => 'stanislaveleninweb@gmail.com',
		],
	];

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach($this->users as $itr){
        	DB::table('users')->insert([
        		'id' => $itr['id'],
                'name' => $itr['name'],
        		'email' => $itr['email'],
        	]);
        }
    }
}
