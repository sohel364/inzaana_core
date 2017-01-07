<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

use Inzaana\Database\Helper;

class CreateTemplatesTable extends Migration
{
    const TABLE_NAME = 'templates';
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
            $table->string('template_url', 500)->nullable()->comment('Url of the template');
            $table->string('template_res_url', 500)->nullable()->comment('Resource Url of the template');
            $table->string('saved_name')->comment('Saved name of template');
            $table->string('template_name')->comment('Name of template');
            $table->string('category_name')->comment('Category name of template');
            $table->softDeletes()->comment('If we want to keep track of deletion without actually deleting a record');
            $table->timestamps();
            $table->index(['id', 'user_id', 'created_at'], 'template_index');
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
        Schema::disableForeignKeyConstraints();
        Schema::dropIfExists(self::TABLE_NAME);
        Schema::enableForeignKeyConstraints();
    }
}
