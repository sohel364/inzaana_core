<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProducts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('user_id');
            $table->bigInteger('store_id');
            $table->bigInteger('market_product_id');
            $table->boolean('is_public')->default(false);
            $table->string('title', 200);
            $table->float('mrp')->default(0.0);
            $table->float('discount')->default(0.0);
            $table->json('special_specs')->nullable()->comment('JSON serialization of product specifications defined by store product specifications.');
            $table->bigInteger('available_quantity')->default(0);
            $table->integer('return_time_limit')->default(0);
            $table->enum('status', [
                'OUT_OF_STOCK', 'AVAILABLE', 'NOT_AVAILABLE', 'ON_SHIPPING', 'REMOVED', 'COMING_SOON', 'SOLD', 'ORDERED', 'ON_APPROVAL', 'APPROVED', 'REJECTED'
            ]);
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
        Schema::drop('products');
    }
}
