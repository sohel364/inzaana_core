<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCategories extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('sup_category_id');
            $table->string('category_name', 50);
            $table->string('category_slug',100);
            $table->string('description', 255);
            $table->enum('status', [
                'REMOVED', 'ON_APPROVAL', 'APPROVED', 'REJECTED'
            ]);
            $table->timestamps();        
        });  //
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('categories');
    }
}
