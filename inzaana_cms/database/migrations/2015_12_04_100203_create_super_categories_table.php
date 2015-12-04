<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSuperCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
            Schema::create('super_categories', function (Blueprint $table) {
            $table->increments('id');
            $table->string('sup_category_name');
            $table->string('sup_category_slug');
            $table->string('status');          
            $table->rememberToken();
            $table->timestamps();
        });// //
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop("super_categories");//
    }
}
