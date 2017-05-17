<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Simulation extends Model {

    protected $fillable = [
        'start_date', 'finish_date',
    ];

    public function parkings() {
        return $this->belongsToMany('App\Parking', 'simulation_details', 'simulation_id', 'parking_id');
    }

    // public function vehicle_types() {
    //     return $this->belongsToMany('App\VehicleType', 'price_vehicle_type', 'price_id', 'vehicle_type_id')
    //                     ->withPivot('id', 'value')
    //                     ->withTimestamps();
    // }
}
