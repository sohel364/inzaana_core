<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

use Inzaana\Database\Helper;

class CreateMediasTable extends Migration
{
    const TABLE_NAME = 'medias';
    
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
            
            $table->bigInteger('template_id')->unsigned();
            $table->bigInteger('user_id')->unsigned();
            $table->string('media_name')->comment('Media name of the resource.');
            $table->enum('media_type', ['IMAGE', 'VIDEO', 'AUDIO'])->default('IMAGE')->comment('Media type of the resource.');
            $table->enum('status', ['REMOVED', 'HIDDEN', 'VISIBLE'])->default('VISIBLE')->comment('Status of the media availability');

            $table->softDeletes()->comment('If we want to keep track of deletion without actually deleting a record');
            $table->timestamps();
            $table->index(['id', 'template_id', 'user_id', 'created_at'], 'medias_index');
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
