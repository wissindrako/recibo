<?php

namespace App\Models;

use App\Casts\CapitalizeWordsCast;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Persona extends Model
{
    use HasFactory;

    protected $casts = [
        'nombres'  => CapitalizeWordsCast::class,
        'ap_paterno'  => CapitalizeWordsCast::class,
        'ap_materno'  => CapitalizeWordsCast::class,

    ];

    public function estudiante()
    {
        return $this->hasOne(Estudiante::class);
    }

    /**
     * Obtener el nombre completo.
     *
     * @return \Illuminate\Database\Eloquent\Casts\Attribute
     */

     protected function nombreCompleto(): Attribute
     {
         return Attribute::make(
             get: fn ($value, $attributes) => $attributes['nombres'] .' '. $attributes['ap_paterno'] .' '. $attributes['ap_materno']
             );
     }
}
