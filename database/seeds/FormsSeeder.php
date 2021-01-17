<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FormsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        
        DB::table('forms')->insert([
            'name'  => 'Inicio',
            'href'  => '/',
            'class' => 'nav-link',
            'table' => '',
            'icon'  => '<i class="nav-icon fas fa-home"></i>'
        ]);
        
        DB::table('forms')->insert([
            'name'  => 'Usuarios',
            'href'  => 'usuarios',
            'class' => 'nav-link',
            'table' => 'users',
            'icon'  => '<i class="nav-icon fas fa-users"></i>'
        ]);
        
        DB::table('forms')->insert([
            'name'  => 'Roles',
            'href'  => 'roles',
            'class' => 'nav-link',
            'table' => 'roles',
            'icon'  => '<i class="fas fa-user-tag"></i>'
        ]);
    }
}
