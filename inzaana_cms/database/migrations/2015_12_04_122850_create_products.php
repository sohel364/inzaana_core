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
        $table->boolean('has_sub_category_id');
		$table->bigInteger('category_subcategory_id');
        // $table->double('lat');
        // $table->double('lng');
        $table->string('product_title', 100);
        $table->string('manufacture_name', 200);
        // $table->float('quantity');
        $table->float('product_mrp');
        $table->float('selling_price');
        $table->float('product_discount');
        $table->string('photo_name');// will be considered as photo_url
        // $table->string('photo_size');
        // $table->string('photo_type');
        $table->string('status');
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
