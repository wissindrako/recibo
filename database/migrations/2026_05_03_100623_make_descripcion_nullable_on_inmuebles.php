<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
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
        DB::statement('ALTER TABLE inmuebles MODIFY COLUMN descripcion TEXT NULL DEFAULT NULL');
    }

    public function down()
    {
        DB::statement('ALTER TABLE inmuebles MODIFY COLUMN descripcion TEXT NOT NULL');
    }
};
