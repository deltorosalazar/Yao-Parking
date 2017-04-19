<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class VehicleType extends Model {
    protected $fillable = [
        'name'
    ];

    public function prices() {
        return $this->belongsToMany('App\Price', 'price_vehicle_type', 'vehicle_type_id', 'price_id')
                    ->withPivot('id', 'value')
                    ->withTimestamps();
    }
}
