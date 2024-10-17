<?php

namespace Tests\Unit;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\Sanctum;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function can_create_a_user()
    {
        $userData = [
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'password' => Hash::make('@77SolarEnergy'),
        ];

        $response = $this->postJson(route('register'), $userData);

        $response->assertStatus(201)
            ->assertJsonFragment(['name' => 'John Doe', 'email' => 'john@example.com']);

        $this->assertDatabaseHas('users', [
            'name' => 'John Doe',
            'email' => 'john@example.com',
        ]);
    }

    #[Test]
    public function can_list_users()
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user);

        User::factory()->count(5)->create();

        $response = $this->getJson(route('user.index'));

        $response->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    '*' => ['id', 'name']
                ]
            ]);
    }

    #[Test]
    public function can_show_a_user()
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user);

        $user = User::factory()->create();

        $response = $this->getJson(route('user.show', $user->id));

        $response->assertStatus(200)
            ->assertJsonFragment(['id' => $user->id, 'name' => $user->name, 'email' => $user->email]);
    }

    #[Test]
    public function can_update_a_user()
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user);

        $updateData = [
            'name' => 'John Updated',
            'email' => 'johnupdated@example.com',
            'password' => Hash::make('@77SolarEnergy'),
        ];

        $response = $this->putJson(route('user.update', $user->id), $updateData);

        $response->assertStatus(200)
            ->assertJsonFragment(['name' => 'John Updated', 'email' => 'johnupdated@example.com']);

        $this->assertDatabaseHas('users', ['email' => 'johnupdated@example.com']);
    }

    #[Test]
    public function can_delete_a_user()
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user);

        $response = $this->deleteJson(route('user.destroy', $user->id));

        $response->assertStatus(204);

        $this->assertDatabaseMissing('users', ['id' => $user->id]);
    }


    #[Test]
    public function can_authenticate_with_sanctum()
    {
        $user = User::factory()->create([
            'email' => 'jane@example.com',
            'password' => Hash::make('password123'),
        ]);

        Sanctum::actingAs($user);

        $response = $this->getJson('/api/projetos');

        $response->assertStatus(200);
    }
}
