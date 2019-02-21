<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TypeNFCTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('type_ncf')->insert([
            'tipo' => 'Credito Fiscal',
            'slug' => '01',
        ]);
        DB::table('type_ncf')->insert([
            'tipo' => 'Facturas de Consumo',
            'slug' => '02',
        ]);
        DB::table('type_ncf')->insert([
            'tipo' => 'Notas de Debito',
            'slug' => '03',
        ]);
        DB::table('type_ncf')->insert([
            'tipo' => 'Notas de Credito',
            'slug' => '04',
        ]);
        DB::table('type_ncf')->insert([
            'tipo' => 'Provedores Informales',
            'slug' => '11',
        ]);
        DB::table('type_ncf')->insert([
            'tipo' => 'Registro Unico de Ingresos',
            'slug' => '12',
        ]);
        DB::table('type_ncf')->insert([
            'tipo' => 'Registro de Gastos Menores',
            'slug' => '13',
        ]);
        DB::table('type_ncf')->insert([
            'tipo' => 'Regímenes Especiales de Tributación',
            'slug' => '14',
        ]);
        DB::table('type_ncf')->insert([
            'tipo' => 'Comprobantes Gubernamentales',
            'slug' => '15',
        ]);
        //
    }
}
