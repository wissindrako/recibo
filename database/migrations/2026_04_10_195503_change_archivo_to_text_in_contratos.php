<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement('ALTER TABLE contratos MODIFY COLUMN archivo TEXT NULL');
    }

    public function down()
    {
        DB::statement('ALTER TABLE contratos MODIFY COLUMN archivo VARCHAR(255) NULL');
    }
};
