<?php

use Illuminate\Database\Seeder;

class CitiesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('cities')->insert([
            'id' => 1,
            'nombre' => 'Bogota',
            'status' => true,
        ]);
        DB::table('cities')->insert([
            'id' => 2,
            'nombre' => 'Cali',
            'status' => true,
        ]);
        DB::table('cities')->insert([
            'id' => 3,
            'nombre' => 'Medellin',
            'status' => true,
        ]);
    }
}
