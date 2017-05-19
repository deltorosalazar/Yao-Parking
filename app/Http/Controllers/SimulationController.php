<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use DB;
use Illuminate\Support\Facades\Redis;
use Validator;
use Illuminate\Support\Facades\Input;
use Response;
use Illuminate\Support\Facades\Redirect;

use App\VehicleType;
use App\Movement;
use App\Parking;
use App\Simulation;
use App\SimulationDetail;
use App\Quota;
use App\Tax;


use App\User;
use App\Http\Controllers\YaoDate;



class SimulationController extends Controller {

    // private static $vehicle_types_list = null;
    // private static $movements_list = null;

    private static $simulation = 1;

    private static $vehicle_id = 1;

    public function index() {
        // echo memory_get_usage();
        // var_dump($this->getSystemMemInfo());
        // exit;

        $simulations = Simulation::all();
        $total_parkings = Parking::where('active', 1)->get();
        $total_vehicle_types = VehicleType::count();

        return view('simulations.index', [
            'title' => 'Simulaciones',
            'simulations' => $simulations,
            'total_parkings' => $total_parkings,
            'total_vehicle_types' => $total_vehicle_types
        ]);
    }




    public function store(Request $request) {

        // dd($request);
        // exit();


        // $rules = array(
        //     'start_date' => 'required',
        //     'end_date' => 'required'
        // );
        //
        // $messages = [
        //     'start_date.required' => 'Ingrese una Fecha de Inicio',
        //     'end_date.required' => 'Ingrese una Fecha de Finalización',
        // ];
        //
        // $validator = Validator::make(Input::all(), $rules, $messages);
        // if ($validator->fails()) {
        //     return Response::json(array('errors' => $validator->getMessageBag()->toArray()));
        // } else {

            $simulation = new Simulation();

            $simulation->start_date = $request->start_date;
            $simulation->finish_date = $request->finish_date;

            $simulation->save();


            $start_date = $request->start_date;
            $finish_date = $request->finish_date;
            // dd($simulation);
            // exit;

            $result = $this->startSimulation($simulation->id, $start_date, $finish_date);
            // return response()->json($simulation);

            // dd($result);
            // exit;



            return view('simulations.completed', [
                'title' => 'Simulación Finalizada',
                'status' => $result
            ]);
        // }
    }

    public function show($id) {
        $simulation = Simulation::find($id);

        if (is_null($simulation)) {
            return abort(404);
        }

        $taxes = Tax::all();

        $years = DB::table('simulation_details')
            ->select(DB::raw('year(out_date) as y'))
            ->where('out_date', '<>', null)
            ->distinct()
            ->get();

        $parkings = DB::table('simulation_details')
            ->select(DB::raw('parking_id'))
            ->distinct()
            ->get();

        // dd($years);
        // exit;

        $vehicle_types = VehicleType::where('active', 1)->get();
        $movements = Movement::where('id', 1)->orWhere('id', 2)->get();

        $movements_names = array();
        $movements_count = array();

        foreach ($movements as $movement) {
            $movements_names[] = $movement->name;
            $movements_count[] = SimulationDetail::where('movement_id', $movement->id)->count();
        }

        // SELECT parking_id, sum(price) total FROM `simulation_details`
        // GROUP by parking_id
        // ORDER by total DESC
        // LIMIT 10

        $earnings = DB::table('simulation_details')
            ->select('parking_id', DB::raw('SUM(price) as total'))
            ->groupBy('parking_id')
            ->havingRaw('SUM(price) > 0')
            ->orderBy('total', 'desc')
            ->limit(10)
            ->get();

        $vehicle_types_earnings = array();

        foreach ($vehicle_types as $vehicle_type) {
            $vehicle_types_earnings[] = array(
                'id' => $vehicle_type->id,
                'name' => $vehicle_type->name,
                'earnings' => DB::table('simulation_details')
                ->select('parking_id', DB::raw('SUM(price) as total'))
                ->where('vehicle_type_id', $vehicle_type->id)
                ->groupBy('parking_id')
                ->havingRaw('SUM(price) > 0')
                ->orderBy('total', 'desc')
                ->limit(10)
                ->get()
            );
        }

        return view('simulations.show', [
            'title' => 'Simulación # ' . $id,
            'simulation' => $simulation,
            'movements_names' => $movements_names,
            'movements_count' => $movements_count,
            'taxes' => $taxes,
            'earnings' => $earnings,
            'total_earnings' => $this->computeTotalEarnings($earnings),
            'vehicle_types_earnings' => $vehicle_types_earnings,
            'total_vehicle_types_earnings' => $this->computeTotalEarningsByVehicleType($vehicle_types_earnings),
            // 'monthly_earnings' => $this->computeMonthlyEarnings(),
            'parkings_to_improve' => $this->improveQuotas(),
            'years' => $years,
            'parkings' => $parkings,
        ]);
    }

