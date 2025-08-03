<?php

namespace App\Http\Controllers;

use App\Models\Persona;
use App\Models\Recibo;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use ProtoneMedia\Splade\Facades\Splade;
use ProtoneMedia\Splade\SpladeTable;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

use App\Helpers\NumberToWords;
use App\Helpers\FormatoFecha;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use chillerlan\QRCode\QRCode;
use chillerlan\QRCode\QROptions;

class ReciboController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user_id = auth()->user()->id;

        // dd(DB::table('personas')
        // ->select('nombres')
        // ->first()
        // );

        $globalSearch = AllowedFilter::callback('global', function ($query, $value) {
            $query->where(function ($query) use ($value) {
                Collection::wrap($value)->each(function ($value) use ($query) {
                    $query
                        ->orWhere('concepto', 'LIKE', "%{$value}%")
                        ->orWhere('cantidad', '=', "{$value}")
                        ->orWhere(
                            'cliente_id',
                            function ($subquery) use ($value) {
                                $subquery
                                    ->select('id')
                                    ->from('personas')
                                    ->where('nombres', 'LIKE', "%{$value}%")
                                    ->orWhere('ap_paterno', 'LIKE', "%{$value}%")
                                    ->orWhere('ap_materno', 'LIKE', "%{$value}%")
                                    ->first();
                            }
                        );
                });
            });
        });

        $mis_recibos = Recibo::orderBy('created_at', 'desc');
        $mis_recibos->with(['cliente']);

        $fecha = new FormatoFecha();

        $recibos = QueryBuilder::for($mis_recibos)
            ->defaultSort('created_at', 'updated_at')
            ->allowedSorts(['cantidad', 'concepto', 'created_at'])
            ->allowedFilters(['cantidad', 'concepto', 'created_at', $globalSearch])
            ->paginate()
            ->withQueryString();
        return view('recibo.index', [
            'recibos' => SpladeTable::for($recibos)
                ->withGlobalSearch()
                ->column(key: 'key', label: 'Nº')
                ->column('cliente.nombre_completo', searchable: true, label: 'Cliente')
                //->column('fecha', sortable: false, searchable: true)
                ->column(
                    key: 'fecha',
                    as: fn($email) => $fecha->fecha_dmy($email),
                    label: 'Fecha pago'
                )
                ->column('cantidad', sortable: true, searchable: true, label: 'Monto')
                ->column('concepto', sortable: true, searchable: true)
                ->column('estado', sortable: true, searchable: true)
                ->column('action')
            // ->rowLink(function(User $user){
            //     return route('users.show', $user);
            // })
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $clientes = Persona::get();
        $usuarios = User::get();
        return view('recibo.create', compact('clientes', 'usuarios'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'cliente_id' => 'required|integer',
            'fecha' => 'required|date_format:Y-m-d',
            'cantidad' => 'numeric|min:0|max:9999999',
            'concepto' => 'required|max:240',
        ]);

        try {
            DB::beginTransaction();

            $literal = new NumberToWords();

            $nro_serie = Recibo::nextNumeroSerie();

            $recibo = new Recibo();
            $recibo->nro_serie = $nro_serie;
            $recibo->hash = md5($nro_serie . $request->fecha . $request->cliente_id . $request->cantidad . $request->concepto);
            $recibo->cliente_id = $request->cliente_id;
            $recibo->fecha = $request->fecha;
            $recibo->cantidad = $request->cantidad;
            $recibo->cantidad_literal = $literal->toInvoice($request->cantidad, 2, 'Bs');
            $recibo->concepto = $request->concepto;

            $recibo->observaciones = $request->observaciones;

            if ($request->user_id) {
                $recibo->user_id = $request->user_id;
            } else {
                $recibo->user_id = auth()->user()->id;
            }

            $recibo->save();

            DB::commit();

            Splade::toast('Recibo creado correctamente!')->autoDismiss(5);

            return redirect()->route('recibos');
        } catch (\Throwable $th) {
            DB::rollBack();
            return $th;
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Recibo  $recibo
     * @return \Illuminate\Http\Response
     */
    public function show($id, Request $request)
    {
        $recibo = Recibo::findOrFail($id);
        $recibo->load(['usuario', 'cliente']);

        // return Pdf::loadView('recibo.reporte', ['recibo' => $recibo])->save(public_path().'/myfile.pdf')->stream('download.pdf', array("Attachment" => 0));

        // Conversion de Pulgadas a Puntos tipograficos
        // 4.251969 x 5.51181 pulg. = 306.1 x 396.85 puntos
        $carta_en_cuatro = array(0, 0, 306.1, 396.85);

        // URL de verificación
        $url = url('/verificar/' . $recibo->hash);

        // Generar QR en base64 usando chillerlan/php-qrcode
        $options = new QROptions([
            'outputType' => QRCode::OUTPUT_IMAGE_PNG,
            'scale' => 4, // tamaño del QR
            'imageBase64' => false,
        ]);
        $qr = (new QRCode($options))->render($url);
        $qr_base64 = 'data:image/png;base64,' . base64_encode($qr);

        if ($request->has('reporte')) {
            if ($request->reporte == 'pdf') {
                // ob_end_clean();
                $pdf = Pdf::loadView('recibo.reporte', ['recibo' => $recibo])
                    ->setPaper($carta_en_cuatro, 'landscape');
                $pdf->render();
                return $pdf->stream('Recibo.pdf', array("Attachment" => false));
            } elseif ($request->reporte == 'pdf-codigo') {
                $pdf = Pdf::loadView('recibo.reporte-codigo', [
                    'recibo' => $recibo,
                    'qr_base64' => $qr_base64
                ])->setPaper($carta_en_cuatro, 'landscape');
                $pdf->render();
                return $pdf->stream('Recibo.pdf', array("Attachment" => false));
            } else {
                return view('recibo.show', compact('recibo'));
            }
        }
        return response()->json(['data' => $recibo], 200);
    }

    /**
     * Verifica un recibo por hash y muestra información básica.
     */
    public function verificar($hash)
    {
        $recibo = Recibo::where('hash', $hash)->with(['cliente'])->first();
        if (!$recibo) {
            abort(404, 'Recibo no encontrado');
        }
        return view('recibo.verificar', compact('recibo'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Recibo  $recibo
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $clientes = Persona::get();
        $usuarios = User::get();
        $recibo = Recibo::findOrFail($id);
        return view('recibo.edit', compact('recibo', 'clientes', 'usuarios'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Recibo  $recibo
     * @return \Illuminate\Http\Response
     */
    public function editEstado($id)
    {
        // Solo admin puede acceder
        if (!auth()->user() || !auth()->user()->hasRole('admin')) {
            abort(403, 'No autorizado para esta acción.');
        }
        $recibo = Recibo::findOrFail($id);
        $recibo->estado = $recibo->estado == 1 ? 2 : 1;
        $recibo->update();
        Splade::toast('Estado del recibo actualizado correctamente!')->autoDismiss(5);
        return redirect()->route('recibos');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Recibo  $recibo
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        if (!auth()->user() || !auth()->user()->hasRole('admin')) {
            abort(403, 'No autorizado para esta acción.');
        }
        $data = $request->validate([
            'cliente_id' => 'required|integer',
            'fecha' => 'required|date_format:Y-m-d',
            'cantidad' => 'numeric|min:0|max:9999999',
            'concepto' => 'required|max:240',
        ]);

        try {
            DB::beginTransaction();

            $literal = new NumberToWords();
            $literal->conector = 'con'; // ['y', 'con', ''] default 'con'

            $recibo = Recibo::findOrFail($id);
            $recibo->cliente_id = $request->cliente_id;
            $recibo->hash = md5($recibo->nro_serie . $request->fecha . $request->cliente_id . $request->cantidad . $request->concepto);
            $recibo->fecha = $request->fecha;
            $recibo->cantidad = $request->cantidad;
            $recibo->cantidad_literal = $literal->toInvoice($request->cantidad, 2, 'Bs');
            $recibo->concepto = $request->concepto;

            $recibo->observaciones = $request->observaciones;

            if ($request->user_id) {
                $recibo->user_id = $request->user_id;
            } else {
                $recibo->user_id = auth()->user()->id;
            }

            $recibo->update();

            DB::commit();

            Splade::toast('Recibo actualizado correctamente!')->autoDismiss(5);

            return redirect()->route('recibos');
        } catch (\Throwable $th) {
            DB::rollBack();
            return $th;
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Recibo  $recibo
     * @return \Illuminate\Http\Response
     */
    public function destroy(Recibo $recibo)
    {
        //
    }
}
