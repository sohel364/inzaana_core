<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProducts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
        $table->bigIncrements('id');
        $table->bigInteger('user_id');
        $table->bigInteger('sup_category_id');
        $table->bigInteger('category_id');
        $table->bigInteger('sub_category_id');
        $table->double('lat');
        $table->double('lng');
        $table->string('product_title');
        $table->string('manufacture_name');
        $table->float('quantity');
        $table->float('product_mrp');
        $table->float('selling_price');
        $table->float('product_discount');
        $table->string('photo_name');
        $table->string('photo_size');
        $table->string('photo_type');
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
         Schema::drop('products'); //
    }
}
