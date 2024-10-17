<?php

namespace Tests\Unit;

use App\Models\Location;
use App\Models\Project;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class LocationTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function can_create_a_location()
    {
        $data = ['uf' => 'BA'];

        $location = Location::updateOrCreate($data);

        $this->assertDatabaseHas('locations', $data);
        $this->assertEquals('BA', $location->uf);
    }

    /** @test */
    public function location_has_many_projects()
    {
        $location = Location::factory()->create();

        Project::factory()->count(3)->create([
            'location_id' => $location->id
        ]);

        $this->assertInstanceOf(Project::class, $location->projects->first());
        $this->assertCount(3, $location->projects);
    }
}
