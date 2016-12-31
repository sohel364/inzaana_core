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
            $table->increments('id');
            $table->string('plan_id')->unique();
            $table->string('name')->unique();
            $table->string('amount');
            $table->string('currency');
            $table->string('interval');
            $table->integer('interval_count');
            $table->tinyInteger('active')->default(0);
            $table->tinyInteger('auto_renewal');
            $table->string('trial_period_days');
            $table->string('statement_descriptor');
            $table->string('coupon_id')->nullable();
            $table->dateTime('created');
            $table->timestamps();
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
