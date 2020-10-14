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
            $table->text('content');
            $table->foreignId('building_type_id');
            $table->foreignId('currency_id');
            $table->decimal('price', 8, 2);
            $table->decimal('price_per_square', 6, 2);
            $table->decimal('space', 6, 2);
            $table->string('location');
            $table->timestamps();

            $table->foreign('page_id')->references('id')->on('pages');
            $table->foreign('building_type_id')->references('id')->on('building_types');
            $table->foreign('currency_id')->references('id')->on('currencies');
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
