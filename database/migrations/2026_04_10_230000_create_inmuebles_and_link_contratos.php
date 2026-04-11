<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('inmuebles')) {
            Schema::create('inmuebles', function (Blueprint $table) {
                $table->id();
                $table->string('nombre');            // etiqueta corta para el select
                $table->string('patrimonio');         // tipo: Inmueble, Departamento, etc.
                $table->text('ubicacion');
                $table->text('descripcion');          // texto completo para el documento
                $table->text('servicios')->nullable(); // JSON array
                $table->unsignedBigInteger('user_id');
                $table->timestamps();
            });
        } else {
            // La tabla ya existe (migración parcial anterior) — agregar columnas faltantes
            if (!Schema::hasColumn('inmuebles', 'descripcion')) {
                Schema::table('inmuebles', function (Blueprint $table) {
                    $table->text('descripcion')->nullable()->after('ubicacion');
                });
            }
        }

        if (!Schema::hasColumn('contratos', 'inmueble_id')) {
            Schema::table('contratos', function (Blueprint $table) {
                $table->unsignedBigInteger('inmueble_id')->nullable()->after('persona_id');
            });
        }

        // Eliminar columnas temporales agregadas en la migración anterior
        foreach (['patrimonio', 'ubicacion', 'servicios'] as $col) {
            if (Schema::hasColumn('contratos', $col)) {
                DB::statement("ALTER TABLE contratos DROP COLUMN {$col}");
            }
        }
    }

    public function down(): void
    {
        Schema::table('contratos', function (Blueprint $table) {
            $table->dropColumn('inmueble_id');
            $table->string('patrimonio')->nullable();
            $table->text('ubicacion')->nullable();
            $table->text('servicios')->nullable();
        });

        Schema::dropIfExists('inmuebles');
    }
};
