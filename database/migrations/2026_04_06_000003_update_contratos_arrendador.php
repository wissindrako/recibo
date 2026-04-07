<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('contratos', function (Blueprint $table) {
            $table->dropColumn(['arrendador_nombre', 'arrendador_ci', 'arrendador_genero']);
            $table->unsignedBigInteger('arrendador_id')->nullable()->after('persona_id');
            $table->foreign('arrendador_id')->references('id')->on('arrendadores')->onDelete('set null');
        });
    }

    public function down()
    {
        Schema::table('contratos', function (Blueprint $table) {
            $table->dropForeign(['arrendador_id']);
            $table->dropColumn('arrendador_id');
            $table->string('arrendador_nombre')->after('persona_id');
            $table->string('arrendador_ci', 50)->after('arrendador_nombre');
            $table->enum('arrendador_genero', ['Sr.', 'Sra.'])->default('Sr.')->after('arrendador_ci');
        });
    }
};
