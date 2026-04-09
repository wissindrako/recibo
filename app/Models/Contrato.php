<?php

namespace App\Models;

use App\Helpers\FormatoTexto;
use App\Models\Traits\HasHashid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contrato extends Model
{
    use HasFactory, HasHashid;

    protected $casts = [
        'fecha_inicio' => 'date',
        'fecha_fin'    => 'date',
    ];

    public function persona()
    {
        return $this->belongsTo(Persona::class);
    }

    public function arrendador()
    {
        return $this->belongsTo(User::class, 'arrendador_id');
    }

    public function usuario()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function contratoOrigen()
    {
        return $this->belongsTo(Contrato::class, 'contrato_origen_id');
    }

    public function renovaciones()
    {
        return $this->hasMany(Contrato::class, 'contrato_origen_id');
    }

    public static function nextNumeroSerie()
    {
        $numero = Contrato::max('nro_serie');
        return ($numero ?? 0) + 1;
    }

    public function getNroSerieAttribute()
    {
        return FormatoTexto::zero_fill_left($this->attributes['nro_serie'], 4);
    }

    /**
     * Calcula el estado según las fechas y lo persiste si cambió.
     * 0 = Anulado, 1 = Vigente, 2 = Vencido
     */
    public function calcularEstado(): int
    {
        if ($this->attributes['estado'] == 0) {
            return 0; // Anulado manual, no se recalcula
        }
        if ($this->fecha_fin && $this->fecha_fin->isPast()) {
            return 2;
        }
        return 1;
    }

    public function getEstadoTextoAttribute(): string
    {
        $estados = [
            0 => 'Anulado',
            1 => 'Vigente',
            2 => 'Vencido',
        ];
        return $estados[$this->calcularEstado()] ?? 'Desconocido';
    }

    public function getTipoTextoAttribute(): string
    {
        $tipos = [
            'alquiler' => 'Alquiler',
            'venta'    => 'Venta',
            'otro'     => 'Otro',
        ];
        return $tipos[$this->tipo] ?? $this->tipo;
    }
}
