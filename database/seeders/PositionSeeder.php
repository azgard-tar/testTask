<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker;

class PositionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker\Factory::create();
        for( $i = 0; $i < 10; $i++ ){
            DB::table('positions')->insert([
                'admin_created_id' => 1,
                'admin_updated_id' => 1,
                'title' => $faker->jobTitle,
                'updated_at' => date(config('app.datetime_format')),
                'created_at' => date(config('app.datetime_format'))
            ]);
        }
    }
}
