<?php

namespace App\Helpers\RoundingUpTo;

if (!function_exists('rounding_up_to')) {
    function rounding_up_to($num, $x = 5)
    {
        if($num%$x < $x/2) {
            return $num - ($num%$x);
        } else {
            return $num + ($x-($num%$x));
        }
    }
}
