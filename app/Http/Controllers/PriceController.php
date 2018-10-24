<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use Illuminate\Support\Facades\Input;
use Response;
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
        $rules = array(
            'price_name' => 'required',
        );

        $messages = [
            'price_name.required' => 'Ingrese un Nombre',
        ];

        $validator = Validator::make(Input::all(), $rules, $messages);
        if ($validator->fails()) {
            return Response::json(array('errors' => $validator->getMessageBag()->toArray()));
        } else {
            $price = new Price();
            $price->name = $request->name;

            $price->save();

            return response()->json($price);
        }
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
