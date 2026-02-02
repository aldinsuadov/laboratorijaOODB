<?php

namespace Database\Seeders;

use App\Models\TestType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TestTypesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create 10-15 test types
        $count = rand(10, 15);
        
        TestType::factory($count)->create();
        
        $this->command->info("Created {$count} test types.");
    }
}
