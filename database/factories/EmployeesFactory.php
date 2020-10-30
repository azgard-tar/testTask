<?php

namespace Database\Factories;

use App\Models\employee;
use App\Models\Model;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class EmployeesFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = employee::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'fullName' => $this->faker->name,
            'email' => $this->faker->email,
            'id_position' => $this->faker->random_int(1,10),
            'id_head' => $this->faker->random_int(1,10),
            'date_of_employment' => $this->faker->date( 'Y-m-d','+30 years'),
            'phone_number' => $this->faker->e164PhoneNumber(),
            'salary' => $this->faker->random_int(0,500000),
            'photo' => Str::random(10),
            'admin_created_id' => 1,
            'admin_updated_id' => 1
        ];
    }
}
