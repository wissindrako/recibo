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
        Schema::create('personas', function (Blueprint $table) {
            $table->id();
            $table->string('nombres', 40);
            $table->string('ap_paterno', 30)->nullable();
            $table->string('ap_materno', 30)->nullable();
            $table->bigInteger('ci')->nullable();
            $table->string('complemento', 7)->nullable();
            $table->string('expedido', 3)->nullable();
            $table->date('fecha_nacimiento')->nullable();
            $table->string('genero', 20)->nullable();
            $table->string('titulo', 10)->nullable(); //Sr. Lic. Ing. Msc. Etc.
            $table->string('ocupacion_profesion', 50)->nullable();
            $table->string('domicilio')->nullable();
            $table->string('telefono', 15)->nullable();
            $table->string('foto')->nullable();
            $table->boolean('active')->default(0);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('personas');
    }
};
