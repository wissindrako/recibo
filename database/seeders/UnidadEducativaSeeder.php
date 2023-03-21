<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Database\Seeder;

class UnidadEducativaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\UnidadEducativa::factory(2)->state(new Sequence(
            ['sistema' => 'Regular'],
            ['sistema' => 'Alternativo'],
            ['sistema' => 'Superior'],
        ))->create();
    }
}
