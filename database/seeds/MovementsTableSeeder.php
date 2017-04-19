<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class MovementsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        DB::table('movements')->insert([
            'name' => 'Entrada',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('movements')->insert([
            'name' => 'Salida',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('movements')->insert([
            'name' => 'Entrada/Salida',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
    }
}
