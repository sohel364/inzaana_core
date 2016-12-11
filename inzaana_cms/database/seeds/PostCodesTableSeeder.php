<?php

use Illuminate\Database\Seeder;

class PostCodesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	$i = 0;
    	$postcodes = Inzaana\User::postcodes('INDIA');
    	$totalPostCodes = count($postcodes);
    	echo "Total $totalPostCodes postcodes are parsed ######\n";
        foreach($postcodes as $post_code)
        {
			DB::table('post_codes')->insert([
				'post_code' => $post_code,
			]);
		    $percentage = (integer)(($i++ * 100) / $totalPostCodes);
			$bar = str_repeat("#", (integer)($percentage/ 10));
			echo "$percentage% $bar \r";
        }
		echo "\n";
    }
}
