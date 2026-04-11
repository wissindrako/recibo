<?php

namespace App\Models;

use App\Models\Traits\HasHashid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inmueble extends Model
{
    use HasFactory, HasHashid;

    protected $fillable = [
        'nombre', 'patrimonio', 'ubicacion', 'descripcion', 'servicios', 'user_id',
    ];

    protected $casts = [
        'servicios' => 'array',
    ];

    public function contratos()
    {
        return $this->hasMany(Contrato::class);
    }

    public function usuario()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function getNombreCompletoAttribute(): string
    {
        return $this->nombre . ' — ' . $this->patrimonio;
    }
}
