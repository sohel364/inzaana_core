<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateElementValues extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {       
        Schema::create('element_values', function (Blueprint $table) {
        $table->bigIncrements('id');
        $table->bigInteger('element_id');
        $table->bigInteger('element_valuse');
        $table->string('status');
        $table->rememberToken();
        $table->timestamps();        
        });  //
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
      Schema::drop('element_values'); //
    }
}
