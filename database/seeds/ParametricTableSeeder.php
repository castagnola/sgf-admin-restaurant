<?php

use Illuminate\Database\Seeder;

class ParametricTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('parametrics')->insert([
            'id' => 1,
            'tipo_parametrica' => 'numero_mesas_restaurante',
            'valor_parametrica' => 15,
        ]);
    }
}
