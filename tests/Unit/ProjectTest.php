<?php

namespace Tests\Unit;

use App\Models\Client;
use App\Models\InstallationType;
use App\Models\Location;
use App\Models\Tool;
use App\Models\User;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;
use App\Models\Project;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProjectTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    /**
     * @return void
     */
    public function test_can_create_a_project(): void
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user);

        $client = Client::factory()->create();
        $location = Location::factory()->create();
        $installationType = InstallationType::factory()->create();
        $tool = Tool::factory()->create();

        $data = [
            'client_id' => $client->id,
            'location_id' => $location->id,
            'installation_type_id' => $installationType->id,
            'tools' => [
                [
                    'id' => $tool->id,
                    'quantity' => 3,
                ],
            ],
        ];

        $response = $this->post('/api/projetos', $data);
        $response->assertStatus(201);

        $this->assertDatabaseHas('projects', [
            'client_id' => $data['client_id'],
            'location_id' => $data['location_id'],
            'installation_type_id' => $data['installation_type_id'],
        ]);

        $this->assertDatabaseHas('project_tools', [
            'project_id' => Project::latest()->first()->id,
            'tool_id' => $tool->id,
            'quantity' => 3,
        ]);
    }

    /**
     * @return void
     */
    public function test_can_show_a_project(): void
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user);

        $project = Project::factory()->withTools()->create();

        $response = $this->get("/api/projetos/{$project->id}");
        $response->assertStatus(200);

    }

    /**
     * @return void
     */
    public function test_can_update_a_project(): void
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user);

        $project = Project::factory()->create();
        $tool = Tool::factory()->create();

        $data = [
            'client_id' => $project->client_id,
            'location_id' => $project->location_id,
            'installation_type_id' => $project->installation_type_id,
            'tools' => [
                [
                    'id' => $tool->id,
                    'quantity' => 6,
                ],
            ],
        ];

        $response = $this->put("/api/projetos/{$project->id}", $data);
        $response->assertStatus(200);

        $this->assertDatabaseHas('projects', [
            'client_id' => $data['client_id'],
            'location_id' => $data['location_id'],
            'installation_type_id' => $data['installation_type_id'],
        ]);

        $this->assertDatabaseHas('project_tools', [
            'project_id' => $project->id,
            'tool_id' => $tool->id,
            'quantity' => 6,
        ]);
    }

    /**
     * @return void
     */
    public function test_can_delete_a_project(): void
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user);

        $project = Project::factory()->create();

        $response = $this->delete("/api/projetos/{$project->id}");

        $response->assertStatus(204);
        $this->assertDatabaseMissing('projects', ['id' => $project->id]);
    }

    /**
     * @return void
     */
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

    /**
     * @return void
     */
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

    /**
     * @return void
     */
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
