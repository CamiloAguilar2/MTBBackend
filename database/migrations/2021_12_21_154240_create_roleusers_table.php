<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRoleusersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('roleusers', function (Blueprint $table) {
            
            $table->increments('id');
            $table->unsignedInteger('id_rol')->unsigned()->index();
            $table->foreign('id_rol')->references('id')->on('roles');
            $table->unsignedBigInteger('id_user')->unsigned()->index();
            $table->foreign('id_user')->references('id')->on('users');
            $table->softDeletes();
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('roleusers');
    }
}
