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
    public function test_can_create_a_client()
    {
        $data = [
            'name' => 'João Batista',
            'email' => 'joaobatista@example.com',
            'phone' => '123456789',
            'cpf_cnpj' => '12345678901',
        ];
        $response = $this->post('/api/clientes', $data);
        $response->assertStatus(201);
        $this->assertDatabaseHas('clients', $data);

    }

    /**
     * @return void
     */
    public function test_can_list_clients()
    {
        $client = Client::factory()->create();

        $response = $this->get('/api/clientes');
        $response->assertStatus(200);
        $response->assertJsonFragment([
            'id' => $client->id,
            'name' => $client->name
        ]);
    }


    /**
     * @return void
     */
    public function test_can_update_a_client()
    {
        $client = Client::factory()->create();

        $data = [
            'name' => 'Jane Doe',
            'email' => 'jane.doe@example.com',
            'phone' => '0987654321',
            'cpf_cnpj' => '10987654321',
        ];

        $response = $this->put("/api/clientes/{$client->id}", $data);
        $response->assertStatus(200);
        $this->assertDatabaseHas('clients', $data);
    }

    /**
     * @return void
     */
    public function test_can_delete_a_client()
    {
        $client = Client::factory()->create();

        $response = $this->delete("/api/clientes/{$client->id}");
        $response->assertStatus(204);
        $this->assertDatabaseMissing('clients', ['id' => $client->id]);
    }

}
