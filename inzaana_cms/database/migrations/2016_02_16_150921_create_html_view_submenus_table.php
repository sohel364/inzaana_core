<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHtmlViewSubmenusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        DB::statement('SET FOREIGN_KEY_CHECKS=1');

        Schema::create('html_view_submenus', function (Blueprint $table) {
            $table->bigIncrements('id');

            // If you don't put [->unsigned()] below in html_view_menu_id it will mismatches 
            // the storage size and will fail to apply command of forign key reference for deletion at the
            // end of this schema create command. In user table primary key is unsigned big integer
            // If we don't put html_view_menu_id ->unsigned() it will remain only as big integer.
            $table->bigInteger('html_view_menu_id')->unsigned();
            $table->string('submenu_title')->comment('Submenu title of the HTML view menu');

            $table->softDeletes()->comment('If we want to keep track of deletion without actually deleting a record');
            $table->timestamps();
            $table->index(['id', 'html_view_menu_id', 'created_at'], 'html_view_submenus_index');
            $table->foreign('html_view_menu_id')
                    ->references('id')->on('html_view_menus')
                    ->onDelete('cascade');
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
        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        
        Schema::dropIfExists('html_view_submenus');
    }
}
