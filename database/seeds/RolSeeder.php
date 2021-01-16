<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RolSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('roles')->insert([
            'name'       => 'administrador',
            'usuario_registra' => 1,
            'descripcion'=> 'acceso y control de todo el sistema',
            'created_at' => NOW()
        ]);
    }
}
