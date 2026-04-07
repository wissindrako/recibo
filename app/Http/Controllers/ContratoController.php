<?php

namespace App\Http\Controllers;

use App\Models\Contrato;
use App\Models\Persona;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use ProtoneMedia\Splade\Facades\Splade;
use ProtoneMedia\Splade\SpladeTable;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;
use Barryvdh\DomPDF\Facade\Pdf;

class ContratoController extends Controller
{
    public function index()
    {
        $globalSearch = AllowedFilter::callback('global', function ($query, $value) {
            $query->where(function ($query) use ($value) {
                Collection::wrap($value)->each(function ($value) use ($query) {
                    $query
                        ->orWhere('descripcion_bien', 'LIKE', "%{$value}%")
                        ->orWhere('tipo', 'LIKE', "%{$value}%")
                        ->orWhereHas('arrendador', function ($q) use ($value) {
                            $q->where('nombre', 'LIKE', "%{$value}%");
                        })
                        ->orWhereHas('persona', function ($q) use ($value) {
                            $q->where('nombres', 'LIKE', "%{$value}%")
                              ->orWhere('ap_paterno', 'LIKE', "%{$value}%")
                              ->orWhere('ap_materno', 'LIKE', "%{$value}%");
                        });
                });
            });
        });

        $query = Contrato::with('persona')->orderBy('created_at', 'desc');

        $contratos = QueryBuilder::for($query)
            ->defaultSort('-created_at')
            ->allowedSorts(['tipo', 'fecha_inicio', 'fecha_fin', 'monto'])
            ->allowedFilters(['tipo', $globalSearch])
            ->paginate()
            ->withQueryString();

        return view('contrato.index', [
            'contratos' => SpladeTable::for($contratos)
                ->withGlobalSearch()
                ->column(key: 'nro_serie', label: 'Nº')
                ->column('tipo', label: 'Tipo', sortable: true)
                ->column('persona.nombre_completo', label: 'Persona')
                ->column('fecha_inicio', label: 'Inicio', sortable: true)
                ->column('fecha_fin', label: 'Fin', sortable: true)
                ->column('monto', label: 'Monto Bs.', sortable: true)
                ->column('estado', label: 'Estado')
                ->column('action', label: 'Acciones'),
        ]);
    }

    public function create()
    {
        $personas = $this->getPersonasClientes();
        $arrendadores = $this->getArrendadoresActivos();
        $ultimo = Contrato::orderBy('created_at', 'desc')->first();
        return view('contrato.create', compact('personas', 'arrendadores', 'ultimo'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'tipo'               => 'required|in:alquiler,venta,otro',
            'arrendador_id'      => 'required|integer|exists:users,id',
            'persona_id'         => 'required|integer|exists:personas,id',
            'descripcion_inmueble'  => 'required|string',
            'descripcion_alquiler'  => 'required|string',
            'fecha_inicio'       => 'required|date',
            'fecha_fin'          => 'nullable|date|after_or_equal:fecha_inicio',
            'monto'              => 'required|numeric|min:0',
            'garantia'           => 'nullable|numeric|min:0',
            'dia_limite_pago'    => 'nullable|integer|min:1|max:31',
            'notas'              => 'nullable|string',
            'contrato_origen_id' => 'nullable|integer|exists:contratos,id',
            'archivo'            => 'nullable|file|mimes:pdf,doc,docx|max:10240',
        ]);

        try {
            DB::beginTransaction();

            $contrato = new Contrato();
            $contrato->nro_serie         = Contrato::nextNumeroSerie();
            $contrato->tipo              = $request->tipo;
            $contrato->arrendador_id     = $request->arrendador_id;
            $contrato->persona_id        = $request->persona_id;
            $contrato->descripcion_inmueble = $request->descripcion_inmueble;
            $contrato->descripcion_alquiler = $request->descripcion_alquiler;
            $contrato->fecha_inicio      = $request->fecha_inicio;
            $contrato->fecha_fin         = $request->fecha_fin;
            $contrato->monto             = $request->monto;
            $contrato->garantia          = $request->garantia;
            $contrato->dia_limite_pago   = $request->dia_limite_pago;
            $contrato->notas             = $request->notas;
            $contrato->contrato_origen_id = $request->contrato_origen_id;
            $contrato->estado            = 1;
            $contrato->user_id           = auth()->user()->id;

            if ($request->hasFile('archivo')) {
                $path = $request->file('archivo')->store('contratos', 'public');
                $contrato->archivo = $path;
            }

            $contrato->save();

            DB::commit();

            Splade::toast('Contrato creado correctamente!')->autoDismiss(5);
            return redirect()->route('contratos');
        } catch (\Throwable $th) {
            DB::rollBack();
            return $th;
        }
    }

