<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserPreferencesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_preferences', function (Blueprint $table) {

            $table->unsignedBigInteger('user_id')->primary();
            
            $table->json('cities')->nullable();

            $table->json('building_types')->nullable();
            $table->json('build_types')->nullable();

            $table->decimal('price_from', 8, 2)->nullable();
            $table->decimal('price_to', 8, 2)->nullable();

            $table->decimal('price_per_square_from', 6, 2)->nullable();
            $table->decimal('price_per_square_to', 6, 2)->nullable();

            $table->decimal('space_from', 6, 2)->nullable();
            $table->decimal('space_to', 6, 2)->nullable();
            
            $table->json('regions')->nullable();

            $table->json('keywords')->nullable();

            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_preferences');
    }
}
