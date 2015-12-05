<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSubMenus extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sub_menus', function (Blueprint $table) {
        $table->bigIncrements('id');
        $table->bigInteger('menu_id');
        $table->string('sub_menu_name');
        $table->string('sub_menu_url');
        $table->integer('sub_menu_order');
        $table->string('(sub_menu_icon');
        $table->string('action');
        $table->string('is_active');
        $table->rememberToken();
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
       Schema::drop('sub_menus'); //
    }
}
