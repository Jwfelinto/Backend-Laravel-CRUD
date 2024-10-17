<?php


use App\Models\Client;
use App\Models\InstallationType;
use App\Models\Location;
use App\Models\Tool;
use App\Models\User;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Sanctum\Sanctum;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;
use App\Models\Project;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ToolTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    /**
     * @return void
     */
    #[Test]
    public function can_create_a_tool()
    {
        foreach (Tool::ALL as $name) {
            Tool::updateOrCreate(['name' => $name]);

            $this->assertDatabaseHas('tools', ['name' => $name]);
        }
    }

    #[Test]
    public function tool_belongs_to_many_projects()
    {
        $project = Project::factory()->create();

        $tool = Tool::factory()->create();
        $tool->projects()->attach($project->id, ['quantity' => 10]);

        $this->assertInstanceOf(Project::class, $tool->projects->first());
        $this->assertEquals(10, $tool->projects->first()->pivot->quantity);
    }

}
