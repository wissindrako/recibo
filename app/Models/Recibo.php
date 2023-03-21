<?php

namespace App\Models;

use App\Helpers\FormatoTexto;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Recibo extends Model
{
    use HasFactory;

    public function cliente()
    {
        return $this->belongsTo(Persona::class);
    }

    public function usuario()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    /**
     * Funcion estática que retorna el siguiente numero de serie.
     *
     * @return int
     */
    public static function nextNumeroSerie()
    {
        $numero = Recibo::max('nro_serie');
        if (!$numero) {
            $numero = 0;
        }
        return $numero + 1;
    }

    /**
     * Obtener el nro_serie con relleno de ceros a la izquierda.
     *
     * @return \Illuminate\Database\Eloquent\Casts\Attribute
     */

     protected function nroSerie(): Attribute
     {
         return Attribute::make(
             get: fn ($value, $attributes) => FormatoTexto::zero_fill_left($attributes['nro_serie'], 4)
             );
     }
}
