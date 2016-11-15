<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCouponMigration extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('coupons', function (Blueprint $table) {
            $table->increments('id');
            $table->string('coupon_id',32)->unique();
            $table->string('coupon_name')->unique();
            $table->unsignedInteger('percent_off')->nullable();
            $table->unsignedInteger('amount_off')->nullable();
            $table->string('currency')->nullable();
            $table->string('duration')->nullable();
            $table->unsignedInteger('duration_in_months')->nullable();
            $table->unsignedInteger('max_redemptions')->nullable();
            $table->boolean('valid')->nullable();
            $table->timestamp('redeem_by')->nullable();
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
        Schema::drop('coupons');
    }
}
