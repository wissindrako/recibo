<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contrato #{{ $contrato->nro_serie }}</title>
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            font-family: 'Segoe UI', Arial, sans-serif;
            background: #f0f2f5;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 24px;
        }

        .wrapper {
            width: 100%;
            max-width: 780px;
        }

        /* Barra de acciones superior */
        .topbar {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 16px;
            flex-wrap: wrap;
            gap: 8px;
        }

        .topbar a {
            font-size: 13px;
            color: #6b7280;
            text-decoration: none;
        }

        .topbar a:hover { color: #1f2937; }

        .actions {
            display: flex;
            gap: 8px;
            flex-wrap: wrap;
        }

        .btn {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 7px 16px;
            border-radius: 6px;
            font-size: 13px;
            font-weight: 600;
            text-decoration: none;
            cursor: pointer;
            border: none;
        }

        .btn-primary  { background: #2563eb; color: #fff; }
        .btn-primary:hover  { background: #1d4ed8; }
        .btn-success  { background: #059669; color: #fff; }
        .btn-success:hover  { background: #047857; }
        .btn-secondary { background: #e5e7eb; color: #374151; }
        .btn-secondary:hover { background: #d1d5db; }
        .btn-danger   { background: #dc2626; color: #fff; }
        .btn-danger:hover   { background: #b91c1c; }

        /* Card principal */
        .card {
            background: #fff;
            border-radius: 12px;
            box-shadow: 0 4px 24px rgba(0,0,0,.10);
            overflow: hidden;
            margin-bottom: 16px;
        }

        /* Header */
        .card-header {
            background: linear-gradient(135deg, #1e3a8a 0%, #2563eb 100%);
            color: #fff;
            padding: 24px 32px;
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            gap: 16px;
        }

        .contrato-titulo {
            font-size: 28px;
            font-weight: 800;
            letter-spacing: 3px;
            text-transform: uppercase;
        }

        .contrato-subtitulo {
            font-size: 13px;
            opacity: .75;
            margin-top: 4px;
        }

        .header-meta { text-align: right; }

        .nro-serie span { font-size: 11px; opacity: .7; display: block; }
        .nro-serie strong { font-size: 24px; font-weight: 700; }

        .badge {
            display: inline-block;
            padding: 3px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
            margin-top: 8px;
        }

        .badge-vigente  { background: #d1fae5; color: #065f46; }
        .badge-vencido  { background: #fef3c7; color: #92400e; }
        .badge-anulado  { background: #fee2e2; color: #991b1b; }
        .badge-tipo     { background: rgba(255,255,255,.2); color: #fff; margin-left: 6px; }

        /* Secciones */
        .card-body { padding: 28px 32px; }

        .section { margin-bottom: 24px; }
        .section:last-child { margin-bottom: 0; }

        .section-title {
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: #6b7280;
            margin-bottom: 12px;
            padding-bottom: 6px;
            border-bottom: 1px solid #f3f4f6;
        }

        /* Partes */
        .partes-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
        }

        .parte-card {
            background: #f9fafb;
            border-radius: 8px;
            padding: 16px;
            border-left: 4px solid #2563eb;
        }

        .parte-card.arrendatario { border-left-color: #059669; }

        .parte-rol {
            font-size: 10px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: #6b7280;
            margin-bottom: 6px;
        }

        .parte-nombre {
            font-size: 16px;
            font-weight: 700;
            color: #1e3a8a;
        }

        .parte-nombre.verde { color: #065f46; }

        .parte-ci {
            font-size: 13px;
            color: #6b7280;
            margin-top: 4px;
        }

        /* Descripción */
        .desc-box {
            background: #f9fafb;
            border-radius: 8px;
            padding: 14px 16px;
            margin-bottom: 12px;
        }

        .desc-box:last-child { margin-bottom: 0; }

        .desc-label {
            font-size: 10px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: #9ca3af;
            margin-bottom: 6px;
        }

        .desc-text {
            font-size: 14px;
            color: #374151;
            line-height: 1.6;
        }

        .desc-text.destacado {
            font-size: 15px;
            font-weight: 600;
            color: #1e3a8a;
        }

        /* Condiciones */
        .condiciones-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 16px;
        }

        .condicion-item { text-align: center; }

        .condicion-label {
            font-size: 10px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: #9ca3af;
            margin-bottom: 4px;
        }

        .condicion-valor {
            font-size: 18px;
            font-weight: 700;
            color: #1f2937;
        }

        .condicion-valor.monto {
            font-size: 26px;
            color: #1e3a8a;
        }

        /* Monto box */
        .monto-box {
            background: linear-gradient(135deg, #eff6ff, #dbeafe);
            border: 2px solid #93c5fd;
            border-radius: 10px;
            padding: 16px 24px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-top: 16px;
        }

        .monto-sub {
            font-size: 12px;
            color: #3b82f6;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .monto-valor {
            font-size: 32px;
            font-weight: 800;
            color: #1e3a8a;
        }

        .monto-moneda {
            font-size: 14px;
            color: #3b82f6;
            font-weight: 600;
            margin-right: 4px;
        }

        /* Garantía */
        .garantia-row {
            display: flex;
            gap: 20px;
            margin-top: 12px;
        }

        .garantia-item {
            background: #fafafa;
            border: 1px solid #e5e7eb;
            border-radius: 8px;
            padding: 10px 16px;
        }

        /* Notas */
        .notas-box {
            background: #fffbeb;
            border-left: 4px solid #f59e0b;
            border-radius: 0 8px 8px 0;
            padding: 14px 16px;
            font-size: 13px;
            color: #92400e;
            line-height: 1.6;
        }

        /* Renovación */
        .renovacion-link {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            font-size: 13px;
            color: #2563eb;
            text-decoration: none;
            font-weight: 600;
        }

        /* Footer */
        .card-footer {
            background: #f9fafb;
            border-top: 1px solid #e5e7eb;
            padding: 12px 32px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            font-size: 12px;
            color: #9ca3af;
        }

        .divider {
            border: none;
            border-top: 1px solid #f3f4f6;
            margin: 20px 0;
        }

        @media(max-width: 600px) {
            .partes-grid { grid-template-columns: 1fr; }
            .condiciones-grid { grid-template-columns: repeat(2, 1fr); }
            .card-header { flex-direction: column; }
            .header-meta { text-align: left; }
        }

        @media print {
            body { background: #fff; padding: 0; }
            .topbar { display: none; }
            .card { box-shadow: none; border-radius: 0; }
        }
    </style>
</head>
<body>

@php
    $estado = $contrato->calcularEstado();
    $estadoClase = match($estado) { 1 => 'badge-vigente', 2 => 'badge-vencido', default => 'badge-anulado' };
    $estadoTexto = match($estado) { 1 => 'Vigente', 2 => 'Vencido', default => 'Anulado' };
    $meses = ['Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre'];
@endphp

<div class="wrapper">

    {{-- Topbar --}}
    <div class="topbar">
        <a href="{{ route('contratos') }}">← Volver a contratos</a>
        <div class="actions">
            <a href="{{ route('contrato.show', [$contrato->getRouteKey(), 'reporte' => 'pdf']) }}" target="_blank" class="btn btn-primary">
                ↓ Descargar PDF
            </a>
            @if($contrato->archivo)
            <a href="{{ route('contrato.edit', $contrato) }}#archivos" class="btn btn-secondary">
                📎 {{ count($contrato->archivo) }} documento(s)
            </a>
            @endif
            @if($estado !== 0)
            <a href="{{ route('contrato.edit', $contrato) }}" class="btn btn-secondary">
                ✏ Editar
            </a>
            <a href="{{ route('contrato.renovar', $contrato) }}" class="btn btn-success">
                ↺ Renovar
            </a>
            @endif
        </div>
    </div>

    <div class="card">

        {{-- Header --}}
        <div class="card-header">
            <div>
                <div class="contrato-titulo">Contrato</div>
                <div class="contrato-subtitulo">
                    <span class="badge {{ $estadoClase }}">{{ $estadoTexto }}</span>
                    <span class="badge badge-tipo">{{ $contrato->tipoTexto }}</span>
                </div>
            </div>
            <div class="header-meta">
                <div class="nro-serie">
                    <span>N°</span>
                    <strong>{{ $contrato->nro_serie }}</strong>
                </div>
                <div style="font-size:13px; opacity:.8; margin-top:6px;">
                    {{ $meses[$contrato->fecha_inicio->month - 1] }} {{ $contrato->fecha_inicio->format('Y') }}
                </div>
            </div>
        </div>

        <div class="card-body">

            {{-- Partes --}}
            <div class="section">
                <div class="section-title">Partes del contrato</div>
                <div class="partes-grid">
                    <div class="parte-card">
                        <div class="parte-rol">Arrendador / Propietario</div>
                        <div class="parte-nombre">
                            {{ $contrato->arrendador?->persona?->titulo }}
                            {{ $contrato->arrendador?->persona?->nombre_completo ?? $contrato->arrendador?->name }}
                        </div>
                        @if($contrato->arrendador?->persona?->ci)
                        <div class="parte-ci">
                            C.I. {{ $contrato->arrendador->persona->ci }}
                            {{ $contrato->arrendador->persona->complemento }}
                            {{ $contrato->arrendador->persona->expedido }}
                        </div>
                        @endif
                        @if($contrato->arrendador?->persona?->domicilio)
                        <div class="parte-ci">{{ $contrato->arrendador->persona->domicilio }}</div>
                        @endif
                    </div>
                    <div class="parte-card arrendatario">
                        <div class="parte-rol">Arrendatario / Contratante</div>
                        <div class="parte-nombre verde">{{ $contrato->persona->nombre_completo }}</div>
                        @if($contrato->persona->ci)
                        <div class="parte-ci">
                            C.I. {{ $contrato->persona->ci }}
                            {{ $contrato->persona->complemento }}
                            {{ $contrato->persona->expedido }}
                        </div>
                        @endif
                        @if($contrato->persona->telefono)
                        <div class="parte-ci">Tel. {{ $contrato->persona->telefono }}</div>
                        @endif
                    </div>
                </div>
            </div>

            <hr class="divider"/>

            {{-- Inmueble --}}
            <div class="section">
                <div class="section-title">Objeto del contrato</div>
                @if($contrato->inmueble)
                <div class="desc-box">
                    <div class="desc-label">Inmueble</div>
                    <div class="desc-text">{{ $contrato->inmueble->nombre }}</div>
                </div>
                <div class="desc-box">
                    <div class="desc-label">Tipo</div>
                    <div class="desc-text">{{ $contrato->inmueble->patrimonio }}</div>
                </div>
                <div class="desc-box">
                    <div class="desc-label">Ubicación</div>
                    <div class="desc-text">{{ $contrato->inmueble->ubicacion }}</div>
                </div>
                @if($contrato->inmueble->descripcion)
                <div class="desc-box">
                    <div class="desc-label">Descripción</div>
                    <div class="desc-text">{{ $contrato->inmueble->descripcion }}</div>
                </div>
                @endif
                @if(!empty($contrato->inmueble->servicios))
                <div class="desc-box">
                    <div class="desc-label">Servicios</div>
                    <div class="desc-text">{{ implode(', ', $contrato->inmueble->servicios) }}</div>
                </div>
                @endif
                @endif
                @if($contrato->descripcion_alquiler)
                @php
                    $etiquetasSvcs = ['agua'=>'agua','luz'=>'luz','gas'=>'gas domiciliario','alcantarillado'=>'alcantarillado','internet'=>'internet'];
                    $svcsCont = is_array($contrato->servicios_contrato) ? $contrato->servicios_contrato : [];
                    $svcsTexto = !empty($svcsCont)
                        ? ' con servicios de ' . implode(', ', array_map(fn($s) => $etiquetasSvcs[$s] ?? $s, $svcsCont))
                        : '';
                @endphp
                <div class="desc-box">
                    <div class="desc-label">Lo que se {{ $contrato->tipo === 'venta' ? 'vende' : 'alquila' }}</div>
                    <div class="desc-text destacado">{{ $contrato->descripcion_alquiler }}{{ $svcsTexto }}</div>
                </div>
                @endif
            </div>

            <hr class="divider"/>

            {{-- Condiciones --}}
            <div class="section">
                <div class="section-title">Condiciones</div>
                <div class="condiciones-grid">
                    <div class="condicion-item">
                        <div class="condicion-label">Fecha inicio</div>
                        <div class="condicion-valor">{{ $contrato->fecha_inicio->format('d/m/Y') }}</div>
                    </div>
                    <div class="condicion-item">
                        <div class="condicion-label">Fecha fin</div>
                        <div class="condicion-valor">
                            {{ $contrato->fecha_fin ? $contrato->fecha_fin->format('d/m/Y') : '—' }}
                        </div>
                    </div>
                    @if($contrato->dia_limite_pago)
                    <div class="condicion-item">
                        <div class="condicion-label">Límite de pago</div>
                        <div class="condicion-valor">Día {{ $contrato->dia_limite_pago }}</div>
                    </div>
                    @endif
                    @if(!is_null($contrato->garantia))
                    <div class="condicion-item">
                        <div class="condicion-label">Garantía Bs.</div>
                        <div class="condicion-valor">
                            @if($contrato->garantia > 0)
                                {{ number_format($contrato->garantia, 2) }}
                            @else
                                <span style="font-size:13px; color:#6b7280;">Sin garantía</span>
                            @endif
                        </div>
                    </div>
                    @endif
                </div>

                <div class="monto-box">
                    <div>
                        <div class="monto-sub">Monto {{ $contrato->tipo === 'alquiler' ? 'mensual' : 'total' }}</div>
                    </div>
                    <div>
                        <span class="monto-moneda">Bs.</span>
                        <span class="monto-valor">{{ number_format($contrato->monto, 2) }}</span>
                    </div>
                </div>
            </div>

            {{-- Notas --}}
            @if($contrato->notas)
            <hr class="divider"/>
            <div class="section">
                <div class="section-title">Cláusulas adicionales</div>
                <div class="notas-box">{{ $contrato->notas }}</div>
            </div>
            @endif

            {{-- Renovación --}}
            @if($contrato->contratoOrigen)
            <hr class="divider"/>
            <div class="section">
                <div class="section-title">Historial</div>
                <a href="{{ route('contrato.show', $contrato->contratoOrigen) }}" class="renovacion-link">
                    ↩ Renovación del contrato #{{ $contrato->contratoOrigen->nro_serie }}
                </a>
            </div>
            @endif

        </div>

        {{-- Footer --}}
        <div class="card-footer">
            <span>Contrato #{{ $contrato->nro_serie }} · {{ $contrato->tipoTexto }}</span>
            <span>
                Registrado por <strong>{{ $contrato->usuario->name ?? '-' }}</strong>
                · {{ $contrato->created_at->format('d/m/Y H:i') }}
            </span>
        </div>

    </div>
</div>

</body>
</html>
