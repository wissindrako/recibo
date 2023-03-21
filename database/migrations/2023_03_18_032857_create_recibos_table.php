<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('recibos', function (Blueprint $table) {
            $table->id();
            $table->integer('nro_serie');
            $table->string('hash');
            $table->date('fecha');
            $table->integer('cliente_id');
            $table->string('moneda', 10)->default('BS');
            $table->decimal('cantidad', 8, 2);
            $table->string('cantidad_literal')->nullable();
            $table->string('concepto');
            $table->string('observaciones')->nullable();
            $table->string('user_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('recibos');
    }
};
