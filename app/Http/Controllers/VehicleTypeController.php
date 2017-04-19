<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\VehicleType;
use App\Price;

class VehicleTypeController extends Controller {

    public function index() {
        $vehicleTypes = VehicleType::all();

        $prices = Price::where('active', 1)->get();

        return view('vehicle_types.index', [
            'title' => 'Tipos de Vehículo',
            'vehicleTypes' => $vehicleTypes,
            'prices' => $prices
        ]);
    }

    public function store(Request $request) {
        $vehicleType = new VehicleType();
        $vehicleType->name = $request->name;

        $vehicleType->save();

        $prices = $request->prices;
        foreach ($prices as $key => $value) {
            $price = Price::findOrFail($key);

            $price->vehicle_types()->save($vehicleType, ['value' => $value]);
        }

        return response()->json($vehicleType);
    }

    public function update(Request $request) {
        $vehicleType = VehicleType::findOrFail($request->id);
        $vehicleType->name = $request->name;

        $vehicleType->save();

        $prices = $request->prices;

        $syncData = array();
        foreach ($prices as $key => $value) {
            $syncData[$key] = array('value' => $value);
        }

        $vehicleType->prices()->sync($syncData);

        return response()->json($vehicleType);
    }

    public function changeState(Request $request) {

        $vehicleType = VehicleType::findOrFail($request->id);

        $vehicleType->active = ($vehicleType->active == 1) ? 0 : 1;
        $vehicleType->save();

        return response()->json($vehicleType);

    }
}