    public function show($id, Request $request)
    {
        $contrato = Contrato::with(['arrendador.persona', 'persona', 'usuario', 'contratoOrigen'])->findOrFail($id);

        if ($request->reporte === 'pdf') {
            $pdf = Pdf::loadView('contrato.reporte', compact('contrato'))
                ->setPaper('letter', 'portrait');
            $pdf->render();
            return $pdf->stream('Contrato-' . $contrato->nro_serie . '.pdf', ['Attachment' => false]);
        }

        return view('contrato.show', compact('contrato'));
    }

    public function edit($id)
    {
        $personas = $this->getPersonasClientes();
        $arrendadores = $this->getArrendadoresActivos();
        $contrato = Contrato::findOrFail($id);
        return view('contrato.edit', compact('contrato', 'personas', 'arrendadores'));
    }

    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'tipo'               => 'required|in:alquiler,venta,otro',
            'arrendador_id'      => 'required|integer|exists:users,id',
            'persona_id'         => 'required|integer|exists:personas,id',
            'descripcion_inmueble'  => 'required|string',
            'descripcion_alquiler'  => 'required|string',
            'fecha_inicio'       => 'required|date',
            'fecha_fin'          => 'nullable|date|after_or_equal:fecha_inicio',
            'monto'              => 'required|numeric|min:0',
            'garantia'           => 'nullable|numeric|min:0',
            'dia_limite_pago'    => 'nullable|integer|min:1|max:31',
            'notas'              => 'nullable|string',
            'archivo'            => 'nullable|file|mimes:pdf,doc,docx|max:10240',
        ]);

        try {
            DB::beginTransaction();

            $contrato = Contrato::findOrFail($id);
            $contrato->tipo              = $request->tipo;
            $contrato->arrendador_id     = $request->arrendador_id;
            $contrato->persona_id        = $request->persona_id;
            $contrato->descripcion_inmueble = $request->descripcion_inmueble;
            $contrato->descripcion_alquiler = $request->descripcion_alquiler;
            $contrato->fecha_inicio      = $request->fecha_inicio;
            $contrato->fecha_fin         = $request->fecha_fin;
            $contrato->monto             = $request->monto;
            $contrato->garantia          = $request->garantia;
            $contrato->dia_limite_pago   = $request->dia_limite_pago;
            $contrato->notas             = $request->notas;

            if ($request->hasFile('archivo')) {
                if ($contrato->archivo) {
                    Storage::disk('public')->delete($contrato->archivo);
                }
                $path = $request->file('archivo')->store('contratos', 'public');
                $contrato->archivo = $path;
            }

            $contrato->save();

            DB::commit();

            Splade::toast('Contrato actualizado correctamente!')->autoDismiss(5);
            return redirect()->route('contratos');
        } catch (\Throwable $th) {
            DB::rollBack();
            return $th;
        }
    }

    private function getArrendadoresActivos()
    {
        return User::role('arrendador')
            ->with('persona')
            ->get();
    }

    private function getPersonasClientes()
    {
        return Persona::whereDoesntHave('user', fn($q) => $q->role('arrendador'))
            ->orWhereNull('user_id')
            ->orderBy('ap_paterno')
            ->get();
    }

    public function anular($id)
    {
        $contrato = Contrato::findOrFail($id);
        $contrato->estado = 0;
        $contrato->save();
        Splade::toast('Contrato anulado.')->autoDismiss(5);
        return redirect()->route('contratos');
    }

    public function renovar($id)
    {
        $personas = $this->getPersonasClientes();
        $arrendadores = $this->getArrendadoresActivos();
        $origen = Contrato::with('persona')->findOrFail($id);
        return view('contrato.create', [
            'personas'    => $personas,
            'arrendadores'=> $arrendadores,
            'ultimo'      => null,
            'origen'      => $origen,
        ]);
    }
}
