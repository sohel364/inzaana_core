<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

use Inzaana\Database\Helper;

class CreateHtmlViewSubmenusTable extends Migration
{
    use Helper;

    const TABLE_NAME = 'html_view_submenus';

    public function __construct()
    {
        $this->table = self::TABLE_NAME;
    }

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

        $this->EnableForeignKeyChecks();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
        $this->DisableForeignKeyChecks();
        
        Schema::dropIfExists(self::TABLE_NAME);
    }
}
