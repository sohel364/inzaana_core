<?php
namespace Inzaana\Database;

use DB;
use Illuminate\Database\Migrations\Migration;

trait Helper
{
	public $table = 'users';

	private function isConnectionMySQL()
	{
		return env('DB_CONNECTION', 'mysql') == 'mysql' || config('database.default') == 'mysql';
	}

	private function isConnectionPostgreSQL()
	{
		return env('DB_CONNECTION', 'mysql') == 'pgsql' || config('database.default') == 'pgsql';
	}

	public function EnableForeignKeyChecks()
	{
        if($this->isConnectionMySQL())
            DB::statement('SET FOREIGN_KEY_CHECKS=1');
        else if($this->isConnectionPostgreSQL())
            DB::statement('ALTER TABLE ' . $this->table . ' ENABLE TRIGGER ALL');
	}

	public function DisableForeignKeyChecks()
	{
        if($this->isConnectionMySQL())
            DB::statement('SET FOREIGN_KEY_CHECKS=0');
        else if($this->isConnectionPostgreSQL())
            DB::statement('ALTER TABLE ' . $this->table . ' DISABLE TRIGGER ALL');
	}
}