<?php

use Illuminate\Database\Seeder;


class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        $this->call(MovementsTableSeeder::class);
        $this->call(ParkingsTableSeeder::class);
        $this->call(VehicleTypesTableSeeder::class);
        $this->call(PricesTableSeeder::class);
        $this->call(PriceVehicleTypeTableSeeder::class);
        $this->call(TaxesTableSeeder::class);
        $this->call(RolesTableSeeder::class);
        $this->call(UsersTableSeeder::class);
    }
}
