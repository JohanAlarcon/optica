<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRolesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('roles', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('descripcion');
            $table->bigInteger('usuario_registra')->nullable()->unsigned()->index('user_register_foreign');
            $table->bigInteger('usuario_actualiza')->nullable()->unsigned()->index('user_update_foreign');
            $table->timestamps();
            $table->softDeletes(); //Nueva línea, para el borrado lógico
            //
        });
        
        Schema::create('role_user', function (Blueprint $table) {
            
            $table->primary('user_id','role_id');
            
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('role_id');
            $table->timestamps();
            
            $table->foreign('user_id')
                  ->references('id')
                  ->on('users')
                  ->onDelete('cascade');
                  
            $table->foreign('role_id')
                  ->references('id')
                  ->on('roles')
                  ->onDelete('cascade');
           
            //
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('roles', function (Blueprint $table) {
            //
        });
    }
}
