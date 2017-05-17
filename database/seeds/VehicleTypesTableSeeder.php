<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class VehicleTypesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        DB::table('vehicle_types')->insert([
            'name' => 'Carros',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('vehicle_types')->insert([
            'name' => 'Motos',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('vehicle_types')->insert([
            'name' => 'Bicicletas',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
    }
}
