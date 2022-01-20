<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for($i = 1; $i < 14; $i++)
            DB::table('tables')->insert([
                'place_id' => 1,
                'x' => rand(0, 10),
                'y' => rand(0, 10),
                'w' => 2,
                'h' => 3,
                'i' => $i,
                'slug' => $i
            ]);
        for($i = 1; $i < 14; $i++)
            DB::table('tables')->insert([
                'place_id' => 2,
                'x' => rand(0, 10),
                'y' => rand(0, 10),
                'w' => 2,
                'h' => 3,
                'i' => $i,
                'slug' => $i
            ]);
        for($i = 1; $i < 14; $i++)
            DB::table('tables')->insert([
                'place_id' => 3,
                'x' => rand(0, 10),
                'y' => rand(0, 10),
                'w' => 2,
                'h' => 3,
                'i' => $i,
                'slug' => $i
            ]);
    }
}
