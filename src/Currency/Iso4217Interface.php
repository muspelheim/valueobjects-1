<?php

namespace RHorv\ValueObjects\Currency;

interface Iso4217Interface
{
    const USD = [
        'number' => 840,
        'exponent' => 2
    ];
    const GBP = [
        'number' => 826,
        'exponent' => 2
    ];
    const EUR = [
        'number' => 978,
        'exponent' => 2
    ];

}