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

            $table->unsignedBigInteger('id')->primary();
            
            $table->string('building_type_id')->nullable();
            $table->string('build_type_id')->nullable();
            
            $table->unsignedBigInteger('currency_id')->nullable();

            $table->decimal('price_from', 8, 2)->nullable();
            $table->decimal('price_to', 8, 2)->nullable();

            $table->decimal('price_per_square_from', 6, 2)->nullable();
            $table->decimal('price_per_square_to', 6, 2)->nullable();

            $table->decimal('space_from', 6, 2)->nullable();
            $table->decimal('space_to', 6, 2)->nullable();
            
            $table->string('region_id')->nullable();

            $table->string('keywords')->nullable();

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
