<?php

use App\Helpers\Hashid;

if (!function_exists('f_formato')) {
    function f_formato($fecha)
    {
        return date("d/m/Y", strtotime($fecha));
    }
}

if (!function_exists('hid')) {
    function hid(int $id): string
    {
        return Hashid::encode($id);
    }
}
