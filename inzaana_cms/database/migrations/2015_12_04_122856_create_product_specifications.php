<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductSpecifications extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_specifications', function (Blueprint $table) {
        $table->bigIncrements('id');
        // $table->bigInteger('user_id');
        $table->bigInteger('product_id');
        $table->string('color');
        $table->string('rating');
        $table->string('review');
        $table->text('q_and_a');
        $table->string('cod');
        $table->text('highlight');
        $table->text('technical_specification');
        $table->text('description');
        $table->text('useful_link');
        $table->float('terms_conditions');
        $table->string('video_calling_facility');
        $table->string('inzaana_fullfill');
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
      Schema::drop('product_specifications'); //
    }
}
