<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSubCategories extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sub_categories', function (Blueprint $table) {
        $table->bigIncrements('id');
        $table->bigInteger('category_id');
        $table->string('sub_category_name');
        $table->string('sub_category_slug');       
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
        Schema::drop('sub_categories'); //
    }
}
