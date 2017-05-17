<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;

use App\VehicleType;


class YaoDate extends Controller {

    public static function getValues($id) {

        $vehicle_type = VehicleType::find($id);

        $vehicle_type_prices = array();

        foreach ($vehicle_type->prices as $price) {
            $vehicle_type_prices[$price->name] = $price->pivot->value;
        }

        return ($vehicle_type_prices);

    }


    public static function isClosed($out_date) {

        $closing_time = Carbon::parse($out_date)->hour(23)->minute(0);


        $opening_time = Carbon::parse($out_date)->addDay()->hour(5)->minute(59);

        return (int)($out_date->between($closing_time, $opening_time));
    }

    public static function minimumTime($in_date, $out_date) {

        if (Carbon::parse($in_date)->diffInMinutes(Carbon::parse($out_date)) > 5) {
            return true;
        }
        return false;
    }

    public static function computePrice($in_date, $out_date, $vehicle_type) {
    // public static function computePrice($vehicle_type) {

        $in_date = Carbon::parse($in_date);
        $out_date = Carbon::parse($out_date);


        $total_price = 0;

        $vehicle_type_prices = self::getValues($vehicle_type);

        // $in_date = Carbon::create(2010, 10, 10, 8, 03);
        // $out_date = Carbon::create(2010, 10, 15, 6, 06);

        // $in_date = Carbon::create(2010, 10, 10, 8, 03);
        // $out_date = Carbon::create(2010, 10, 10, 15, 03);

        $total_days = $in_date->diffInDays($out_date);

        $first_day_minutes = $in_date->diffInMinutes($out_date);

        if ($first_day_minutes * $vehicle_type_prices["Por Minuto"] > $vehicle_type_prices["Máxima Diaria"]) {
            $total_price += 15000;
        } else {
            $total_price += $first_day_minutes * $vehicle_type_prices["Por Minuto"];
        }

        if ($total_days > 0) {
            if ((int)$in_date->hour - (int)$out_date->hour > 0) {
                $total_days_D = $total_days;
                $total_days++;
            } else {
                $total_days_D = $total_days - 1;
            }

            for ($i=0; $i < $total_days_D; $i++) {
                $total_price += $vehicle_type_prices["Máxima Diaria"];
            }

            $penalty = $total_days * $vehicle_type_prices["Multa Nocturna"];

            $total_price += $penalty;

            $last_day_start = $in_date->copy()->addDays($total_days)->hour(6)->minute(0);

            $total_price += $last_day_start->diffInMinutes($out_date) * $vehicle_type_prices["Por Minuto"];
        }

        return $total_price;




    }

}