    public function computeTotalEarnings($earnings) {
        $total_earnings = 0;

        foreach ($earnings as $earning) {
            $total_earnings += $earning->total;
        }

        return $total_earnings;
    }

    public function computeTotalEarningsByVehicleType($vehicle_types_earnings) {
        $total_vehicle_types_earnings = array();
        $total_earning = 0;
        $index = 1;


        foreach ($vehicle_types_earnings as $key => $vehicle_type) {
            foreach ($vehicle_type['earnings'] as $earning) {
                $total_earning += $earning->total;
            }

            $total_vehicle_types_earnings[$index] = $total_earning;
            $index++;
        }

        return $total_vehicle_types_earnings;
    }

    public function computeMonthlyEarnings(Request $request) {
        $allResponse = array();

        $monthly_earnings = DB::table('simulation_details')
            ->select(DB::raw('year(out_date) as y, MONTHNAME(out_date) as m, SUM(price) as total'))
            ->where('parking_id', $request->parking)
            ->whereYear('out_date', $request->year)
            ->groupBy('y', 'm')
            ->get();

        $allResponse[] = $monthly_earnings;

        $taxes = Tax::where('active', 1)->get();
        $allResponse[] = $taxes;

        $allResponse[] = $request->parking;

        return response()->json($allResponse);
    }

    public function improveQuotas() {
        $quotas_motorcycle = Quota::where('simulation_id', 1)->where('vehicle_type_id', 2)->get();

        $quotas_bicyle = Quota::where('simulation_id', 1)->where('vehicle_type_id', 3)->get();

        $total_days = 1;


        $parkings_to_improve = array();
        $parkings_to_improve_motorcycle = array();
        $parkings_to_improve_bicycle = array();

        foreach ($quotas_motorcycle as $quota) {
            if (($quota->vehicles_exceeded / $total_days) > (($quota->max_quantity) - $quota->max_quantity / 2)) {
                $parkings_to_improve_motorcycle[] = $quota->parking_id;
            }
        }

        foreach ($quotas_motorcycle as $quota) {
            if (($quota->vehicles_exceeded / $total_days) > (($quota->max_quantity) - $quota->max_quantity / 2)) {
                $parkings_to_improve_bicycle[] = $quota->parking_id;
            }
        }

        $parkings_to_improve[] = array(
            'vehicle_type' => 'Motos',
            'parkings' => $parkings_to_improve_motorcycle
        );

        $parkings_to_improve[] = array(
            'vehicle_type' => 'Bicicletas',
            'parkings' => $parkings_to_improve_bicycle
        );

        // foreach ($parkings_to_improve as $parking) {
        //     dd($parking);
        // }
        // exit;

        return $parkings_to_improve;
    }

