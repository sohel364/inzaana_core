<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

use Inzaana\Database\Helper;

class CreateStripePlanFeatures extends Migration
{
    const TABLE_NAME = 'stripe_plan_features';

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(self::TABLE_NAME, function (Blueprint $table) {
            $table->increments('feature_id');
            $table->string('feature_name');
        });
        Schema::create('stripe_plan_has_features', function (Blueprint $table) {
            $table->integer('plan_id')->unsigned();
            $table->integer('feature_id')->unsigned();
        });
        Schema::table('stripe_plan_has_features', function(Blueprint $table){
            $table->foreign('plan_id')->references('id')->on('stripe_plans')->onDelete('cascade');
            $table->foreign('feature_id')->references('feature_id')->on(self::TABLE_NAME)->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::disableForeignKeyConstraints();
        
        Schema::drop("stripe_plan_has_features");
        Schema::drop(self::TABLE_NAME);
        
        Schema::enableForeignKeyConstraints();
    }
}
