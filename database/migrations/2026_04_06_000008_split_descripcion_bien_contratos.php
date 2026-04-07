<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        DB::statement('ALTER TABLE contratos CHANGE `descripcion_bien` `descripcion_inmueble` TEXT NOT NULL');
        Schema::table('contratos', function (Blueprint $table) {
            $table->text('descripcion_alquiler')->nullable()->after('descripcion_inmueble');
        });
    }

    public function down()
    {
        Schema::table('contratos', function (Blueprint $table) {
            $table->dropColumn('descripcion_alquiler');
        });
        DB::statement('ALTER TABLE contratos CHANGE `descripcion_inmueble` `descripcion_bien` TEXT NOT NULL');
    }
};
