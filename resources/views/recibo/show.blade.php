<x-empty>
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

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    {{-- Materia: <b>{{$materia->nombre}}</b> --}}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
