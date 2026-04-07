<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        // contratos.arrendador_id ahora apunta a users
        Schema::table('contratos', function (Blueprint $table) {
            $table->dropForeign(['arrendador_id']);
        });
        Schema::table('contratos', function (Blueprint $table) {
            $table->foreign('arrendador_id')->references('id')->on('users')->onDelete('set null');
        });

        Schema::dropIfExists('arrendadores');
    }

    public function down()
    {
        Schema::create('arrendadores', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->unique();
            $table->boolean('activo')->default(true);
            $table->timestamps();
        });

        Schema::table('contratos', function (Blueprint $table) {
            $table->dropForeign(['arrendador_id']);
            $table->foreign('arrendador_id')->references('id')->on('arrendadores')->onDelete('set null');
        });
    }
};
