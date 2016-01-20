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
        $table->bigIncrements('id');
        $table->bigInteger('super_category_id');
        $table->bigInteger('element_id');
        $table->bigInteger('element_value_id');
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
         Schema::drop('assign_elements');// //
    }
}
