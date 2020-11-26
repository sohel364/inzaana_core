<?php

use Illuminate\Database\Seeder;

class StatesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $srcPath = storage_path(Inzaana\User::SEEDING_DATA_SOURCE_CSV);
        if (!file_exists($srcPath)) {
            echo "The seeding source csv file ($srcPath) does not exist\n";
            return;
        }
    	$i = 0;
    	$states = Inzaana\User::states('INDIA');
    	$totalStates = count($states);
    	echo "Total $totalStates states are parsed ######\n";
        foreach($states as $state_name)
        {
		    DB::table('states')->insert([
		        'state_name' => $state_name,
		    ]);
		    $percentage = (integer)(($i++ * 100) / $totalStates);
			$bar = str_repeat("#", (integer)($percentage/ 10));
			echo "$percentage% $bar \r";
        }
		echo "\n";
    }
}
