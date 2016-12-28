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
            $table->bigInteger('parent_category_id')->default(0);
            $table->string('name', 50);
            $table->string('category_slug',100);
            $table->mediumText('description', 255);
            $table->enum('status', [
                'ON_APPROVAL', 'APPROVED', 'REJECTED', 'REMOVED'
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
