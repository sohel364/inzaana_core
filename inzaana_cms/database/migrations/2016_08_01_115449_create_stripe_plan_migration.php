<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStripePlanMigration extends Migration
{
    /**
     * Run the migrations.
     * Stripe plan local database
     * This table used only laravel stripeplan model
     * @return void
     */
    public function up()
    {
        Schema::create('stripe_plans', function (Blueprint $table) {
            $table->increments('plan_id');
            $table->string('name')->unique();
            $table->string('amount');
            $table->string('currency');
            $table->string('interval');
            $table->tinyInteger('active');
            $table->string('trial_period_days');
            $table->string('statement_descriptor');
            $table->dateTime('created');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('stripe_plans');
    }
}
