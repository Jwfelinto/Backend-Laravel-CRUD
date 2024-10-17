<?php

namespace Tests\Unit;

use App\Models\Client;
use App\Models\User;
use Laravel\Sanctum\Sanctum;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class ClientTest extends TestCase
{
    /**
     * A basic unit test example.
     */
    #[Test]
    public function can_create_a_client()
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user);

        $data = [
            'name' => 'João Batista',
            'email' => 'joaobatista@example.com',
            'phone' => '12345678985',
            'cpf_cnpj' => '12345678901',
        ];
        $response = $this->post('/api/clientes', $data);
        $response->assertStatus(201);
        $this->assertDatabaseHas('clients', $data);

    }

    /**
     * @return void
     */
    #[Test]
    public function can_list_clients()
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user);

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
    #[Test]
    public function can_update_a_client()
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user);

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
    #[Test]
    public function can_delete_a_client()
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user);

        $client = Client::factory()->create();

        $response = $this->delete("/api/clientes/{$client->id}");
        $response->assertStatus(204);
        $this->assertDatabaseMissing('clients', ['id' => $client->id]);
    }

}
