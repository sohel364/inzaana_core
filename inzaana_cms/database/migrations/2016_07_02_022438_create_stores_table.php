<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStoresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('stores', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('user_id')->unsigned();
            $table->string('name', 30);
            $table->string('name_as_url')->unique();
            $table->string('address', 500);
            $table->string('domain')->default('com');
            $table->string('sub_domain')->default('inzaana');
            $table->string('store_type');
            $table->string('description', 1000);
            $table->enum('status', [
                'ON_APPROVAL', 'APPROVED', 'REJECTED', 'REMOVED', 'COMING_SOON', 'SOLD'
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
        //
        Schema::drop('stores');
    }
}
