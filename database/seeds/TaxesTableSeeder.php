<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class TaxesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        DB::table('taxes')->insert([
            'name' => 'IVA',
            'percentage' => '13.4',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

    }
}
