<?php

namespace Tests\Unit;

use App\Models\Client;
use App\Models\InstallationType;
use App\Models\Location;
use Tests\TestCase;
use App\Models\Project;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProjectTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_create_a_project(): void
    {
        $projectData = [
            'client_id' => Client::factory()->create()->id,
            'location_id' => Location::factory()->create()->id,
            'installation_type_id' => InstallationType::factory()->create()->id,
        ];

        Project::create($projectData);

        $this->assertDatabaseHas('projects', $projectData);
    }

}
