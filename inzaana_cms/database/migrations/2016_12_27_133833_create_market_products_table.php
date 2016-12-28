<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

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
            $table->string('title', 200);
            $table->string('manufacturer_name', 200);
            $table->float('price')->default(0.0);
            $table->json('category_specs')->nullable()->comment('JSON serialization of product specifications defined by category specifications.');
            $table->enum('status', [
                'ON_APPROVAL', 'UPLOAD_FAILED', 'APPROVED', 'REJECTED', 'OUT_OF_STOCK', 'AVAILABLE', 'NOT_AVAILABLE', 'ON_SHIPPING', 'REMOVED', 'COMING_SOON', 'SOLD', 'ORDERED'
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
        Schema::drop('market_products');
    }
}
