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
}
