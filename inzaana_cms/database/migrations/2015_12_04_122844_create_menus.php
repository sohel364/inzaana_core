<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMenus extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
       Schema::create('menus', function (Blueprint $table) {
        $table->bigIncrements('id');
        $table->string('menu_name');
        $table->integer('menu_order');
        $table->string('menu_url');
        $table->string('menu_icon');
        $table->string('controller');
        $table->string('is_active');
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
        Schema::drop('menus'); //
    }
}
