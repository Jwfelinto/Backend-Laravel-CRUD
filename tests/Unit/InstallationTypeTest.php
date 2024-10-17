<?php

namespace Tests\Unit;

use App\Models\InstallationType;
use App\Models\Project;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class InstallationTypeTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function can_list_installation_types()
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user);

        $installationTypes = InstallationType::factory()->count(6)->create();

        $response = $this->getJson(route('installation.index'));

        $response->assertStatus(200);

        foreach ($installationTypes as $type) {
            $response->assertJsonFragment(['name' => $type->name]);
        }
    }

    /**
     * Teste para verificar a relação `hasMany` com projetos.
     *
     * @return void
     */
    #[Test]
    public function installation_type_has_many_projects()
    {
        $installationType = InstallationType::factory()->create();
        Project::factory()->count(2)->create(['installation_type_id' => $installationType->id]);


        $this->assertInstanceOf(Project::class, $installationType->projects->first());
        $this->assertEquals(2, $installationType->projects->count());
    }
}

