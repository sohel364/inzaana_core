<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAccYears extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
            Schema::create('acc_years', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('acc_year');
            $table->rememberToken();
            $table->timestamps();
        });// // //
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
         Schema::drop('acc_years');//
    }
}
