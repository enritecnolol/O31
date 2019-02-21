<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class categoriaTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('categorias')->insert([
            'nombre' => 'General',
            'codigo' => '00',
            'img' => 'default.jpg',
            'user_id' => '1',
        ]);
    }
}
