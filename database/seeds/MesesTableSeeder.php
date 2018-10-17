<?php

use Illuminate\Database\Seeder;

class MesesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('meses')->insert([
            'mes' => 'enero',
        ]);
        DB::table('meses')->insert([
            'mes' => 'febrero',
        ]);
        DB::table('meses')->insert([
            'mes' => 'marzo',
        ]);
        DB::table('meses')->insert([
            'mes' => 'abril',
        ]);
        DB::table('meses')->insert([
            'mes' => 'mayo',
        ]);
        DB::table('meses')->insert([
            'mes' => 'junio',
        ]);
        DB::table('meses')->insert([
            'mes' => 'julio',
        ]);
        DB::table('meses')->insert([
            'mes' => 'agosto',
        ]);
        DB::table('meses')->insert([
            'mes' => 'septiembre',
        ]);
        DB::table('meses')->insert([
            'mes' => 'octubre',
        ]);
        DB::table('meses')->insert([
            'mes' => 'noviembre',
        ]);
        DB::table('meses')->insert([
            'mes' => 'diciembre',
        ]);
    }
}
