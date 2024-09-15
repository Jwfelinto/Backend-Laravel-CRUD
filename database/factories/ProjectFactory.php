<?php

namespace Database\Factories;

use App\Models\Client;
use App\Models\InstallationType;
use App\Models\Location;
use App\Models\Project;
use App\Models\Tool;
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
            'location_id' => Location::factory(),
            'installation_type_id' => InstallationType::factory(),
        ];
    }

    public function withExistingData(): self
    {
        return $this->state(function (array $attributes) {
            return [
                'client_id' => Client::factory(),
                'location_id' => Location::inRandomOrder()->first()->id,
                'installation_type_id' => InstallationType::inRandomOrder()->first()->id,
            ];
        });
    }

    /**
     * Create tools associated with the project.
     */
    public function withTools(int $count = 3): self
    {
        return $this->afterCreating(function (Project $project) use ($count) {
            $tools = Tool::inRandomOrder()->take($count)->pluck('id');
            $project->tools()->attach($tools, [
                'quantity' => $this->faker->numberBetween(1, 10),
            ]);
        });
    }
}
