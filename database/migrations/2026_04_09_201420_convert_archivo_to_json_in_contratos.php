<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Convierte valores de cadena simple a array JSON
        DB::table('contratos')
            ->whereNotNull('archivo')
            ->get()
            ->each(function ($row) {
                $value = $row->archivo;
                $decoded = json_decode($value, true);
                if (json_last_error() !== JSON_ERROR_NONE || !is_array($decoded)) {
                    DB::table('contratos')
                        ->where('id', $row->id)
                        ->update(['archivo' => json_encode([$value])]);
                }
            });
    }

    public function down(): void
    {
        // Revierte: si el array tiene un solo elemento, lo convierte a cadena
        DB::table('contratos')
            ->whereNotNull('archivo')
            ->get()
            ->each(function ($row) {
                $decoded = json_decode($row->archivo, true);
                if (is_array($decoded) && count($decoded) === 1) {
                    DB::table('contratos')
                        ->where('id', $row->id)
                        ->update(['archivo' => $decoded[0]]);
                }
            });
    }
};
