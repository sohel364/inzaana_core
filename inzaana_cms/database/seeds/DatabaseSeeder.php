<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        $this->call(UsersTableSeeder::class);
        $this->call(StatesTableSeeder::class);
        $this->call(PostCodesTableSeeder::class);
        $this->call(ProductMediaTableSeeder::class);

        Model::reguard();
    }
}
