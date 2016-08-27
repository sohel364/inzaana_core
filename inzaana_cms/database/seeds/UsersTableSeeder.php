<?php

use Illuminate\Database\Seeder;
use Faker\Factory as UserFaker;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        // $faker = UserFaker::create();
        // factory(Inzaana\User::class, 50)->create();
        $user = factory(Inzaana\User::class)->create([
            'name' => 'admin',
            'email' => config('mail.admin.address'),
            'password' => bcrypt('#admin?inzaana$'), 
            'verified' => true,
            'remember_token' => str_random(10),    
        ]);
    }
}
