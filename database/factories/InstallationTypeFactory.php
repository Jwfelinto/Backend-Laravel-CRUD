<?php

namespace Database\Factories;

use App\Models\InstallationType;
use Illuminate\Database\Eloquent\Factories\Factory;

class InstallationTypeFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = InstallationType::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->randomElement(InstallationType::TYPES),
        ];
    }
}
