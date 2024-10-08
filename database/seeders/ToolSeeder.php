<?php

namespace Database\Seeders;

use App\Models\Tool;
use Illuminate\Database\Seeder;

class ToolSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach (Tool::ALL as $tool) {
            Tool::firstOrCreate(['name' => $tool]);
        }
    }
}
