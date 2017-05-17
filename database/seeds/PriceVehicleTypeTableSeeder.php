<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class PriceVehicleTypeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        DB::table('price_vehicle_type')->insert([
            'price_id' => '1',
            'vehicle_type_id' => '1',
            'value' => '50',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('price_vehicle_type')->insert([
            'price_id' => '1',
            'vehicle_type_id' => '2',
            'value' => '40',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('price_vehicle_type')->insert([
            'price_id' => '1',
            'vehicle_type_id' => '3',
            'value' => '10',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('price_vehicle_type')->insert([
            'price_id' => '2',
            'vehicle_type_id' => '1',
            'value' => '15000',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('price_vehicle_type')->insert([
            'price_id' => '2',
            'vehicle_type_id' => '2',
            'value' => '10000',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('price_vehicle_type')->insert([
            'price_id' => '2',
            'vehicle_type_id' => '3',
            'value' => '5000',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('price_vehicle_type')->insert([
            'price_id' => '3',
            'vehicle_type_id' => '1',
            'value' => '20000',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('price_vehicle_type')->insert([
            'price_id' => '3',
            'vehicle_type_id' => '2',
            'value' => '20000',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('price_vehicle_type')->insert([
            'price_id' => '3',
            'vehicle_type_id' => '3',
            'value' => '20000',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);


    }
}
