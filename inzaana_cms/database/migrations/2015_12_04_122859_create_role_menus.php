<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRoleMenus extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('role_menus', function (Blueprint $table) {
        $table->bigIncrements('id');
        $table->bigInteger('role_id');
        $table->bigInteger('menu_id');
        $table->bigInteger('sub_menu_id');       
        $table->string('status');
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
       Schema::drop('role_menus'); //
    }
}
