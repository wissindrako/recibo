<?php

namespace App\Helpers;

use ParseError;


// Como usar
// $literal = new NumberToWords();
// echo $literal->toWords(1100); => MIL CIEN

// $literal = new NumberToWords();
// $literal->apocope = true;
// echo $literal->toWords(101) . ' AÑOS'; => CIENTO UN AÑOS

// $literal = new NumberToWords();
// echo $literal->toMoney(2500.90, 2, 'DÓLARES', 'CENTAVOS'); => DOS MIL QUINIENTOS DÓLARES CON NOVENTA CENTAVOS

// $literal = new NumberToWords();
// echo $literal->toMoney(10.10, 2, 'SOLES', 'CENTIMOS'); => DIEZ SOLES CON DIEZ CENTIMOS

// $literal = new NumberToWords();
// $literal->conector = 'Y';
// echo $literal->toMoney(11.10, 2, 'pesos', 'centavos'); => ONCE PESOS Y DIEZ CENTAVOS

// $literal = new NumberToWords();
// echo $literal->toInvoice(1700.50, 2, 'soles'); => MIL SETECIENTOS CON 50/100 SOLES

// $literal = new NumberToWords();
// echo $literal->toString(5.2, 1, 'años', 'meses'); => CINCO AÑOS CON DOS MESES


class NumberToWords
{
    /**
     * @var array
     */
    private $unidades = [
        '',
        'uno ',
        'dos ',
        'tres ',
        'cuatro ',
        'cinco ',
        'seis ',
        'siete ',
        'ocho ',
        'nueve ',
        'diez ',
        'once ',
        'doce ',
        'trece ',
        'catorce ',
        'quince ',
        'dieciséis ',
        'diecisiete ',
        'dieciocho ',
        'diecinueve ',
        'veinte ',
    ];

    /**
     * @var array
     */
    private $decenas = [
        'veinti',
        'treinta ',
        'cuarenta ',
        'cincuenta ',
        'sesenta ',
        'setenta ',
        'ochenta ',
        'noventa ',
        'cien ',
    ];

    /**
     * @var array
     */
    private $centenas = [
        'ciento ',
        'doscientos ',
        'trescientos ',
        'cuatrocientos ',
        'quinientos ',
        'seiscientos ',
        'setecientos ',
        'ochocientos ',
        'novecientos ',
    ];

    /**
     * @var array
     */
    private $acentosExcepciones = [
        'veintidos'  => 'veintidós ',
        'veintitres' => 'veintitrés ',
        'veintiseis' => 'veintiséis ',
    ];

    /**
     * @var string
     */
    public $conector = 'con';

    /**
     * @var bool
     */
    public $apocope = false;

    /**
     * Formatea y convierte un número a letras.
     *
     * @param int|float $number
     * @param int       $decimals
     *
     * @return string
     */
    public function toWords($number, $decimals = 2)
    {
        $this->checkApocope();

        $number = number_format($number, $decimals, '.', '');

        $splitNumber = explode('.', $number);

        $splitNumber[0] = $this->wholeNumber($splitNumber[0]);

        if (!empty($splitNumber[1])) {
            $splitNumber[1] = $this->convertNumber($splitNumber[1]);
        }

        return ucfirst($this->glue($splitNumber));
    }

    /**
     * Formatea y convierte un número a letras en formato moneda.
     *
     * @param int|float $number
     * @param int       $decimals
     * @param string    $currency
     * @param string    $cents
     *
     * @return string
     */
    public function toMoney($number, $decimals = 2, $currency = '', $cents = '')
    {
        $this->checkApocope();

        $number = number_format($number, $decimals, '.', '');

        $splitNumber = explode('.', $number);

        $splitNumber[0] = $this->wholeNumber($splitNumber[0]) . ' ' . mb_strtoupper($currency, 'UTF-8');

        if (!empty($splitNumber[1])) {
            $splitNumber[1] = $this->convertNumber($splitNumber[1]);
        }

        if (!empty($splitNumber[1])) {
            $splitNumber[1] .= ' ' . $cents;
        }

        return ucfirst($this->glue($splitNumber));
    }

