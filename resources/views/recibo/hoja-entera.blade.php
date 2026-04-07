<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recibo N° {{ $recibo->nro_serie }}</title>
    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Segoe UI', Arial, sans-serif;
            background: #f0f2f5;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 24px;
        }

        .recibo-wrapper {
            width: 100%;
            max-width: 680px;
        }

        .recibo-card {
            background: #fff;
            border-radius: 12px;
            box-shadow: 0 4px 24px rgba(0, 0, 0, 0.10);
            overflow: hidden;
        }

        /* Encabezado */
        .recibo-header {
            background: linear-gradient(135deg, #1e3a8a 0%, #2563eb 100%);
            color: #fff;
            padding: 24px 32px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .recibo-titulo {
            font-size: 32px;
            font-weight: 800;
            letter-spacing: 4px;
            text-transform: uppercase;
        }

        .recibo-meta {
            text-align: right;
        }

        .recibo-nro {
            font-size: 22px;
            font-weight: 700;
            letter-spacing: 1px;
        }

        .recibo-nro span {
            font-size: 13px;
            font-weight: 400;
            opacity: 0.75;
            display: block;
            margin-bottom: 2px;
        }

        .recibo-fecha {
            margin-top: 8px;
            font-size: 13px;
            opacity: 0.85;
        }

        .fecha-partes {
            display: inline-flex;
            gap: 12px;
            margin-top: 4px;
        }

        .fecha-parte {
            text-align: center;
        }

        .fecha-parte .valor {
            font-size: 18px;
            font-weight: 700;
            display: block;
        }

        .fecha-parte .etiqueta {
            font-size: 10px;
            opacity: 0.7;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        /* Badge de estado */
        .estado-badge {
            display: inline-block;
            padding: 3px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
            margin-top: 8px;
        }

        .estado-registrado {
            background: rgba(255, 255, 255, 0.2);
            color: #fff;
        }

        .estado-aprobado {
            background: #d1fae5;
            color: #065f46;
        }

        .estado-anulado {
            background: #fee2e2;
            color: #991b1b;
        }

        /* Cuerpo */
        .recibo-body {
            padding: 32px;
        }

        .campo {
            margin-bottom: 20px;
        }

        .campo-label {
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: #6b7280;
            margin-bottom: 4px;
        }

        .campo-valor {
            font-size: 16px;
            color: #111827;
            font-weight: 500;
            border-bottom: 1.5px dashed #e5e7eb;
            padding-bottom: 6px;
        }

        .campo-valor.cliente {
            font-size: 18px;
            font-weight: 700;
            color: #1e3a8a;
        }

        .campo-valor.concepto {
            font-size: 15px;
            line-height: 1.5;
            border-bottom: none;
            background: #f9fafb;
            border-radius: 8px;
            padding: 10px 14px;
            color: #374151;
        }

        .campo-valor.literal {
            font-style: italic;
            color: #374151;
            font-size: 14px;
        }

        /* Monto destacado */
        .monto-box {
            background: linear-gradient(135deg, #eff6ff, #dbeafe);
            border: 2px solid #93c5fd;
            border-radius: 10px;
            padding: 16px 24px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin: 24px 0;
        }

        .monto-label {
            font-size: 13px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: #1e40af;
        }

        .monto-valor {
            font-size: 30px;
            font-weight: 800;
            color: #1e3a8a;
        }

        .monto-moneda {
            font-size: 14px;
            font-weight: 600;
            color: #3b82f6;
            margin-right: 4px;
        }

        /* Observaciones */
        .observaciones {
            background: #fffbeb;
            border-left: 4px solid #f59e0b;
            border-radius: 0 8px 8px 0;
            padding: 10px 14px;
            font-size: 13px;
            color: #92400e;
            margin-bottom: 24px;
        }

        /* Firmas */
        .firmas {
            display: flex;
            gap: 24px;
            margin-top: 32px;
            padding-top: 24px;
            border-top: 1.5px dashed #e5e7eb;
        }

        .firma {
            flex: 1;
            text-align: center;
        }

        .firma-linea {
            border-top: 1.5px solid #9ca3af;
            margin-bottom: 8px;
            margin: 0 16px 8px 16px;
        }

        .firma-nombre {
            font-size: 13px;
            font-weight: 700;
            color: #1f2937;
        }

        .firma-rol {
            font-size: 11px;
            color: #6b7280;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-top: 2px;
        }

        /* Footer */
        .recibo-footer {
            background: #f9fafb;
            border-top: 1px solid #e5e7eb;
            padding: 14px 32px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .hash-text {
            font-size: 11px;
            color: #9ca3af;
            font-family: monospace;
            word-break: break-all;
        }

        .btn-print {
            display: inline-block;
            background: #2563eb;
            color: #fff;
            border: none;
            border-radius: 6px;
            padding: 8px 18px;
            font-size: 13px;
            font-weight: 600;
            cursor: pointer;
            text-decoration: none;
        }

        .btn-print:hover {
            background: #1d4ed8;
        }

        @media print {
            body {
                background: #fff;
                padding: 0;
            }

            .recibo-wrapper {
                max-width: 100%;
            }

            .recibo-card {
                box-shadow: none;
                border-radius: 0;
            }

            .btn-print {
                display: none;
            }
        }
    </style>
</head>

<body>

    @php
        $fecha = explode('-', $recibo->fecha);
        $estadoClase = match ($recibo->estado) {
            0 => 'estado-anulado',
            2 => 'estado-aprobado',
            default => 'estado-registrado',
        };
    @endphp

    <div class="recibo-wrapper">
        <div class="recibo-card">

            {{-- Encabezado --}}
            <div class="recibo-header">
                <div>
                    <div class="recibo-titulo">Recibo</div>
                    <span class="estado-badge {{ $estadoClase }}">{{ $recibo->estadoTexto }}</span>
                </div>
                <div class="recibo-meta">
                    <div class="recibo-nro">
                        <span>N°</span>
                        {{ $recibo->nro_serie }}
                    </div>
                    <div class="recibo-fecha">
                        <div class="fecha-partes">
                            <div class="fecha-parte">
                                <span class="valor">{{ $fecha[2] }}</span>
                                <span class="etiqueta">Día</span>
                            </div>
                            <div class="fecha-parte">
                                <span class="valor">{{ $fecha[1] }}</span>
                                <span class="etiqueta">Mes</span>
                            </div>
                            <div class="fecha-parte">
                                <span class="valor">{{ $fecha[0] }}</span>
                                <span class="etiqueta">Año</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Cuerpo --}}
            <div class="recibo-body">

                {{-- Cliente --}}
                <div class="campo">
                    <div class="campo-label">He recibido
                        de{{ $recibo->cliente->genero == 'M' ? 'l' : ($recibo->cliente->genero == 'F' ? ' la' : '') }}
                    </div>
                    <div class="campo-valor cliente">
                        {{ $recibo->cliente->titulo ? $recibo->cliente->titulo . ' ' : '' }}{{ $recibo->cliente->nombre_completo }}
                    </div>
                </div>

                {{-- Monto --}}
                <div class="monto-box">
                    <div>
                        <div class="monto-label">Total recibido</div>
                        <div class="campo-valor literal">{{ $recibo->cantidad_literal }}</div>
                    </div>
                    <div>
                        <span class="monto-moneda">Bs.</span>
                        <span class="monto-valor">{{ number_format($recibo->cantidad, 2) }}</span>
                    </div>
                </div>

                {{-- Concepto --}}
                <div class="campo">
                    <div class="campo-label">Por concepto de</div>
                    <div class="campo-valor concepto">{{ $recibo->concepto }}</div>
                </div>

                {{-- Observaciones --}}
                @if ($recibo->observaciones)
                    <div class="observaciones">
                        <strong>Observaciones:</strong> {{ $recibo->observaciones }}
                    </div>
                @endif

                {{-- Firmas --}}
                <div class="firmas">
                    <div class="firma">
                        <div class="firma-linea"></div>
                        <div class="firma-nombre">{{ $recibo->cliente->nombre_completo }}</div>
                        <div class="firma-rol">Entregado por</div>
                    </div>
                    <div class="firma">
                        <div class="firma-linea"></div>
                        <div class="firma-nombre">{{ $recibo->usuario->name }}</div>
                        <div class="firma-rol">Recibido por</div>
                    </div>
                </div>

            </div>

            {{-- Footer --}}
            <div class="recibo-footer">
                <span class="hash-text">{{ $recibo->hash }}</span>
                <button class="btn-print" onclick="window.print()">Imprimir</button>
            </div>

        </div>
    </div>

</body>

</html>
