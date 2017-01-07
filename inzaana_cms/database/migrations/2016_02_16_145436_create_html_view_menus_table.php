<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

use Inzaana\Database\Helper;

class CreateHtmlViewMenusTable extends Migration
{
    const TABLE_NAME = 'html_view_menus';
    
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create(self::TABLE_NAME, function (Blueprint $table) {
            $table->bigIncrements('id');

            // If you don't put [->unsigned()] below in template_id it will mismatches 
            // the storage size and will fail to apply command of forign key reference for deletion at the
            // end of this schema create command. In user table primary key is unsigned big integer
            // If we don't put template_id ->unsigned() it will remain only as big integer.
            $table->bigInteger('template_id')->unsigned();
            $table->string('menu_title')->comment('Menu title of the HTML view');
            $table->string('href')->comment('Menu href of the HTML view');
            $table->boolean('has_sub_menu')->default(false)->comment('If this menu has any sub menu');

            $table->softDeletes()->comment('If we want to keep track of deletion without actually deleting a record');
            $table->timestamps();
            $table->index(['id', 'template_id', 'created_at'], 'html_view_menus_index');
            $table->foreign('template_id')
                    ->references('id')->on('templates')
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
        Schema::disableForeignKeyConstraints();        
        Schema::dropIfExists(self::TABLE_NAME);
        Schema::enableForeignKeyConstraints();
    }
}
