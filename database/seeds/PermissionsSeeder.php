<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        
        $data = [
            ['name' => 'GUARDAR'],
            ['name' => 'EDITAR'],
            ['name' => 'ELIMINAR'],
            ['name' => 'MOSTRAR']
        ];
        
        DB::table('permissions')->insert($data); 
    }
}
