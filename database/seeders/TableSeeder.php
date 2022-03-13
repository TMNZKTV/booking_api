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
        for($i = 0; $i < 15; $i++)
            DB::table('tables')->insert([
                'place_id' => 1,
                'x' => rand(0, 10),
                'y' => rand(0, 10),
                'w' => 2,
                'h' => 3,
                'i' => $i + 1,
                'bbq' => rand(0, 1),
            ]);
        for($i = 0; $i < 15; $i++)
            DB::table('tables')->insert([
                'place_id' => 2,
                'x' => rand(0, 10),
                'y' => rand(0, 10),
                'w' => 2,
                'h' => 3,
                'i' => $i + 1,
                'bbq' => rand(0, 1),
            ]);
        for($i = 0; $i < 14; $i++)
            DB::table('tables')->insert([
                'place_id' => 3,
                'x' => rand(0, 10),
                'y' => rand(0, 10),
                'w' => 2,
                'h' => 3,
                'i' => $i + 1,
                'bbq' => rand(0, 1),
            ]);
        for($i = 100; $i < 101; $i++)
            DB::table('tables')->insert([
                'id'=> 100,
                'place_id' => 1,
                'x' => 0,
                'y' => 0,
                'w' => 0,
                'h' => 0,
                'i' => 'Ожидание',
                'bbq' => 0,
            ]);
        for($i = 101; $i < 102; $i++)
            DB::table('tables')->insert([
                'id'=> 101,
                'place_id' => 1,
                'x' => rand(0, 10),
                'y' => rand(0, 10),
                'w' => 2,
                'h' => 6,
                'i' => 'Бар',
                'bbq' => 0,
            ]);
        for($i = 102; $i < 103; $i++)
            DB::table('tables')->insert([
                'id'=> 102,
                'place_id' => 2,
                'x' => rand(0, 10),
                'y' => rand(0, 10),
                'w' => 0,
                'h' => 0,
                'i' => 'Ожидание',
                'bbq' => 0,
            ]);
        for($i = 103; $i < 104; $i++)
            DB::table('tables')->insert([
                'id'=> 103,
                'place_id' => 2,
                'x' => 0,
                'y' => 0,
                'w' => 2,
                'h' => 6,
                'i' => 'Бар',
                'bbq' => 0,
            ]);
        for($i = 104; $i < 105; $i++)
            DB::table('tables')->insert([
                'id'=> 104,
                'place_id' => 3,
                'x' => 0,
                'y' => 0,
                'w' => 0,
                'h' => 0,
                'i' => 'Ожидание',
                'bbq' => 0,
            ]);
        for($i = 105; $i < 106; $i++)
            DB::table('tables')->insert([
                'id'=> 105,
                'place_id' => 3,
                'x' => 0,
                'y' => 0,
                'w' => 2,
                'h' => 6,
                'i' => 'Бар',
                'bbq' => 0,
            ]);
    }
}
