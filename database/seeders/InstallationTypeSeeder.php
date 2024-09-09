<?php

namespace Database\Seeders;

use App\Models\InstallationType;
use Illuminate\Database\Seeder;

class InstallationTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach (InstallationType::TYPES as $type) {
            InstallationType::firstOrCreate(['uf' => $type]);
        }
    }
}
