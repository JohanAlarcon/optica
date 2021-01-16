<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PermissionRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /* 
        
        1.Inicio
        2.Roles
        3.Usuarios
        
         */
         
        $cantidad_formularios=3;
        
        for ($f=1; $f <= $cantidad_formularios; $f++) { 
           
           for ($p=1; $p <= 4; $p++) { //GUARDAR,ACTUALIZAR,BORRAR,MOSTRAR
                                     
                DB::table('permission_roles')->insert([
                    'form_id'    => $f,
                    'role_id'    => '1',
                    'permission_id'   => $p,
                    'created_at' => NOW()
                ]);
             
           }
           
        }
        
    }
}
