<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="{{asset('css/app.css')}}">
    <link rel="stylesheet" href="{{asset('css/reporte.css')}}">
	<title>Recibo</title>
    {{-- <x-styles/> --}}
</head>
<body>
    <header style="width: 100%;">
        <table>
            <tr class="cabecera">
                @php
                    $fecha = explode('-', $recibo->fecha);
                @endphp
                <td align="center" width="30px">
                    <small>DIA</small><br>
                    <b style="font-size: 14px;">{{$fecha[2]}}</b>
                </td>
                <td align="center" width="30px">
                    <small>MES</small><br>
                    <b style="font-size: 14px;">{{$fecha[1]}}</b>
                </td>
                <td align="center" width="40px">
                    <small>AÑO</small><br>
                    <b style="font-size: 14px;">{{$fecha[0]}}</b>
                </td>
                <td class="titulo" style="font-size: 36px;font-style: bold;">
                    <p>RECIBO</p>
                </td>
                <td>
                    <div class="nro_serie">
                        <div class="espacio_serie">
                            <small>N° </small>
                            <span style="font-size: 16px;">{{ $recibo->nro_serie }} </span>
                        </div>
                    </div>
                </td>
            </tr>
        </table>
    </header>

    <footer style="width: 100%;">
        <table>
            <tr>
                <td align="center" width="250px">
                    <span style="color:darkgray;">.............................</span><br>
                    <b>{{ $recibo->cliente->nombres }} {{ $recibo->cliente->ap_paterno }} {{ $recibo->cliente->ap_materno }}</b><br>
                    <small>ENTREGADO POR:</small>
                </td>
                <td align="center" width="200px">
                    <span style="color:darkgray;">.............................</span><br>
                    <b>{{ $recibo->usuario->name }}</b><br>
                    <small>RECIBIDO POR:</small>
                </td>
            </tr>
        </table>
    </footer>
    <div class="nivel">
        <p>
            <b>He recibido de {{$recibo->cliente->genero == 'M' ? 'el' : ''}} {{$recibo->cliente->genero == 'F' ? 'la' : ''}}: </b> {{ $recibo->cliente->titulo }} {{ $recibo->cliente->nombres }} {{ $recibo->cliente->ap_paterno }} {{ $recibo->cliente->ap_materno }} <br>
            <b>La suma de: </b> {{ $recibo->cantidad_literal }} <br>
            <b>Por concepto de:</b> {{ $recibo->concepto }}
        </p>
    </div>
    <div style="text-align: right;padding-right:10; margin-top:-10px;line-height: 0.5cm;font-size: 18px;">
        <p><b>Total:</b> {{ $recibo->cantidad }}</p>
    </div>
</body>
</html>
