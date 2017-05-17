<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateQuotasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // CUPOS
        Schema::create('quotas', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('simulation_id');
            $table->integer('parking_id');
            $table->integer('vehicle_type_id');
            $table->integer('max_quantity');
            $table->integer('vehicles_exceeded')->default(0);
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
        Schema::dropIfExists('quotas');
    }
}
