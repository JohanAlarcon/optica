<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFormsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('forms', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('href');
            $table->string('class');
            $table->string('icon');
            $table->char('state', 1)->default('1')->comment = "0:INACTIVO 1:ACTIVO";
            $table->timestamps();
        });
    }

    /*  $table->bigIncrements('id');
            $table->string('name');
            $table->string('descripcion');
            $table->bigInteger('usuario_registra')->nullable()->unsigned()->index('user_register_foreign');
            $table->bigInteger('usuario_actualiza')->nullable()->unsigned()->index('user_update_foreign');
            $table->timestamps();
            $table->softDeletes(); */
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('forms');
    }
}
