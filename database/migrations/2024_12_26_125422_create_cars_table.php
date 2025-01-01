<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCarsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cars', function (Blueprint $table) {
            $table->id();
			$table->string('car_name');
			$table->integer('rate');
			$table->integer('taxi_doors');
			$table->integer('passengers');
			$table->integer('luggage_carry');
			$table->boolean('air_condition');
			$table->boolean('gps_navigation');
			$table->string('car_image');
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
        Schema::dropIfExists('cars');
    }
}
