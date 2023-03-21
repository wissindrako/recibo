<?php

namespace App\Http\Controllers;

use App\Models\Persona;
use App\Models\Recibo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class InicioController extends Controller
{
    public function dashboard(){
        $user_id = auth()->user()->id;

        $unidades_educativas = Recibo::where('user_id', $user_id)
                                ->with(['materias'])
                                ->withCount('materias')
                                ->addSelect(DB::raw("'2023' as gestion"))
                                ->get();

        foreach ($unidades_educativas as $key => $value) {
            $id = $value->id;
            $cursos = Persona::whereHas('materia', function ($query) use($id) {
                $query->where('unidad_educativa_id', $id);
            })->get();

            $cursos_count = $cursos->count();

            $value->setAttribute('cursos', $cursos);
            $value->setAttribute('cursos_count', $cursos_count);
        }
        // dd($unidades_educativas);
        return view('dashboard', compact('unidades_educativas'));
    }
}
