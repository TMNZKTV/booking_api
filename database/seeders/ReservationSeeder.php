<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Faker\Generator as Faker;
use Illuminate\Support\Facades\DB;


class ReservationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Не могу правильно использовать Seeding для резерваций
        DB::table('reservations')->insert([
            'name' => $this->faker->name,
            'phone'=> $this->faker->phone,
            'date'=>Carbon::create('2000', '01', '01'),
            'time'=>rand(0,12).':'.rand(0,60),
            'note'=>'This is a test note'
        ]);
    }
}
