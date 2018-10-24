<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Movement;

class MovementController extends Controller {

    public function index() {
        $movements = Movement::all();

        return view('movements.index', [
            'title' => 'Movimientos',
            'movements' => $movements            
        ]);
    }
}
