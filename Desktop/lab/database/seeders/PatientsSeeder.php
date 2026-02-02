<?php

namespace Database\Seeders;

use App\Models\Patient;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PatientsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create 20-50 patients
        $count = rand(20, 50);
        
        Patient::factory($count)->create();
        
        $this->command->info("Created {$count} patients.");
    }
}
