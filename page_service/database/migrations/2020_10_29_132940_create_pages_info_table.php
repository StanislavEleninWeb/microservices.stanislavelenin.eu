<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePagesInfoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pages_info', function (Blueprint $table) {
            $table->foreignId('page_id')->primary();
            $table->string('title');
            $table->foreignId('city_id');
            $table->foreignId('building_type_id');
            $table->foreignId('build_type_id')->nullable();
            $table->foreignId('currency_id')->nullable();
            $table->decimal('price', 8, 2);
            $table->decimal('price_per_square', 6, 2);
            $table->decimal('space', 6, 2);
            $table->foreignId('region_id')->nullable();
            $table->smallInteger('floor')->nullable();
            $table->date('year')->nullable();
            $table->string('keywords')->nullable();
            $table->text('content');
            $table->timestamps();

            $table->foreign('page_id')->references('id')->on('pages');
            $table->foreign('city_id')->references('id')->on('cities');
            $table->foreign('building_type_id')->references('id')->on('building_types');
            $table->foreign('build_type_id')->references('id')->on('build_types');
            $table->foreign('currency_id')->references('id')->on('currencies');
            $table->foreign('region_id')->references('id')->on('regions');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pages_info');
    }
}
