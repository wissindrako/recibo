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
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;

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

        $globalSearch = AllowedFilter::callback('global', function ($query, $value) {
            $query->where(function ($query) use ($value) {
                Collection::wrap($value)->each(function ($value) use ($query) {
                    $query
                        ->orWhere('concepto', 'LIKE', "%{$value}%");
                });
            });
        });

        $mis_recibos = Recibo::orderBy('created_at');
        $mis_recibos->with(['cliente']);

        $recibos = QueryBuilder::for($mis_recibos)
        ->defaultSort('-created_at', 'updated_at')
        ->allowedSorts(['cantidad', 'concepto', 'created_at'])
        ->allowedFilters(['cantidad', 'concepto', 'created_at', $globalSearch])
        ->paginate()
        ->withQueryString();
        return view('recibo.index', [
            'recibos' => SpladeTable::for($recibos)
            ->withGlobalSearch()
            ->column('cliente.nombre_completo', label:'Cliente')
            ->column('fecha', sortable: true, searchable: true)
            ->column('cantidad_literal', sortable: true, searchable: true, label:'La suma de:')
            ->column('cantidad', sortable: true, searchable: true, label:'Monto')
            ->column('concepto', sortable: true, searchable: true)
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
        return view('recibo.create', compact('clientes'));
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

            $recibo = new Recibo();
            $recibo->nro_serie = Recibo::nextNumeroSerie();
            $recibo->hash = md5($request->fecha . $request->cliente_id);
            $recibo->cliente_id = $request->cliente_id;
            $recibo->fecha = $request->fecha;
            $recibo->cantidad = $request->cantidad;
            $recibo->cantidad_literal = $literal->toInvoice($request->cantidad, 2, 'Bs');
            $recibo->concepto = $request->concepto;

            $recibo->observaciones = $request->observaciones;
            $recibo->user_id = auth()->user()->id;

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

        // Conversion de Pulgadas a Puntos tipograficos
        // 4.251969 x 5.51181 pulg. = 306.1 x 396.85 puntos
        $carta_en_cuatro = array(0,0,306.1,396.85);

        if ($request->has('reporte')) {
            if ($request->reporte == 'pdf') {
                $pdf = Pdf::loadView('recibo.reporte', ['recibo' => $recibo])
                ->setPaper($carta_en_cuatro, 'landscape');
                return $pdf->stream('Recibo.pdf');
            } else {
                return view('recibo.reporte', compact('recibo'));
            }

        }
        return response()->json(['data' => $recibo], 200);
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
        $recibo = Recibo::findOrFail($id);
        return view('recibo.edit', compact('recibo', 'clientes'));
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
        $data = $request->validate([
            'cliente_id' => 'required|integer',
            'fecha' => 'required|date_format:Y-m-d',
            'cantidad' => 'numeric|min:0|max:9999999',
            'concepto' => 'required|max:240',
        ]);

        try {
            DB::beginTransaction();

            $literal = new NumberToWords();
            $literal->conector = ''; // ['y', 'con', '']

            $recibo = Recibo::findOrFail($id);
            $recibo->cliente_id = $request->cliente_id;
            $recibo->fecha = $request->fecha;
            $recibo->cantidad = $request->cantidad;
            $recibo->cantidad_literal = $literal->toInvoice($request->cantidad, 2, 'Bs');
            $recibo->concepto = $request->concepto;

            $recibo->observaciones = $request->observaciones;
            $recibo->user_id = auth()->user()->id;

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
