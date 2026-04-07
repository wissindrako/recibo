<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('arrendadores', function (Blueprint $table) {
            $table->dropColumn('nombre');
            $table->string('nombres', 60)->after('user_id');
            $table->string('ap_paterno', 40)->nullable()->after('nombres');
            $table->string('ap_materno', 40)->nullable()->after('ap_paterno');
            $table->string('ci_expedido', 5)->nullable()->after('ci');
        });
    }

    public function down()
    {
        Schema::table('arrendadores', function (Blueprint $table) {
            $table->dropColumn(['nombres', 'ap_paterno', 'ap_materno', 'ci_expedido']);
            $table->string('nombre', 200)->after('user_id');
        });
    }
};
