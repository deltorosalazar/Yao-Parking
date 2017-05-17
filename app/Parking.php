<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Parking extends Model {

    protected $fillable = [
        'name'
    ];

    public function simulations() {
        return $this->belongsToMany('App\Simulation', 'simulation_details', 'parking_id', 'simulation_id');
    }

    // public function vehicle_types() {
    //     return $this->belongsToMany('App\VehicleType', 'price_vehicle_type', 'price_id', 'vehicle_type_id')
    //                     ->withPivot('id', 'value')
    //                     ->withTimestamps();
    // }
}
