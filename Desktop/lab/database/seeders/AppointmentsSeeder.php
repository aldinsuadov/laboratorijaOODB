<?php

namespace Database\Seeders;

use App\Models\Appointment;
use App\Models\Patient;
use App\Models\TestType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AppointmentsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $patients = Patient::all();
        $testTypes = TestType::all();

        if ($patients->isEmpty() || $testTypes->isEmpty()) {
            $this->command->warn('No patients or test types found. Please run PatientsSeeder and TestTypesSeeder first.');
            return;
        }

        // Create 50-200 appointments
        $count = rand(50, 200);
        
        for ($i = 0; $i < $count; $i++) {
            Appointment::factory()->create([
                'patient_id' => $patients->random()->id,
                'test_type_id' => $testTypes->random()->id,
            ]);
        }
        
        $this->command->info("Created {$count} appointments.");
    }
}
