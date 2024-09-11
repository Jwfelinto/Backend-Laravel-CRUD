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

    public function test_project_has_a_client(): void
    {
        $client = Client::factory()->create();
        $project = Project::factory()->create([
            'client_id' => $client->id,
        ]);

        $project = $project->load('client');

        $this->assertNotNull($project->client);
        $this->assertEquals($client->id, $project->client_id);
        $this->assertEquals($client->name, $project->client->name);
    }

    public function test_project_has_a_location(): void
    {
        $location = Location::factory()->create();
        $project = Project::factory()->create([
            'location_id' => $location->id,
        ]);

        $project = $project->load('location');

        $this->assertNotNull($project->location);
        $this->assertEquals($location->id, $project->location_id);
        $this->assertEquals($location->name, $project->location->name);
    }

    public function test_project_has_an_installation_type(): void
    {
        $installationType = InstallationType::factory()->create();
        $project = Project::factory()->create([
            'installation_type_id' => $installationType->id,
        ]);

        $project = $project->load('installationType');

        $this->assertNotNull($project->installationType);
        $this->assertEquals($installationType->id, $project->installation_type_id);
        $this->assertEquals($installationType->name, $project->installationType->name);
    }

}
