<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Price extends Model {
    protected $fillable = [
        'name'
    ];

    public function vehicle_types() {
        return $this->belongsToMany('App\VehicleType', 'price_vehicle_type', 'price_id', 'vehicle_type_id')
                        ->withPivot('id', 'value')
                        ->withTimestamps();
    }
}