    public function fillQuotasTable() {
        $vehicle_types = VehicleType::where('active', 1)->get();
        $parkings = Parking::where('active', 1)->get();
        $quotas = array();



        foreach ($parkings as $parking) {

        // }
        // for ($i=1; $i <= 100 ; $i++) {
            // $quota = new Quota();
            //
            // $quota->simulation_id = self::$simulation;
            // $quota->parking_id = $i;
            //
            // foreach ($vehicle_types as $vehicle_type) {
            //     $quota->vehicle_type_id = $vehicle_type->id;
            //     $quota->max_quantity = Redis::hGet('parking:' . $i, 'mx_qty_' . $vehicle_type->id);
            //     $quota->vehicles_exceeded = Redis::hGet('parking:' . $i, 'vehicles_exceeded' . $vehicle_type->id);
            //
            //     DB::table("quotas")->insert($quota->toArray());
            // }

            foreach ($vehicle_types as $vehicle_type) {
                $quota = array(
                    'simulation_id' => self::$simulation,
                    'parking_id' => $parking->id,
                    'vehicle_type_id' => $vehicle_type->id,
                    'max_quantity' => Redis::hGet('parking:' . $parking->id, 'mx_qty_' . $vehicle_type->id),
                    'vehicles_exceeded' => Redis::hGet('parking:' . $parking->id, 'vehicles_exceeded' . $vehicle_type->id),
                    'created_at' => Carbon::now()
                );

                $quotas[] = $quota;


            }


            // $quota->save();
        }

        DB::table("quotas")->insert($quotas);
    }

    public function createLists() {

        if (Redis::exists('vehicle_types_set') == 0) {
            $vehicle_types = VehicleType::where('active', 1)->get();

            foreach ($vehicle_types as $vehicle_type) {
                Redis::sAdd('vehicle_types_set', $vehicle_type->id);
            }
        }

        if (Redis::exists('movements_set') == 0) {
            $movements = Movement::where('active', 1)->get();

            foreach ($movements as $movement) {
                Redis::sAdd('movements_set', $movement->id);
            }
        }

        $parkings = Parking::where('active', 1)->get();
        $vehicle_types = VehicleType::where('active', 1)->get();

        foreach ($parkings as $parking) {
            foreach ($vehicle_types as $vehicle_type) {
                Redis::hSet('parking:' . $parking->id, 'mx_qty_' . $vehicle_type->id, rand(50, 100));
                Redis::hSet('parking:' . $parking->id, 'mx_qty_' . $vehicle_type->id, rand(20, 30));
                Redis::hSet('parking:' . $parking->id, 'mx_qty_' . $vehicle_type->id, rand(20, 30));
                Redis::hSet('parking:' . $parking->id, 'actual_qty_' . $vehicle_type->id, 0);
                Redis::hSet('parking:' . $parking->id, 'actual_qty_' . $vehicle_type->id, 0);
                Redis::hSet('parking:' . $parking->id, 'actual_qty_' . $vehicle_type->id, 0);
                Redis::hSet('parking:' . $parking->id, 'vehicles_exceeded' . $vehicle_type->id, 0);
                Redis::hSet('parking:' . $parking->id, 'vehicles_exceeded' . $vehicle_type->id, 0);
                Redis::hSet('parking:' . $parking->id, 'vehicles_exceeded' . $vehicle_type->id, 0);
            }
        }
    }

