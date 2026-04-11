<?php

namespace App\Http\Controllers;

use App\Models\Inmueble;
use Illuminate\Http\Request;
use ProtoneMedia\Splade\Facades\Splade;
use ProtoneMedia\Splade\SpladeTable;

class InmuebleController extends Controller
{
    public function index()
    {
        $inmuebles = SpladeTable::for(Inmueble::orderBy('nombre')->paginate())
            ->column('nombre', label: 'Nombre')
            ->column('patrimonio', label: 'Tipo')
            ->column('ubicacion', label: 'Ubicación')
            ->column('action', label: 'Acciones');

        return view('inmueble.index', compact('inmuebles'));
    }

    public function create()
    {
        return view('inmueble.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre'      => 'required|string|max:255',
            'patrimonio'  => 'required|string|max:255',
            'ubicacion'   => 'required|string',
            'descripcion' => 'nullable|string',
            'servicios'   => 'nullable|array',
            'servicios.*' => 'string|in:agua,luz,gas,alcantarillado,internet',
        ]);

        Inmueble::create([
            'nombre'      => $request->nombre,
            'patrimonio'  => $request->patrimonio,
            'ubicacion'   => $request->ubicacion,
            'descripcion' => $request->descripcion,
            'servicios'   => $request->servicios ?? [],
            'user_id'     => auth()->id(),
        ]);

        Splade::toast('Inmueble registrado.')->autoDismiss(5);
        return redirect()->route('inmuebles');
    }

    public function edit(Inmueble $inmueble)
    {
        return view('inmueble.edit', compact('inmueble'));
    }

    public function update(Request $request, Inmueble $inmueble)
    {
        $request->validate([
            'nombre'      => 'required|string|max:255',
            'patrimonio'  => 'required|string|max:255',
            'ubicacion'   => 'required|string',
            'descripcion' => 'nullable|string',
            'servicios'   => 'nullable|array',
            'servicios.*' => 'string|in:agua,luz,gas,alcantarillado,internet',
        ]);

        $inmueble->nombre      = $request->nombre;
        $inmueble->patrimonio  = $request->patrimonio;
        $inmueble->ubicacion   = $request->ubicacion;
        $inmueble->descripcion = $request->descripcion;
        $inmueble->servicios   = $request->servicios ?? [];
        $inmueble->save();

        Splade::toast('Inmueble actualizado.')->autoDismiss(5);
        return redirect()->route('inmuebles');
    }

    public function destroy(Inmueble $inmueble)
    {
        $inmueble->delete();
        Splade::toast('Inmueble eliminado.')->autoDismiss(5);
        return redirect()->route('inmuebles');
    }
}
