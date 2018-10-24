<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Parking extends Model {
    public function simulations() {
        return $this->belongsToMany('App\Simulation', 'simulation_details', 'parking_id', 'simulation_id');
    }
}