    public function in($params, $detail) {
        $detail->movement_id = 1;

        $actual_qty = Redis::hGet('parking:' . $params['actualParking'] , 'actual_qty_' . $params['vehicle_type_in']);
        $mx_qty = Redis::hGet('parking:' . $params['actualParking'], 'mx_qty_' . $params['vehicle_type_in']);

        // echo "<br>";
        // echo "=================";
        // echo "<br>";
        // echo "Parqueadero = " . $params['actualParking'];
        // echo "<br>";
        // echo "Tipo de Vehiculo = " . $params['vehicle_type_in'];
        // echo "<br>";
        // echo "Cantidad Actual = " . $actual_qty;
        // echo "<br>";
        // echo "Cantidad Máxima = " . $mx_qty;
        // echo "<br>";
        // echo "=================";

        if ($actual_qty < $mx_qty) {
            Redis::sAdd('set_parking:' . $params['actualParking'] . ":" . $params['vehicle_type_in'], self::$vehicle_id);
            Redis::hSet('vehicle:' . self::$vehicle_id, 'vehicle_type', $params['vehicle_type_in']);
            Redis::hSet('vehicle:' . self::$vehicle_id, 'in_date', $params['actual_date']);
            Redis::hIncrBy('parking:' . $params['actualParking'], 'actual_qty_' . $params['vehicle_type_in'], 1);

            // echo "<br>";
            // echo "Nueva cantidad = " . Redis::hGet('parking:' . $params['actualParking'] , 'actual_qty_' . $params['vehicle_type_in']);

            $detail->in_date = $params['actual_date'];
            $detail->vehicle_id = self::$vehicle_id;

            // echo "<br>";
            // echo "Se agregó el vehículo " . self::$vehicle_id . " al Parqueadero " . $params['actualParking'];
            // echo "<br>";

            self::$vehicle_id++;
        } else {
            $detail->comment = 'No hay espacio parqueadero';

            Redis::hIncrBy('parking:' . $params['actualParking'], 'vehicles_exceeded' . $params['vehicle_type_in'], 1);
            // falta por ahcer la cuenta de cuantos vehiculos no pudieron entrar al parquedero
        }

        DB::table("simulation_details")->insert($detail->toArray());
        // $detail->save();
    }

    public function out($params, $detail) {
        $detail->movement_id = 2;

        // echo "<br>";
        // echo "=================";
        // echo "<br>";
        // echo "Parqueadero = " . $params['actualParking'];
        // echo "<br>";
        // echo "Tipo de Vehiculo para Salir = " . $params['vehicle_type_out'];
        // echo "<br>";
        // echo "Cantidad Actual = " . Redis::hGet('parking:' . $params['actualParking'], 'actual_qty_' . $params['vehicle_type_out']);
        // echo "<br>";
        // echo "=================";
        // echo "<br>";

        // echo "*********************************************************************************************************";
        // echo "*******************************************************";
        // echo "<br>";
        // var_dump(Redis::hGetAll('parking:' . $params['actualParking']));
        // echo "<br>";
        // echo "*********************************************************************************************************";
        // echo "*******************************************************";
        // echo "<br>";

        if (Redis::hGet('parking:' . $params['actualParking'], 'actual_qty_' . $params['vehicle_type_out']) > 0) {
            $random_vehicle = Redis::sRandMember('set_parking:' . $params['actualParking'] . ":" . $params['vehicle_type_out']);
            $in_date = Redis::hGet('vehicle:' . $random_vehicle , 'in_date');

            // Aqui se calcular si el vehiculo ha estado mas de 5 minutos
            if (YaoDate::minimumTime($in_date, $params['actual_date'])) {
                Redis::sRem('set_parking:' . $params['actualParking'] . ":" . $params['vehicle_type_out'], $random_vehicle);
                Redis::hIncrBy('parking:' . $params['actualParking'], 'actual_qty_' . $params['vehicle_type_out'], -1);

                $detail->out_date = $params['actual_date'];
                $detail->vehicle_id = $random_vehicle;

                Redis::del('vehicle:' . $random_vehicle);

                $detail->price = YaoDate::computePrice($in_date, $params['actual_date'], $params['vehicle_type_out']);

                // echo "Se eliminó el vehículo " . $random_vehicle . " del Parqueadero " . $params['actualParking'];
                // echo "<br>";
                // echo "*********************************************************************************************************";
                // echo "*******************************************************";
                // echo "<br>";
                // var_dump(Redis::hGetAll('parking:' . $params['actualParking']));
                // echo "*********************************************************************************************************";
                // echo "*******************************************************";
                // echo "<br>";
            } else {
                $detail->comment = 'El vehiculo ha estado menos de 5 minutos';
            }
        } else {
            // echo "Parqueadero vacío";
            // echo "<br>";
            $detail->comment = 'No había ningún vehículo de ese tipo en el parqueadero';
        }
        DB::table("simulation_details")->insert($detail->toArray());
        // $detail->save();
    }

