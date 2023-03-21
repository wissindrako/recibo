<?php

namespace App\Helpers;

use Carbon\Carbon;

class FormatoTexto
{
    /**
     * Devuelve la extension de la media file.
     *
     * @param string $string
     *
     * @return string
     */
    function extension($media)
    {
        $separado = explode(".", $media);
        return array_pop($separado);
    }

    /**
     * Rellena con ceros a la izquierda.
     *
     * @param int $número
     * @param int $cantidad de ceros
     *
     * @return int
     */
    public static function zero_fill_left ($valor, $long = 0)
    {
        return str_pad($valor, $long, '0', STR_PAD_LEFT);
    }

    /**
     * Devuelve la extension de un File.
     *
     * @param string $string
     *
     * @return string
     */
    function tipoArchivo($archivo)
    {

        if ($archivo == "doc" || $archivo == "docx") {
            return  [
                "tipo" => "word",
                "text" => "text-primary",
                "icono" => "far fa-file-word",
            ];
        }

        if ($archivo == "png" || $archivo == "jpg" || $archivo == "jepg" || $archivo == "gif") {
            return  [
                "tipo" => "imagen",
                "text" => "text-warning",
                "icono" => "far fa-file-image",
            ];
        }

        if ($archivo == "pdf") {
            return  [
                "tipo" => "pdf",
                "text" => "text-danger",
                "icono" => "far fa-file-pdf",
            ];
        }

        return  [
            "tipo" => "desconocido",
            "text" => "text-muted",
            "icono" => "far fa-file-times",
        ];
    }

    function fecha($date){
        if ($date) {
            $meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
            $fecha = Carbon::parse($date);
            $mes = $meses[($fecha->format('n')) - 1];
            return $fecha->format('d') . ' de ' . $mes . ' de ' . $fecha->format('Y');
        } else {
            return "";
        }

    }

    function fecha_dmy($date){
        $format = 'd/m/Y';
        if ($date) {
            $fecha = Carbon::parse($date);
            return $fecha->format($format);
        } else {
            return "";
        }

    }

    function gestion($date){
        if ($date) {
            $fecha = Carbon::parse($date);
            return $fecha->year;
        } else {
            return "20__";
        }

    }

    function hora($date){
        if ($date) {
            $fecha = Carbon::parse($date);
            return $fecha->toTimeString();
        } else {
            return "";
        }

    }

    /**
     * Elimina acentos y caracteres en una cadena.
     *
     * @param string $string
     *
     * @return string
     */
    function eliminar_acentos($cadena){

		//Reemplazamos la A y a
		$cadena = str_replace(
		array('Á', 'À', 'Â', 'Ä', 'á', 'à', 'ä', 'â', 'ª'),
		array('A', 'A', 'A', 'A', 'a', 'a', 'a', 'a', 'a'),
		$cadena
		);

		//Reemplazamos la E y e
		$cadena = str_replace(
		array('É', 'È', 'Ê', 'Ë', 'é', 'è', 'ë', 'ê'),
		array('E', 'E', 'E', 'E', 'e', 'e', 'e', 'e'),
		$cadena );

		//Reemplazamos la I y i
		$cadena = str_replace(
		array('Í', 'Ì', 'Ï', 'Î', 'í', 'ì', 'ï', 'î'),
		array('I', 'I', 'I', 'I', 'i', 'i', 'i', 'i'),
		$cadena );

		//Reemplazamos la O y o
		$cadena = str_replace(
		array('Ó', 'Ò', 'Ö', 'Ô', 'ó', 'ò', 'ö', 'ô'),
		array('O', 'O', 'O', 'O', 'o', 'o', 'o', 'o'),
		$cadena );

		//Reemplazamos la U y u
		$cadena = str_replace(
		array('Ú', 'Ù', 'Û', 'Ü', 'ú', 'ù', 'ü', 'û'),
		array('U', 'U', 'U', 'U', 'u', 'u', 'u', 'u'),
		$cadena );

		//Reemplazamos la N, n, C y c
		$cadena = str_replace(
		array('Ñ', 'ñ', 'Ç', 'ç'),
		array('N', 'n', 'C', 'c'),
		$cadena
		);

		return $cadena;
	}
}



