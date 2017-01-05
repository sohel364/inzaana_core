<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSpecRulesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('spec_rules', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('specificable_id')->comment("Morphs to product_id or, category_id");
            $table->string('specificable_type')->comment("Morphs to owner model's full name");
            $table->string('label', 50)->comment("Specification attribute name or rule");
            $table->boolean('is_visible')->default(false)->comment('If the spec rule is allowed to be visible or not');
            $table->mediumText('description');
            $table->enum('status', [
                'ON_APPROVAL', 'APPROVED', 'REJECTED', 'REMOVED'
            ]);
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
        Schema::drop('spec_rules');
    }
}
