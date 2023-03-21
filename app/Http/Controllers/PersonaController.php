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
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
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
            ->column('rude', searchable: false, hidden:true,  label:'Rude')
            ->column('nombres', sortable: true, searchable: true)
            ->column('ap_paterno', sortable: true, searchable: true)
            ->column('ap_materno', sortable: true, searchable: true)
            ->column('ci', searchable: true, hidden:true)
            ->column('telefono', hidden:true)
            ->column('action')
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('persona.create');
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

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Persona  $persona
     * @return \Illuminate\Http\Response
     */
    public function show(Persona $persona)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Persona  $persona
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $persona = Persona::findOrFail($id);

        return view('persona.edit', compact('persona'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Persona  $persona
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
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

        $persona = Persona::findOrFail($id);
        $persona->titulo = $request->titulo;
        $persona->nombres = $request->nombres;
        $persona->ap_paterno = $request->ap_paterno;
        $persona->ap_materno = $request->ap_materno;
        $persona->ci = $request->ci;
        $persona->complemento = $request->complemento;
        $persona->expedido = $request->expedido;
        $persona->fecha_nacimiento = $request->fecha_nacimiento;
        $persona->genero = $request->genero;
        $persona->ocupacion_profesion = 'Estudiante';
        $persona->domicilio = $request->domicilio;
        $persona->telefono = $request->telefono;
        $persona->update();

        Splade::toast('Persona actualizada correctamente!')->autoDismiss(5);

        return redirect()->route('personas');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Persona  $persona
     * @return \Illuminate\Http\Response
     */
    public function destroy(Persona $persona)
    {
        //
    }
}
