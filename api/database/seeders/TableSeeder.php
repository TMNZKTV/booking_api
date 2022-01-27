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
                'bbq' => rand(0, 1),
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
                'bbq' => rand(0, 1),
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
                'bbq' => rand(0, 1),
                'slug' => $i
            ]);

        for($i = 100; $i < 101; $i++)
            DB::table('tables')->insert([
                'id'=> 100,
                'place_id' => 1,
                'x' => 0,
                'y' => 0,
                'w' => 0,
                'h' => 0,
                'i' => $i,
                'bbq' => 0,
                'slug' => $i
            ]);
        for($i = 101; $i < 102; $i++)
            DB::table('tables')->insert([
                'id'=> 101,
                'place_id' => 2,
                'x' => 0,
                'y' => 0,
                'w' => 0,
                'h' => 0,
                'i' => $i,
                'bbq' => 0,
                'slug' => $i
            ]);
        for($i = 102; $i < 103; $i++)
            DB::table('tables')->insert([
                'id'=> 102,
                'place_id' => 3,
                'x' => 0,
                'y' => 0,
                'w' => 0,
                'h' => 0,
                'i' => $i,
                'bbq' => 0,
                'slug' => $i
            ]);
    }
}
