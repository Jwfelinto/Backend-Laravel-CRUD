<?php

namespace Database\Seeders;


use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            ClientSeeder::class,
            LocationSeeder::class,
            InstallationTypeSeeder::class,
            ToolSeeder::class,
            ProjectSeeder::class
        ]);
    }
}