    /**
     * Formatea y convierte un número a letras en formato libre.
     *
     * @param int|float $number
     * @param int       $decimals
     * @param string    $whole_str
     * @param string    $decimal_str
     *
     * @return string
     */
    public function toString($number, $decimals = 2, $whole_str = '', $decimal_str = '')
    {
        return $this->toMoney($number, $decimals, $whole_str, $decimal_str);
    }

    /**
     * Formatea y convierte un número a letras en formato facturación electrónica.
     *
     * @param int|float $number
     * @param int       $decimals
     * @param string    $currency
     *
     * @return string
     */
    public function toInvoice($number, $decimals = 2, $currency = '')
    {
        $this->checkApocope();

        $number = number_format($number, $decimals, '.', '');

        $splitNumber = explode('.', $number);

        $splitNumber[0] = $this->wholeNumber($splitNumber[0]);

        if (!empty($splitNumber[1])) {
            $splitNumber[1] .= '/100 ';
        } else {
            $splitNumber[1] = '00/100 ';
        }

        return ucfirst($this->glue($splitNumber) . $currency);
    }

    /**
     * Valida si debe aplicarse apócope de uno.
     *
     * @return void
     */
    private function checkApocope()
    {
        if ($this->apocope === true) {
            $this->unidades[1] = 'un ';
        }
    }

    /**
     * Formatea la parte entera del número a convertir.
     *
     * @param string $number
     *
     * @return string
     */
    private function wholeNumber($number)
    {
        if ($number == '0') {
            $number = 'cero ';
        } else {
            $number = $this->convertNumber($number);
        }

        return $number;
    }

    /**
     * Concatena las partes formateadas del número convertido.
     *
     * @param array $splitNumber
     *
     * @return string
     */
    private function glue($splitNumber)
    {
        return implode(' ' . $this->conector . ' ', array_filter($splitNumber));
    }

    /**
     * Convierte número a letras.
     *
     * @param string $number
     *
     * @return string
     */
    private function convertNumber($number)
    {
        $converted = '';

        if (($number < 0) || ($number > 999999999)) {
            throw new ParseError('Wrong parameter number');
        }

        $numberStrFill = str_pad($number, 9, '0', STR_PAD_LEFT);
        $millones = substr($numberStrFill, 0, 3);
        $miles = substr($numberStrFill, 3, 3);
        $cientos = substr($numberStrFill, 6);

        if (intval($millones) > 0) {
            if ($millones == '001') {
                $converted .= 'un millon ';
            } elseif (intval($millones) > 0) {
                $converted .= sprintf('%smillones ', $this->convertGroup($millones));
            }
        }

        if (intval($miles) > 0) {
            if ($miles == '001') {
                $converted .= 'mil ';
            } elseif (intval($miles) > 0) {
                $converted .= sprintf('%smil ', $this->convertGroup($miles));
            }
        }

        if (intval($cientos) > 0) {
            if ($cientos == '001') {
                $this->apocope === true ? $converted .= 'un ' : $converted .= 'uno ';
            } elseif (intval($cientos) > 0) {
                $converted .= sprintf('%s ', $this->convertGroup($cientos));
            }
        }

        return trim($converted);
    }

    /**
     * @param string $n
     *
     * @return string
     */
    private function convertGroup($n)
    {
        $output = '';

        if ($n == '100') {
            $output = 'Cien ';
        } elseif ($n[0] !== '0') {
            $output = $this->centenas[$n[0] - 1];
        }

        $k = intval(substr($n, 1));

        if ($k <= 20) {
            $unidades = $this->unidades[$k];
        } else {
            if (($k > 30) && ($n[2] !== '0')) {
                $unidades = sprintf('%sy %s', $this->decenas[intval($n[1]) - 2], $this->unidades[intval($n[2])]);
            } else {
                $unidades = sprintf('%s%s', $this->decenas[intval($n[1]) - 2], $this->unidades[intval($n[2])]);
            }
        }

        $output .= array_key_exists(trim($unidades), $this->acentosExcepciones) ?
            $this->acentosExcepciones[trim($unidades)] : $unidades;

        return $output;
    }
}
