<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('contratos', function (Blueprint $table) {
            $table->string('patrimonio')->nullable()->after('descripcion_alquiler');
            $table->text('ubicacion')->nullable()->after('patrimonio');
            $table->text('servicios')->nullable()->after('ubicacion'); // JSON array
        });

        // Hacer descripcion_inmueble nullable (sin doctrine/dbal)
        DB::statement('ALTER TABLE contratos MODIFY COLUMN descripcion_inmueble TEXT NULL DEFAULT NULL');
    }

    public function down(): void
    {
        Schema::table('contratos', function (Blueprint $table) {
            $table->dropColumn(['patrimonio', 'ubicacion', 'servicios']);
        });
        DB::statement('ALTER TABLE contratos MODIFY COLUMN descripcion_inmueble TEXT NOT NULL');
    }
};
