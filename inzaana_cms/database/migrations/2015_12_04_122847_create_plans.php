<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePlans extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('plans', function (Blueprint $table) {
        $table->bigIncrements('id');
        $table->bigInteger('user_id');
        $table->string('plan_name');
        $table->float('plan_amount');
        $table->float('plan_days_limit');
        $table->float('upload_product_limit');
        $table->text('plan_desc');
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
        Schema::drop('plans'); //
    }
}
