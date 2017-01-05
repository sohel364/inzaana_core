<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

use Inzaana\Product;

class CreateMarketProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('market_products', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('category_id');
            $table->string('title', 200)->comment('Market product title');
            $table->string('manufacturer_name', 200);
            $table->float('price')->default(0.0);
            $table->json('category_specs')->nullable()->comment('JSON serialization of product specifications defined by category specifications.');
            $table->enum('status', Product::STATUS_FLOWS)->default('ON_APPROVAL');
            $table->timestamps();   
            $table->softDeletes();     
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('market_products');
    }
}
