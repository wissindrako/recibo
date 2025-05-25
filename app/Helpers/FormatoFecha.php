<?php

namespace App\Helpers;

use Carbon\Carbon;

class FormatoFecha
{
    /**
     * Devuelve la extension de la media file.
     *
     * @param string $string
     *
     * @return string
     */


    function fecha($date)
    {
        if ($date) {
            $meses = array("Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");
            $fecha = Carbon::parse($date);
            $mes = $meses[($fecha->format('n')) - 1];
            return $fecha->format('d') . ' de ' . $mes . ' de ' . $fecha->format('Y');
        } else {
            return "";
        }
    }

    function fecha_dmy($date)
    {
        $format = 'd/m/Y';
        if ($date) {
            $fecha = Carbon::parse($date);
            return $fecha->format($format);
        } else {
            return "";
        }
    }

    function fecha_dmyhm($date)
    {
        $format = 'd/m/Y h:m';
        if ($date) {
            $fecha = Carbon::parse($date);
            return $fecha->format($format);
        } else {
            return "";
        }
    }

    function gestion($date)
    {
        if ($date) {
            $fecha = Carbon::parse($date);
            return $fecha->year;
        } else {
            return "20__";
        }
    }

    function hora($date)
    {
        if ($date) {
            $fecha = Carbon::parse($date);
            return $fecha->toTimeString();
        } else {
            return "";
        }
    }
}