    public function testSimulation() {

        $this->createLists();

        $vt_e = [1,1,1,1,2,2,2,2,3,3,3,3,1,1,1];

        $vt_s = [1,1,1,1,2,2,2,2,3,3,3,3,1,1,1];

        for ($i=0; $i < count($vt_e); $i++) {

            $detail = new SimulationDetail();
            $detail->simulation_id = 1; //CAmbiar, poner dinamico
            $detail->parking_id = 1;
            $detail->vehicle_type_id = $vt_e[$i];
            $detail->movement_id = 1;

            $params = [
                'actualParking' => 1,
                'movement' => 1,
                'vehicle_type_in' => $vt_e[$i],
                // 'vehicle_type_out' => $vehicle_type_out,
                'actual_date' => Carbon::create(2012, 1, 31, 0),
            ];

            $this->in($params, $detail);
        }

        for ($i=0; $i < count($vt_s) ; $i++) {
            $detail = new SimulationDetail();
            $detail->simulation_id = 1; //CAmbiar, poner dinamico
            $detail->parking_id = 1;
            $detail->vehicle_type_id = $vt_s[$i];
            $detail->movement_id = 2;

            $params = [
                'actualParking' => 1,
                'movement' => 1,
                // 'vehicle_type_in' => $vt_s[$i],
                'vehicle_type_out' => $vt_s[$i],
                'actual_date' => Carbon::create(2012, 1, 31, 0),
            ];

            $this->out($params, $detail);
        }



    }

