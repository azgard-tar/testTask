<?php

namespace Database\Factories;

use App\Models\Model;
use App\Models\position;
use Illuminate\Database\Eloquent\Factories\Factory;

class PositionsFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = position::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'admin_created_id' => 1,
            'admin_updated_id' => 1,
            'title' => $this->faker->jobTitle
        ];
    }
}
