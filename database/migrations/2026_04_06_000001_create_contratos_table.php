<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('contratos', function (Blueprint $table) {
            $table->id();
            $table->integer('nro_serie');
            $table->enum('tipo', ['alquiler', 'venta', 'otro'])->default('alquiler');
            $table->integer('persona_id');
            $table->string('arrendador_nombre');
            $table->string('arrendador_ci');
            $table->enum('arrendador_genero', ['Sr.', 'Sra.'])->default('Sr.');
            $table->text('descripcion_bien');
            $table->date('fecha_inicio');
            $table->date('fecha_fin')->nullable();
            $table->decimal('monto', 10, 2);
            $table->decimal('garantia', 10, 2)->nullable();
            $table->integer('dia_limite_pago')->nullable();
            $table->tinyInteger('estado')->default(1); // 0=Anulado, 1=Vigente, 2=Vencido
            $table->string('archivo')->nullable();
            $table->text('notas')->nullable();
            $table->unsignedBigInteger('contrato_origen_id')->nullable();
            $table->string('user_id');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('contratos');
    }
};
