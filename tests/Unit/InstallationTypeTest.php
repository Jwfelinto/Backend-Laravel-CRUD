<?php

namespace Tests\Unit;

use App\Models\InstallationType;
use App\Models\Project;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class InstallationTypeTest extends TestCase
{
    use RefreshDatabase;

//    public function test_it_can_list_installation_types()
//    {
//        InstallationType::factory()->count(6)->create();
//
//        $response = $this->getJson(route('installation.index'));
//
//        $response->assertStatus(200);
//
//        $response->assertJsonFragment(['name' => InstallationType::TYPES]);
//    }

    /**
     * Teste para verificar a relação `hasMany` com projetos.
     *
     * @return void
     */
    public function test_installation_type_has_many_projects()
    {
        $installationType = InstallationType::factory()->create();
        Project::factory()->count(2)->create(['installation_type_id' => $installationType->id]);


        $this->assertInstanceOf(Project::class, $installationType->projects->first());
        $this->assertEquals(2, $installationType->projects->count());
    }
}

