<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Price;

class PriceController extends Controller {
    public function index() {
        $prices = Price::all();

        return view('prices.index', [
            'title' => 'Tarifas',
            'prices' => $prices
        ]);
    }

    public function store(Request $request) {
        $price = new Price();
        $price->name = $request->name;

        $price->save();

        return response()->json($price);
    }

    public function update(Request $request) {
        $price = Price::findOrFail($request->id);
        $price->name = $request->name;

        $price->save();

        return response()->json($price);
    }

    public function changeState(Request $request) {
        $price = Price::findOrFail($request->id);
        $price->active = ($price->active == 1) ? 0 : 1;

        $price->save();

        return response()->json($price); 

    }
}
