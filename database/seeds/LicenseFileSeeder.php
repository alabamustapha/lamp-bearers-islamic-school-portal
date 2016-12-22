<?php

use Illuminate\Database\Seeder;

class LicenseFileSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        \Illuminate\Support\Facades\Storage::disk('local')->prepend('licence.txt', 'ONETERMFREETRIAL');

        for($i = 0; $i < 500; $i++) {

            $licence = strtoupper(str_random(16));
            \Illuminate\Support\Facades\Storage::disk('local')->prepend('licence.txt', $licence);

        }

    }
}
