<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="{{asset('css/app.css')}}">
    <link rel="stylesheet" href="{{asset('css/reporte.css')}}">
    <title>Recibo</title>
</head>
<body>   
    <header style="width: 100%;">
        <table>
            <tr class="cabecera">
                @php
                    $fecha = explode('-', $recibo->fecha);
                @endphp
                <td align="center" width="30px" style="border-right: solid; border-color: rgba(50, 235, 17, 0.676)">
                    <small>DIA</small><br>
                    <b style="font-size: 14px;">{{$fecha[2]}}</b>
                </td>
                <td align="center" width="30px" style="border-right: solid; border-color: rgba(50, 235, 17, 0.676)">
                    <small>MES</small><br>
                    <b style="font-size: 14px;">{{$fecha[1]}}</b>
                </td>
                <td align="center" width="40px" style="border-right: solid; border-color: rgba(50, 235, 17, 0.676)">
                    <small>AÑO</small><br>
                    <b style="font-size: 14px;">{{$fecha[0]}}</b>
                </td>
                <td class="titulo">
                    <p>RECIBO</p>
                </td>
                <td>
                    <div class="nro_serie">
                        <div class="espacio_serie">
                            <small>N° </small>
                            <span style="font-size: 18px;">{{ $recibo->nro_serie }} </span>
                        </div>
                    </div>
                </td>
            </tr>
        </table>
    </header>

    <footer style="width: 100%;">
        <table>
            <tr>
                <td width="70px"></td>
                <td align="center" width="450px">
                    <span>{{ $recibo->hash }}</span><br>
                    <small style="color:rgb(66, 66, 66);">[Escanéa el Código QR para su Verificación]</small>
                </td>
            </tr>
        </table>
    </footer>
    <div class="nivel">
        <p>
            <b>Se recibió de {{$recibo->cliente->genero == 'M' ? 'el' : ''}} {{$recibo->cliente->genero == 'F' ? 'la' : ''}}: </b> {{ $recibo->cliente->titulo }} {{ $recibo->cliente->nombres }} {{ $recibo->cliente->ap_paterno }} {{ $recibo->cliente->ap_materno }} <br>
            <b>La suma de: </b> {{ $recibo->cantidad_literal }} <br>
            <b>Por concepto de:</b> {{ $recibo->concepto }}
        </p>
    </div>
    <div style="text-align: right;padding-right:10; margin-top:-10px;line-height: 0.5cm;font-size: 18px;">
        <p>Total Bs.: <b>{{ $recibo->cantidad }}</b></p>
    </div>
        @if(isset($qr_base64))
        <div id="watermark">
            <img src="{{ $qr_base64 }}" alt="QR de verificación" style="width:120px; height:120px;">
        </div>
    @endif
</body>
</html>
