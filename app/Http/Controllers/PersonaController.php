<?php

namespace App\Http\Controllers;

use App\Models\Persona;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use ProtoneMedia\Splade\Facades\Splade;
use ProtoneMedia\Splade\SpladeTable;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class PersonaController extends Controller
{
    public function index()
    {
        $globalSearch = AllowedFilter::callback('global', function ($query, $value) {
            $query->where(function ($query) use ($value) {
                Collection::wrap($value)->each(function ($value) use ($query) {
                    $query
                        ->orWhere('nombres', 'LIKE', "%{$value}%")
                        ->orWhere('ap_paterno', 'LIKE', "%{$value}%")
                        ->orWhere('ap_materno', 'LIKE', "%{$value}%");
                });
            });
        });

        $personas = QueryBuilder::for(Persona::class)
        ->defaultSort('ap_paterno', 'ap_materno', 'nombres')
        ->allowedSorts([ 'nombres', 'ap_paterno', 'ap_materno'])
        ->allowedFilters(['ap_paterno', 'ap_materno', 'ci', $globalSearch])
        ->paginate()
        ->withQueryString();

        return view('persona.index', [
            'personas' => SpladeTable::for($personas)
            ->defaultSort('nombres')
            ->withGlobalSearch()
            ->column('nombres', sortable: true, searchable: true)
            ->column('ap_paterno', sortable: true, searchable: true)
            ->column('ap_materno', sortable: true, searchable: true)
            ->column('ci', searchable: true, hidden:true)
            ->column('telefono', hidden:true)
            ->column('action')
        ]);
    }

    public function create()
    {
        return view('persona.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nombres' => 'required|max:40',
            'ap_paterno' => 'required_without:ap_materno|max:30',
            'ap_materno' => 'required_without:ap_paterno|max:30',
            'ci' => 'nullable|max:11',
            'complemento' => 'nullable|max:5',
            'expedido' => 'nullable|string|max:2',
            'fecha_nacimiento' => 'nullable|date_format:Y-m-d',
            'telefono' => 'nullable|integer|max:99999999',
        ]);

        try {
            DB::beginTransaction();

            $persona = new Persona();
            $persona->titulo = $request->titulo;
            $persona->nombres = $request->nombres;
            $persona->ap_paterno = $request->ap_paterno;
            $persona->ap_materno = $request->ap_materno;
            $persona->ci = $request->ci;
            $persona->complemento = $request->complemento;
            $persona->expedido = $request->expedido;
            $persona->fecha_nacimiento = $request->fecha_nacimiento;
            $persona->genero = $request->genero;
            $persona->ocupacion_profesion = $request->ocupacion_profesion;
            $persona->domicilio = $request->domicilio;
            $persona->telefono = $request->telefono;
            $persona->save();

            DB::commit();

            Splade::toast('Persona creada correctamente!')->autoDismiss(5);

            return redirect()->route('personas');

        } catch (\Throwable $th) {
            DB::rollBack();
            return $th;
        }
    }

    public function show(Persona $persona)
    {
        $persona->load(['user', 'recibos' => function ($q) {
            $q->orderBy('fecha', 'desc')->limit(10);
        }]);
        return view('persona.show', compact('persona'));
    }

    public function edit(Persona $persona)
    {
        return view('persona.edit', compact('persona'));
    }

    public function update(Request $request, Persona $persona)
    {
        $request->validate([
            'nombres' => 'required|max:40',
            'ap_paterno' => 'required_without:ap_materno|max:30',
            'ap_materno' => 'required_without:ap_paterno|max:30',
            'ci' => 'nullable|max:11',
            'complemento' => 'nullable|max:5',
            'expedido' => 'nullable|string|max:2',
            'fecha_nacimiento' => 'nullable|date_format:Y-m-d',
            'telefono' => 'nullable|integer|max:99999999',
        ]);

        $persona->titulo = $request->titulo;
        $persona->nombres = $request->nombres;
        $persona->ap_paterno = $request->ap_paterno;
        $persona->ap_materno = $request->ap_materno;
        $persona->ci = $request->ci;
        $persona->complemento = $request->complemento;
        $persona->expedido = $request->expedido;
        $persona->fecha_nacimiento = $request->fecha_nacimiento;
        $persona->genero = $request->genero;
        $persona->ocupacion_profesion = $request->ocupacion_profesion;
        $persona->domicilio = $request->domicilio;
        $persona->telefono = $request->telefono;
        $persona->update();

        Splade::toast('Persona actualizada correctamente!')->autoDismiss(5);

        return redirect()->route('personas');
    }

    public function destroy(Persona $persona)
    {
        //
    }
}
