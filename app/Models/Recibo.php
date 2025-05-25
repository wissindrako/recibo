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

    protected function getNroSerieAttribute()
    {
        return FormatoTexto::zero_fill_left($this->attributes['nro_serie'], 4);
        //return str_pad($this->attributes['nro_serie'], 4, '0', STR_PAD_LEFT);
    }

    // Mutador para establecer el estado
    public function setEstadoAttribute($value)
    {
        $valoresPermitidos = [0, 1, 2];
        if (in_array($value, $valoresPermitidos)) {
            $this->attributes['estado'] = $value;
        } else {
            throw new \InvalidArgumentException('Valor de estado no válido.');
        }
    }

    // Accesor para obtener el estado como texto
    public function getEstadoTextoAttribute()
    {
        $estados = [
            0 => 'Anulado',
            1 => 'Registrado',
            2 => 'Aprobado',
        ];

        return $estados[$this->estado] ?? 'Desconocido';
    }
}
