<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Faker;

class EmployeeSeeder extends Seeder
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
            DB::table('employees_model')->insert([
                'full_name' => $faker->name,
                'email' => $faker->email,
                'id_position' => $faker->numberBetween(1,10),
                'id_head' => $faker->numberBetween(1,10),
                'date_of_employment' => $faker->date( 'Y-m-d','+30 years'),
                'phone_number' => $faker->numerify('+380(##)#######'),
                'salary' => $faker->numberBetween(0,500000),
                'admin_created_id' => 1,
                'admin_updated_id' => 1,
                'created_at' => date('Y-m-d'),
                'updated_at' => date('Y-m-d')
            ]);
        }
    }
}
