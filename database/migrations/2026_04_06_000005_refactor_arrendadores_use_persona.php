<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('arrendadores', function (Blueprint $table) {
            $table->dropColumn(['nombres', 'ap_paterno', 'ap_materno', 'ci', 'ci_expedido', 'genero', 'domicilio']);
            $table->unsignedBigInteger('persona_id')->after('user_id');
            $table->foreign('persona_id')->references('id')->on('personas')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::table('arrendadores', function (Blueprint $table) {
            $table->dropForeign(['persona_id']);
            $table->dropColumn('persona_id');
            $table->string('nombres', 60)->after('user_id');
            $table->string('ap_paterno', 40)->nullable();
            $table->string('ap_materno', 40)->nullable();
            $table->string('ci', 20)->nullable();
            $table->string('ci_expedido', 5)->nullable();
            $table->string('genero', 10)->nullable();
            $table->string('domicilio')->nullable();
        });
    }
};
