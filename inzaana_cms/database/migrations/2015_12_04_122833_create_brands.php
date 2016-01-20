<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBrands extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('brands', function (Blueprint $table) {
        $table->bigIncrements('id');
        $table->bigInteger('user_id');
        $table->bigInteger('category_id');
        $table->bigInteger('sub_category_id');
        $table->string('brand_name');
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
       Schema::drop('brands');//
    }
}
