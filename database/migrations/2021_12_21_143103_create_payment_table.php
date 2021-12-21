<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaymentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payment', function (Blueprint $table) {
            $table->increments('id');
            $table->text('description')->nullable();
            $table->text('url_file')->nullable();
            $table->unsignedBigInteger('id_user')->unsigned()->index();
            $table->foreign('id_user')->references('id')->on('users');
            $table->integer('type_pay')->unsigned()->index();
            $table->foreign('type_pay')->references('id')->on('paymenttype');
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
        Schema::dropIfExists('payment');
    }
}
