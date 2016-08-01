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
        Schema::create('stripePlans', function (Blueprint $table) {
            $table->string('plan_id')->unique();
            $table->string('name');
            $table->string('amount');
            $table->string('currency');
            $table->string('interval');
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
        Schema::drop('stripePlans');
    }
}
