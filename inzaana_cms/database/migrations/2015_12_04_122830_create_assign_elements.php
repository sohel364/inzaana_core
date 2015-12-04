<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAssignElements extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('assign_elements', function (Blueprint $table) {
        $table->increments('id');
        $table->integer('super_category_id');
        $table->integer('element_id');
        $table->integer('element_value_id');
        $table->rememberToken();
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
        //
    }
}
