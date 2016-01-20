<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductAttributes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_attributes', function (Blueprint $table) {
        $table->bigIncrements('id');
        $table->bigInteger('user_id');
        $table->bigInteger('sup_category_id');
        $table->bigInteger('category_id');
        $table->bigInteger('sub_category_id');
        $table->bigInteger('product_id');
        $table->bigInteger('element_id');
        $table->bigInteger('element_value_id');
        $table->string('element_description');        
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
        Schema::drop('product_attributes'); //
    }
}
