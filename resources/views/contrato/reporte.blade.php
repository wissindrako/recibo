<!DOCTYPE html>
<html lang="es">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Contrato {{ $contrato->nro_serie }}</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 11pt;
            margin: 2cm 2.5cm;
            color: #111;
            line-height: 1.6;
        }
        .titulo {
            text-align: center;
            font-size: 14pt;
            font-weight: bold;
            text-transform: uppercase;
            margin-bottom: 4px;
        }
        .subtitulo {
            text-align: center;
            font-size: 10pt;
            margin-bottom: 20px;
            color: #444;
        }
        p { margin: 8px 0; text-align: justify; }
        .clausula-titulo { font-weight: bold; margin-top: 14px; }
        .firmas { margin-top: 60px; }
        .firmas table { width: 100%; }
        .firma-linea { border-top: 1px solid #333; padding-top: 4px; text-align: center; width: 45%; }
    </style>
</head>
<body>

<div class="titulo">CONTRATO DE {{ strtoupper($contrato->tipoTexto) }}</div>
<div class="subtitulo">N° {{ $contrato->nro_serie }}</div>

<p>
    @php
        $arr = $contrato->arrendador->persona;
        $arrEsFemenino = $arr->genero === 'F';
        $arrTrato = $arr->titulo ?: ($arrEsFemenino ? 'Sra.' : 'Sr.');
        $arrCI = $arr->ci . ($arr->complemento ? ' '.$arr->complemento : '') . ($arr->expedido ? ' '.$arr->expedido : '');
    @endphp
    Conste por el presente contrato que celebran de una parte como
    @if($arrEsFemenino)
        LA ARRENDADORA la {{ $arrTrato }} <strong>{{ strtoupper($arr->nombre_completo) }}</strong>
    @else
        EL ARRENDADOR el {{ $arrTrato }} <strong>{{ strtoupper($arr->nombre_completo) }}</strong>
    @endif
    identificado con la cédula de identidad <strong>{{ $arrCI }}</strong>
    @if($arr->domicilio) con domicilio en {{ $arr->domicilio }} @endif;
    y de otra parte como
    @if($contrato->persona->genero === 'F') LA ARRENDATARIA @else EL ARRENDATARIO @endif,
    {{ $contrato->persona->genero === 'F' ? 'la señora' : 'el señor' }}
    <strong>{{ strtoupper($contrato->persona->nombre_completo) }}</strong>
    @if($contrato->persona->ci)
        identificado con la cédula de identidad <strong>{{ $contrato->persona->ci }}{{ $contrato->persona->complemento ? ' '.$contrato->persona->complemento : '' }}{{ $contrato->persona->expedido ? ' '.$contrato->persona->expedido : '' }}</strong>
    @endif
    ; quienes convienen de mutuo acuerdo y regulado por las leyes vigentes sobre la materia, en los términos y condiciones siguientes:
</p>

<p class="clausula-titulo">ANTECEDENTES:</p>

<p>
    <strong>PRIMERA.-</strong>
    @if($arrEsFemenino)
        LA ARRENDADORA es propietaria del inmueble o bien descrito como: {{ $contrato->descripcion_bien }}.
    @else
        EL ARRENDADOR es propietario del inmueble o bien descrito como: {{ $contrato->descripcion_bien }}.
    @endif
</p>

<p>
    <strong>SEGUNDA.-</strong> Mediante el presente contrato
    @if($arrEsFemenino) LA ARRENDADORA @else EL ARRENDADOR @endif
    da en {{ strtolower($contrato->tipoTexto) }} a
    @if($contrato->persona->genero === 'F') LA ARRENDATARIA @else EL ARRENDATARIO @endif
    {{ $contrato->descripcion_bien }}, a partir del
    @php $mesesN = ['Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre']; @endphp
    <strong>{{ $contrato->fecha_inicio->format('d') }} de {{ $mesesN[$contrato->fecha_inicio->month - 1] }} de {{ $contrato->fecha_inicio->format('Y') }}</strong>
    @if($contrato->fecha_fin)
        hasta el <strong>{{ $contrato->fecha_fin->format('d') }} de {{ $mesesN[$contrato->fecha_fin->month - 1] }} de {{ $contrato->fecha_fin->format('Y') }}</strong>
    @endif
    .
</p>

@if($contrato->tipo === 'alquiler')
<p class="clausula-titulo">RENTA (FORMA Y OPORTUNIDAD DE PAGO):</p>

<p>
    <strong>TERCERA.-</strong> Las partes acuerdan que el monto de la renta que pagará
    @if($contrato->persona->genero === 'F') LA ARRENDATARIA @else EL ARRENDATARIO @endif
    asciende a la suma de <strong>{{ number_format($contrato->monto, 2) }} bolivianos por mes</strong>,
    cantidad que será cancelada
    @if($contrato->dia_limite_pago)
        hasta los primeros <strong>{{ $contrato->dia_limite_pago }} días</strong> de cada mes y de manera puntual.
    @else
        de manera puntual cada mes.
    @endif
    @if($contrato->garantia)
        Asimismo, @if($contrato->persona->genero === 'F') LA ARRENDATARIA @else EL ARRENDATARIO @endif
        deberá dejar un importe de <strong>{{ number_format($contrato->garantia, 2) }} bolivianos</strong> por concepto de garantía.
    @endif
</p>

<p>
    <strong>CUARTA.-</strong> Asimismo,
    @if($contrato->persona->genero === 'F') LA ARRENDATARIA está obligada @else EL ARRENDATARIO está obligado @endif
    a pagar puntualmente el importe de todos los servicios públicos,
    tales como agua y energía eléctrica, obligando a entregar el inmueble con sus cuentas al día.
</p>

<p>
    <strong>QUINTA.-</strong>
    @if($contrato->persona->genero === 'F') LA ARRENDATARIA queda prohibida @else EL ARRENDATARIO queda prohibido @endif
    de introducir mejoras, cambios o modificaciones internas y externas en el bien arrendado,
    sin el consentimiento expreso de
    @if($arrEsFemenino) LA ARRENDADORA @else EL ARRENDADOR @endif.
    Todas las mejoras serán en beneficio de
    @if($arrEsFemenino) LA ARRENDADORA @else EL ARRENDADOR @endif,
    sin obligación de pago alguno.
</p>

<p>
    <strong>SEXTA.-</strong>
    @if($contrato->persona->genero === 'F') LA ARRENDATARIA no podrá @else EL ARRENDATARIO no podrá @endif
    ceder a terceros el bien inmueble del presente contrato bajo ningún título de subarriendo,
    total o parcialmente, ni ceder su posición contractual, salvo que cuente con el consentimiento
    expreso y por escrito de
    @if($arrEsFemenino) LA ARRENDADORA @else EL ARRENDADOR @endif.
</p>

@if($contrato->fecha_fin)
<p class="clausula-titulo">CLÁUSULA DE RENOVACIÓN DE CONTRATO</p>
<p>
    <strong>SÉPTIMA.-</strong> Las partes acuerdan que la duración del presente contrato será desde
    <strong>{{ $contrato->fecha_inicio->format('d/m/Y') }}</strong> hasta
    <strong>{{ $contrato->fecha_fin->format('d/m/Y') }}</strong>.
    Para la entrega del inmueble por cualquiera de las dos partes se pacta un aviso con antelación de un mes antes de la fecha de vencimiento del contrato.
</p>
@endif
@endif

@if($contrato->notas)
<p class="clausula-titulo">DISPOSICIONES ADICIONALES:</p>
<p>{{ $contrato->notas }}</p>
@endif

<p style="margin-top: 20px;">
    En señal de conformidad, las partes suscriben el presente contrato en la ciudad de El Alto,
    a los <strong>{{ $contrato->fecha_inicio->format('d') }}</strong> días del mes de
    @php $meses = ['Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre']; @endphp
    <strong>{{ $meses[$contrato->fecha_inicio->month - 1] }}</strong>
    del año <strong>{{ $contrato->fecha_inicio->format('Y') }}</strong>.
</p>

<div class="firmas">
    <table>
        <tr>
            <td class="firma-linea">
                <strong>{{ strtoupper($arr->nombre_completo) }}</strong><br/>
                C.I. {{ $arrCI }}<br/>
                <small>{{ $arrEsFemenino ? 'LA ARRENDADORA' : 'EL ARRENDADOR' }}</small>
            </td>
            <td width="10%"></td>
            <td class="firma-linea">
                <strong>{{ strtoupper($contrato->persona->nombre_completo) }}</strong><br/>
                @if($contrato->persona->ci)
                    C.I. {{ $contrato->persona->ci }}{{ $contrato->persona->complemento ? ' '.$contrato->persona->complemento : '' }}{{ $contrato->persona->expedido ? ' '.$contrato->persona->expedido : '' }}<br/>
                @endif
                <small>{{ $contrato->persona->genero === 'F' ? 'LA ARRENDATARIA' : 'EL ARRENDATARIO' }}</small>
            </td>
        </tr>
    </table>
</div>

</body>
</html>
