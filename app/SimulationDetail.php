<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SimulationDetail extends Model {

    public function vehicle_types() {
        return $this->hasMany('App\VehicleType', 'id', 'vehicle_type_id');
    }

    public function simulations() {
        return $this->hasMany('App\Simulation');
    }

    public function parkings() {
        return $this->hasMany('App\Parking');
    }

    public function movements() {
        return $this->hasMany('App\Movements');
    }
}
