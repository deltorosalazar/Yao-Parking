<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Tax;

class TaxController extends Controller {

    public function index() {
        $taxes = Tax::all();

        return view('taxes.index', [
            'title' => 'Impuestos',
            'taxes' => $taxes
        ]);
    }

    public function store(Request $request) {
        $tax = new Tax();
        $tax->name = $request->name;
        $tax->percentage = $request->percentage;

        $tax->save();

        return response()->json($tax);
    }

    public function update(Request $request) {
        $tax = Tax::findOrFail($request->id);
        $tax->name = $request->name;
        $tax->percentage = $request->percentage;

        $tax->save();

        return response()->json($tax);
    }

    public function changeState(Request $request) {
        $tax = Tax::findOrFail($request->id);
        $tax->active = ($tax->active == 1) ? 0 : 1;

        $tax->save();

        return response()->json($tax);
    }


}