    public function startSimulation($id, $start_date, $finish_date) {

        Redis::flushAll();

        $initial_time = Carbon::now(-5);
        ini_set('max_execution_time', 36000);

        // $actual_date = Carbon::create(2012, 1, 31, 6, 0);
        // $end_date = Carbon::create(2012, 2, 2, 22, 00);


        $actual_date = Carbon::parse($start_date);
        $end_date = Carbon::parse($finish_date);

        // echo $actual_date;
        // echo $end_date;
        //
        // exit;


        $christmas = Carbon::create(1990, 12, 31, 0, 0, 0);
        $new_year = Carbon::create(1990, 12, 24, 0, 0, 0);

        $this->createLists();

        $total_days = $actual_date->diffInDays($end_date);
        $total_minutes = $actual_date->diffInMinutes($end_date);

        // echo $total_minutes;
        // exit;

        // echo $total_hours;
        // exit();

        $existingParkings = count(Redis::keys('parking:*'));


        while(!$actual_date->gte($end_date)) {
        // for ($j=0; $j < $total_minutes; $j++) {
            for ($i=1; $i <= $existingParkings; $i++) {
            // for ($i=1; $i <= $existingParkings; $i++) {

                $actual_parking = $i;

                $movement = Redis::sRandMember('movements_set');
                $vehicle_type_in = Redis::sRandMember('vehicle_types_set');
                $vehicle_type_out = Redis::sRandMember('vehicle_types_set');

                $detail = new SimulationDetail();
                $detail->simulation_id = $id; // Cambiar, poner dinámico
                $detail->parking_id = $actual_parking;
                $detail->vehicle_type_id = $vehicle_type_in;
                // $detail->movement_id = $movement;

                $params = [
                    'actualParking' => $actual_parking,
                    // 'movement' => $movement,
                    'vehicle_type_in' => $vehicle_type_in,
                    'vehicle_type_out' => $vehicle_type_out,
                    'actual_date' => $actual_date,
                ];

                if ($movement == 1) {
                    // echo "<br>";
                    // echo "<b>Entrada</b> - " . "Parqueadero = " . $actual_parking;
                    // echo "<br>";
                    // echo "Tipo de Vehiculo = " . $vehicle_type_in;
                    $this->in($params, $detail);

                } else if ($movement == 2) {
                    // echo "<br>";
                    // echo "<b>Salida</b> - " . "Parqueadero " . $actual_parking;
                    // echo "<br>";
                    // echo "Tipo de Vehiculo = " . $vehicle_type_out;
                    $this->out($params, $detail);

                } else {
                    // DB::table("simulation_details")->insert($detail->toArray());
                    // $detail->save();


                    // echo "<br>";
                    // echo "<b>Entrada / Salida</b> - " . "Parqueadero = " . $actual_parking;
                    // echo "<br>";

                    // $detail = new SimulationDetail();
                    // $detail->simulation_id = 1; //CAmbiar, poner dinamico
                    // $detail->parking_id = $actual_parking;
                    // $detail->vehicle_type_id = $vehicle_type_in;
                    // $detail->movement_id = 1;


                    // echo "<br>";
                    // echo "<b>E/S (Entrada)</b> - Parqueadero = " . $actual_parking;
                    $this->in($params, $detail);

                    $detail = new SimulationDetail();
                    $detail->simulation_id = $id; //CAmbiar, poner dinamico
                    $detail->parking_id = $actual_parking;
                    $detail->vehicle_type_id = $vehicle_type_out;
                    // $detail->movement_id = 2;

                    // echo "<br>";
                    // echo "<br>";
                    // echo "<b>E/S (Salida)</b> - Parqueadero = " . $actual_parking;
                    $this->out($params, $detail);
                }

                // echo "<br>";
            }

            // echo "==========================================================================================";
            // echo "==========================================================================================";
            $actual_date->addMinute();

            if ($actual_date->hour == 23) {
                $actual_date->addDay()->hour(6)->minute(0);
            }

            if ($actual_date->isBirthday($christmas) || $actual_date->isBirthday($new_year)) {

                $actual_date->addDay();
            }
        }

        $this->fillQuotasTable();

        // echo '<br>';
        // echo '<br>';
        // echo '<br>';
        // echo 'Fecha Final:    ' . $actual_date;

        $final_time = Carbon::now(-5);

        // return redirect()->route('simulations.completed', [
        //     'title' => 'Simulación Finalizada',
        //     'simulation_initial_date' => $start_date,
        //     'simulation_finish_date' => $finish_date,
        //     'initial_time' => $initial_time,
        //     'final_time' => $final_time,
        //     'total_duration' => Carbon::parse($initial_time)->diffInMinutes($final_time),
        // ]);

        // return view('simulations.completed', [
        //     'title' => 'Simulación Finalizada',
        //     'simulation_initial_date' => $start_date,
        //     'simulation_finish_date' => $finish_date,
        //     'initial_time' => $initial_time,
        //     'final_time' => $final_time,
        //     'total_duration' => Carbon::parse($initial_time)->diffInMinutes($final_time),
        // ]);

        setlocale(LC_TIME, 'Spanish');


        $allocated_memory = memory_get_usage()/1048576;
        $total_duration = $initial_time->diffInSeconds($final_time);

        $results = array(
            'title' => 'Simulación Finalizada',
            'simulation_initial_date' => $start_date,
            'simulation_finish_date' => $finish_date,
            'initial_time' => $initial_time->copy()->toDayDateTimeString(),
            'final_time' => $final_time->copy()->toDayDateTimeString(),
            'total_duration' => $total_duration,
        );

        // dd($results);


        $simulation = Simulation::find($id);
        $simulation->total_duration = $total_duration;
        $simulation->allocated_memory = $allocated_memory;
        $simulation->save();


        return $results;

        // $this->completed($results);

        // return Redirect::action('SimulationController@index');

    }

    public function completed($results) {

        return view('simulations.completed', [
            'title' => 'Simulación Finalizada',
            'simulation_initial_date' => $results['simulation_initial_date'],
            'simulation_finish_date' => $results['simulation_finish_date'],
            'initial_time' => $results['initial_time'],
            'final_time' => $results['final_time'],
            'total_duration' => Carbon::parse($results['initial_time'])->diffInMinutes($results['final_time']),
        ]);
    }

}
