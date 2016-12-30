<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

use Inzaana\Database\Helper;

class CreateUsersTable extends Migration
{
    use Helper;

    const TABLE_NAME = 'users';

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
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('email')->unique();
            $table->string('email_alter')->nullable();
            $table->string('country')->nullable();
            $table->string('phone_number');
            $table->string('address', 500);
            $table->string('password', 60);
            $table->boolean('verified')->default(false);
            $table->string('token')->nullable();
            $table->rememberToken();
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
        $this->DisableForeignKeyChecks();
        
        Schema::dropIfExists(CreateHtmlViewsTable::TABLE_NAME);
        Schema::dropIfExists(CreateTemplatesTable::TABLE_NAME);
        Schema::dropIfExists('users');

        $this->EnableForeignKeyChecks();
    }
}
