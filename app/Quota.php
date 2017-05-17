<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Quota extends Model {
    public function vehicle_type() {
        return $this->belongsTo('App\VehicleType');
    }

    public function parking() {
        return $this->belongsTo('App\Parking');
    }
}
