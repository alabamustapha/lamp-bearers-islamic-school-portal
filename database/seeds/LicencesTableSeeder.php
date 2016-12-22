<?php

use Illuminate\Database\Seeder;

class LicencesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $licences = fopen(storage_path('app/licence.txt'), 'r') or die('cant open');


        $count = 0;
        while (!feof($licences)) {

            $count++;
            var_dump(trim(fgets($licences)));
            \App\Licence::create([
                'licence' => bcrypt(trim(fgets($licences)))
            ]);
        }

        dd($count);
    }
}
