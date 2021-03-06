<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePermissionRolesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('permission_roles', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('role_id')->unsigned()->index('role_foreign');
            $table->bigInteger('form_id')->unsigned()->index('form_foreign');
            $table->bigInteger('permission_id')->unsigned()->index('permission_foreign');
            $table->timestamps();
            $table->foreign('role_id')->references('id')->on('roles');  
            $table->foreign('permission_id')->references('id')->on('permissions');  
            $table->foreign('form_id')->references('id')->on('forms');  
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('permission_roles');
    }
}
