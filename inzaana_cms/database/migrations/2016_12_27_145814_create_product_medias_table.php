<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

use Inzaana\ProductMedia;

class CreateProductMediasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('product_medias', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('mediable_id')->comment("Mediable model id. it may be market or store product");
            $table->string('mediable_type')->comment("Mediable model type. it may be market or store product's full name");
            $table->enum('media_type', ProductMedia::MEDIA_TYPES)->default(ProductMedia::MEDIA_TYPES[0])->comment("Multimedia types");
            $table->string('title')->unique()->comment("Media file name");
            $table->longText('url')->comment("If media has a reference URL");
            $table->boolean('is_public')->default(false);
            $table->boolean('is_embed')->default(false)->comment('If the media has any url as embed');
            $table->enum('status', [
                'ON_APPROVAL', 'UPLOAD_FAILED', 'APPROVED', 'REJECTED', 'REMOVED'
            ])->default('ON_APPROVAL');
            $table->timestamps();        
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
        Schema::drop('product_medias');
    }
}
