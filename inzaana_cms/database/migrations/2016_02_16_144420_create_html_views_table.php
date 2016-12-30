<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

use Inzaana\Database\Helper;

class CreateHtmlViewsTable extends Migration
{
    use Helper;

    const TABLE_NAME = 'html_views';

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
            // If you don't put [->unsigned()] below in user_id it will mismatches 
            // the storage size and will fail to apply command of forign key reference for deletion at the
            // end of this schema create command. In user table primary key is unsigned big integer
            // If we don't put user_id ->unsigned() it will remain only as big integer.
            $table->bigInteger('user_id')->unsigned();
            $table->string('title')->comment('Title of the HTML view');
            $table->string('menus')->comment('Menus of the HTML view');
            $table->longtext('header')->comment('Header of the HTML view');
            $table->longtext('footer')->comment('Footer of the HTML view');
            $table->longtext('body')->comment('Body of the HTML view');
            $table->softDeletes()->comment('If we want to keep track of deletion without actually deleting a record');
            $table->timestamps();
            $table->index(['id', 'user_id', 'created_at'], 'html_views_index');
            $table->foreign('user_id')
                    ->references('id')->on('users')
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
        $this->DisableForeignKeyChecks();

        Schema::dropIfExists(CreateHtmlViewSubmenusTable::TABLE_NAME);
        Schema::dropIfExists(self::TABLE_NAME);

        $this->EnableForeignKeyChecks();
    }
}
