<?php

namespace Tests\Unit;

use App\Models\Client;
use App\Models\Project;
use Tests\TestCase;

class ClientTest extends TestCase
{
    /**
     * A basic unit test example.
     */
    public function test_it_can_create_a_client()
    {
        $clientData = [
            'name' => 'João Batista',
            'email' => 'joaobatista@example.com',
            'phone' => '123456789',
            'cpf_cnpj' => '12345678901',
        ];

        $client = Client::create($clientData);

        $this->assertDatabaseHas('clients', $clientData);
        $this->assertInstanceOf(Client::class, $client);
    }

    public function test_client_has_many_projects()
    {
        $client = Client::factory()->create();
        $projects = Project::factory()->count(3)->create(['client_id' => $client->id]);

        $this->assertInstanceOf(Project::class, $client->projects->first());
        $this->assertEquals(3, $client->projects->count());
    }

}
