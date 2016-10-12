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

        /*
         * Seed Super Admin
         *
         * */
        $user = factory(Inzaana\User::class)->create([
            'name' => 'admin',
            'email' => config('mail.admin.address'),
            'password' => bcrypt('#admin?inzaana$'),
        ]);
        if($user)
            Log::info('[Inzaana][Single admin user created for testing]');
        else
            Log::error('[Inzaana][No admin user created] -> [Seeding failed]');

        /*
         * Seed Vendor
         * Create only 5 Vendor
         * */
        \Stripe\Stripe::setApiKey(getenv('STRIPE_SECRET'));
        $users = factory(Inzaana\User::class, 5)->create([
            'name' => $faker->unique()->firstName . ' ' .  $faker->unique()->lastName,
        ])->each(function($user){
            $vendorPassword = '#vendor?' . str_random(5) . '$';
            $user->password = bcrypt($vendorPassword);
            $user->email_alter = preg_replace("/(\w+)@(\w+.)+/", "$1@inzaana.com", $user->email);
            $user->stores()->save(factory(Inzaana\Store::class)->make());
            $user->newSubscription('Free', 'VuvmBePBCq3L')->create(\Stripe\Token::create(array(
                "card" => array(
                    "number" => "5555555555554444",
                    "exp_month" => 9,
                    "exp_year" => 2018,
                    "cvc" => "400"
                )
            ))->id);
            $user->subscription('Free')->cancel();
            $user->save();
            Log::debug('[Inzaana][User of email -> ' . $user->email . ', password -> ' . $vendorPassword . ' is created, has ' . $user->stores()->count() . ' stores for testing]');
        });
        if($users->count() > 0)
            Log::info('[Inzaana][' . $users->count() . ' vendor users created for testing]');
        else
            Log::error('[Inzaana][No vendor user created] -> [Seeding failed]');

        /*
         * Add plan in local database
         * */
        Inzaana\StripePlan::create([
            "plan_id"               => 'VuvmBePBCq3L',
            "name"                  => 'Free',
            "amount"                => '0.00',
            "currency"              => 'INR',
            "interval"              => 'month',
            "active"                => '1',
            "trial_period_days"     => '12',
            "statement_descriptor"  => 'Free Trial Package.',
            "created"               => date('Y-m-d H:i:s')
        ]);

        /*
         * Seed Customer
         * Create only 5 Customer
         * */
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

        /*
         * Stripe Plan Features Table Seeding
         * */

        $feature_list = ['Store','Categories','Products','FAQ','Orders','Customers','Coupons','Taxes','Localisation','Promotional Pages','Pages','Extensions','Sales','Authority','Inventory & Stock Manager','Point Of Sale','Reports','Browse Templates','My Templates'];

        foreach ($feature_list as $feature) {
           \Inzaana\StripePlanFeature::create(
               ['feature_name'=>$feature]
           );
        }


    }
}
