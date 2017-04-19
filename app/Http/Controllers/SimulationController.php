<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Simulation;

class SimulationController extends Controller {

    private static $vehiclesTypes = [];

    public function index() {
        $simulations = Simulation::all();

        return view('simulations.index', [
            'title' => 'Simulaciones',
            'simulations' => $simulations
        ]);
    }

    public function startSimulation() {
        $vehiclesTypes[] = 1;
        $vehiclesTypes[] = 2;
        $vehiclesTypes[] = 3;

        var_dump($vehiclesTypes);
    }

    public function createParkings() {
        for ($i=0; $i < 100; $i++) { 

        }
    }
}
