<?php

namespace Database\Factories;

use App\Models\Client;
use App\Models\InstallationType;
use App\Models\Location;
use App\Models\Project;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Project>
 */
class ProjectFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'client_id' => Client::factory(),
            'location_id' => Location::inRandomOrder()->first()->id,
            'installation_type_id' => InstallationType::inRandomOrder()->first()->id,
        ];
    }
}
