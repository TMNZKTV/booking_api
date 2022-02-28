<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PlaceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $places = array('Марата', 'Горная', 'Байкальская');

        foreach ($places as $place){
            DB::table('places')->insert([
                'name' => $place,
                'slug' => $place
            ]);
        }
    }
}
