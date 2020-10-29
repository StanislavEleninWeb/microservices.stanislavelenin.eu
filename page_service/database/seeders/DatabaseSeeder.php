<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            SourceSeeder::class,
            CitiesSeeder::class,
        	CurrencySeeder::class,
            BuildTypeSeeder::class,
            BuildingTypeSeeder::class,
    	]);
    }
}
