<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Persona;
use App\Models\Recibo;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('role:admin');
    }

    public function __invoke()
    {
        $hoy        = Carbon::today();
        $inicioMes  = $hoy->copy()->startOfMonth();
        $inicioMesAnterior = $hoy->copy()->subMonth()->startOfMonth();
        $finMesAnterior    = $hoy->copy()->subMonth()->endOfMonth();

        // ── FINANCIERO ────────────────────────────────────────────────
        $totalRecaudado = Recibo::where('estado', 2)->sum('cantidad');

        $recaudadoEsteMes = Recibo::where('estado', 2)
            ->whereMonth('fecha', $hoy->month)
            ->whereYear('fecha', $hoy->year)
            ->sum('cantidad');

        $recaudadoMesAnterior = Recibo::where('estado', 2)
            ->whereBetween('fecha', [$inicioMesAnterior, $finMesAnterior])
            ->sum('cantidad');

        $variacionMes = $recaudadoMesAnterior > 0
            ? round((($recaudadoEsteMes - $recaudadoMesAnterior) / $recaudadoMesAnterior) * 100, 1)
            : null;

        $promedioRecibo = Recibo::where('estado', 2)->avg('cantidad') ?? 0;

        $mayorRecibo = Recibo::with('cliente')
            ->where('estado', 2)
            ->orderByDesc('cantidad')
            ->first();

        // ── RECIBOS ───────────────────────────────────────────────────
        $totalRecibos    = Recibo::count();
        $aprobados       = Recibo::where('estado', 2)->count();
        $registrados     = Recibo::where('estado', 1)->count();
        $anulados        = Recibo::where('estado', 0)->count();
        $emitidosEsteMes = Recibo::whereMonth('created_at', $hoy->month)
            ->whereYear('created_at', $hoy->year)
            ->count();

        $tasaAprobacion = $totalRecibos > 0
            ? round(($aprobados / $totalRecibos) * 100, 1)
            : 0;

        // Tendencia últimos 6 meses (agrupado por mes)
        $tendencia = Recibo::selectRaw("DATE_FORMAT(fecha, '%Y-%m') as mes, COUNT(*) as total, SUM(cantidad) as monto")
            ->where('estado', 2)
            ->where('fecha', '>=', $hoy->copy()->subMonths(5)->startOfMonth())
            ->groupByRaw("DATE_FORMAT(fecha, '%Y-%m')")
            ->orderBy('mes')
            ->get()
            ->map(fn($r) => [
                'mes'   => Carbon::createFromFormat('Y-m', $r->mes)->translatedFormat('M Y'),
                'total' => $r->total,
                'monto' => $r->monto,
            ]);

        // ── MORA ─────────────────────────────────────────────────────
        // Clientes con recibos en estado=1 (Registrado) cuya fecha es anterior al mes actual
        $enMora = Persona::select('personas.*')
            ->join('recibos', 'recibos.cliente_id', '=', 'personas.id')
            ->where('recibos.estado', 1)
            ->where('recibos.fecha', '<', $inicioMes)
            ->groupBy('personas.id')
            ->with(['recibos' => fn($q) => $q->where('estado', 1)->where('fecha', '<', $inicioMes)])
            ->get()
            ->map(function ($persona) use ($hoy) {
                $pendientes     = $persona->recibos;
                $totalPendiente = $pendientes->sum('cantidad');
                $fechaMasAntigua = $pendientes->min('fecha');
                $diasMora       = Carbon::parse($fechaMasAntigua)->diffInDays($hoy);
                return [
                    'persona'        => $persona,
                    'total_pendiente'=> $totalPendiente,
                    'cantidad'       => $pendientes->count(),
                    'dias_mora'      => $diasMora,
                    'fecha_mas_antigua' => $fechaMasAntigua,
                ];
            })
            ->sortByDesc('dias_mora')
            ->values();

        return view('admin.dashboard', compact(
            'totalRecaudado', 'recaudadoEsteMes', 'recaudadoMesAnterior',
            'variacionMes', 'promedioRecibo', 'mayorRecibo',
            'totalRecibos', 'aprobados', 'registrados', 'anulados',
            'emitidosEsteMes', 'tasaAprobacion', 'tendencia', 'enMora'
        ));
    }
}
