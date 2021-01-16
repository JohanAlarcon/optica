<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForaneaUser extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
          
            $table->foreign('usuario_registra')->references('id')->on('users');
            $table->foreign('usuario_actualiza')->references('id')->on('users');
            
        });
        
        Schema::table('roles', function (Blueprint $table) {
          
            $table->foreign('usuario_registra')->references('id')->on('users');
            $table->foreign('usuario_actualiza')->references('id')->on('users');
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
