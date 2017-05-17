<?php

use Illuminate\Database\Seeder;

class ParkingsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {

        $parkings = factory(App\Parking::class, 100)->make();
        $counter = 0;

        foreach ($parkings as $parking) {
            try {
                if ($counter == 100) {
                    break;
                } else {
                    $counter = $counter + 1;
                    $parking->save();
                }
            } catch (\Exception $e) {
                $error_code = $e->errorInfo[1];
                if ($error_code == 1062) {
                    // continue;
                        // $parking = factory(App\Parking::class)->make();
                }
            }
        }

    }


}
