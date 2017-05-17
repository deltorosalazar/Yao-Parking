<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSimulationDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('simulation_details', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('simulation_id');
            $table->integer('parking_id');
            $table->integer('movement_id');
            $table->integer('vehicle_type_id');
            $table->integer('vehicle_id')->nullable();
            $table->integer('price')->nullable();
            $table->string('comment')->nullable();
            $table->datetime('in_date')->nullable();
            $table->datetime('out_date')->nullable();
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
        Schema::dropIfExists('simulation_details');
    }
}
