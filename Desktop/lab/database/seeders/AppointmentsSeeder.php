<?php

namespace Database\Seeders;

use App\Models\Appointment;
use App\Models\Patient;
use App\Models\TestType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

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

        $created = 0;

        foreach ($patients as $patient) {
            // Za svakog pacijenta pravimo po 3 termina:
            // 1) prošli termin – završen (done)
            // 2) skorošnji termin – zakazan (scheduled / approved)
            // 3) budući termin – na čekanju (pending)

            // 1. Završeni termin (prije 20–40 dana)
            Appointment::create([
                'patient_id' => $patient->id,
                'test_type_id' => $testTypes->random()->id,
                'appointment_date' => Carbon::now()->subDays(rand(20, 40))->toDateString(),
                'appointment_time' => '09:00:00',
                'status' => 'done',
                'notes' => 'Termin uspješno realizovan.',
            ]);
            $created++;

            // 2. Zakazan / odobren termin (prije 5 dana do danas) – status scheduled
            Appointment::create([
                'patient_id' => $patient->id,
                'test_type_id' => $testTypes->random()->id,
                'appointment_date' => Carbon::now()->subDays(rand(0, 5))->toDateString(),
                'appointment_time' => '10:30:00',
                'status' => 'scheduled',
                'notes' => 'Termin je odobren i zakazan.',
            ]);
            $created++;

            // 3. Budući termin – na čekanju, ali zbog PostgreSQL ograničenja koristimo status scheduled
            Appointment::create([
                'patient_id' => $patient->id,
                'test_type_id' => $testTypes->random()->id,
                'appointment_date' => Carbon::now()->addDays(rand(3, 15))->toDateString(),
                'appointment_time' => '12:00:00',
                'status' => 'scheduled',
                'notes' => 'Termin je zakazan i čeka realizaciju.',
            ]);
            $created++;
        }

        $this->command->info("Created {$created} appointments (done, scheduled, pending for each patient).");
    }
}
