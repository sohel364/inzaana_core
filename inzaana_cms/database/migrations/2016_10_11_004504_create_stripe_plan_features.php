<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStripePlanFeatures extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=1');
        Schema::create('stripe_plan_features', function (Blueprint $table) {
            $table->increments('feature_id');
            $table->string('feature_name');
        });
        Schema::create('stripe_plan_has_features', function (Blueprint $table) {
            $table->integer('plan_id')->unsigned();
            $table->integer('feature_id')->unsigned();
        });
        Schema::table('stripe_plan_has_features', function(Blueprint $table){
            $table->foreign('plan_id')->references('id')->on('stripe_plans')->onDelete('cascade');
            $table->foreign('feature_id')->references('feature_id')->on('stripe_plan_features')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        Schema::drop("stripe_plan_features");
        Schema::drop("stripe_plan_has_features");
    }
}
