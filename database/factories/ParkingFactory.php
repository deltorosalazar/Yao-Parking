<?php

use Atrox\Haikunator;

$factory->define(App\Parking::class, function () {

    Haikunator::$NOUNS = ["parking"];

    return [
        'name' => Haikunator::haikunate(["tokenLength" => 0]) . '-def',
    ];
});
