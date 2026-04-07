<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        // Vincular persona a usuario
        Schema::table('personas', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id')->nullable()->after('id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
        });

        // Arrendador solo necesita user_id + activo
        Schema::table('arrendadores', function (Blueprint $table) {
            $table->dropForeign(['persona_id']);
            $table->dropColumn('persona_id');
        });
    }

    public function down()
    {
        Schema::table('personas', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropColumn('user_id');
        });

        Schema::table('arrendadores', function (Blueprint $table) {
            $table->unsignedBigInteger('persona_id')->nullable()->after('user_id');
            $table->foreign('persona_id')->references('id')->on('personas')->onDelete('cascade');
        });
    }
};
