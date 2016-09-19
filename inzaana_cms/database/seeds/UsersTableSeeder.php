<?php

use Illuminate\Database\Seeder;
use Faker\Factory as UserFaker;
use Illuminate\Support\Facades\Log;

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
        $faker = UserFaker::create('en_US');
        // factory(Inzaana\User::class, 50)->create();
        $user = factory(Inzaana\User::class)->create([
            'name' => 'admin',
            'email' => config('mail.admin.address'),
            'password' => bcrypt('#admin?inzaana$'),  
        ]);
        if($user)
            Log::info('[Inzaana][Single admin user created for testing]');
        else
            Log::error('[Inzaana][No admin user created] -> [Seeding failed]');

        $users = factory(Inzaana\User::class, 5)->create([
            'name' => $faker->unique()->firstName . ' ' .  $faker->unique()->lastName,
        ])->each(function($user){
            $vendorPassword = '#vendor?' . str_random(5) . '$';
            $user->password = bcrypt($vendorPassword);
            $user->stores()->save(factory(Inzaana\Store::class)->make());
            $user->save();
            Log::debug('[Inzaana][User of email -> ' . $user->email . ', password -> ' . $vendorPassword . ' is created, has ' . $user->stores()->count() . ' stores for testing]');
        });
        if($users->count() > 0)
            Log::info('[Inzaana][' . $users->count() . ' vendor users created for testing]');
        else
            Log::error('[Inzaana][No vendor user created] -> [Seeding failed]');

        $users = factory(Inzaana\User::class, 5)->create([
            'name' => $faker->unique()->firstName . ' ' .  $faker->unique()->lastName, 
        ])->each(function($user){
            $customerPassword = '#customer?' . str_random(5) . '$';
            $user->password = bcrypt($customerPassword);            
            $user->save();
            Log::debug('[Inzaana][User of email -> ' . $user->email . ', password -> ' . $customerPassword . ' is created for testing]');
        });
        if($users->count() > 0)
            Log::info('[Inzaana][' . $users->count() . ' customer users created for testing]');
        else
            Log::error('[Inzaana][No customer user created] -> [Seeding failed]');
    }
}
