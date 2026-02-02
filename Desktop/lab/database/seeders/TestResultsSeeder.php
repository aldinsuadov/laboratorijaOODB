<?php

namespace Database\Seeders;

use App\Models\Appointment;
use App\Models\TestResult;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TestResultsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get appointments that don't have test results yet
        $appointments = Appointment::whereDoesntHave('testResult')
            ->where('status', '!=', 'cancelled')
            ->get();

        if ($appointments->isEmpty()) {
            $this->command->warn('No appointments found without test results.');
            return;
        }

        // Create test results for 40-70% of appointments
        $percentage = rand(40, 70);
        $count = (int) ($appointments->count() * ($percentage / 100));
        
        $appointmentsToProcess = $appointments->random(min($count, $appointments->count()));

        foreach ($appointmentsToProcess as $appointment) {
            // Only create results for done or scheduled appointments
            if ($appointment->status === 'cancelled') {
                continue;
            }

            $status = $appointment->status === 'done' 
                ? 'completed' 
                : fake()->randomElement(['pending', 'completed']);

            $completedAt = null;
            $publishedAt = null;

            if ($status === 'completed') {
                // Completed at should be after appointment date
                // Only create completed results for past appointments
                $appointmentDateTime = $appointment->appointment_date->copy();
                if ($appointment->appointment_time) {
                    $timeParts = explode(':', $appointment->appointment_time);
                    if (count($timeParts) >= 2) {
                        $appointmentDateTime->setTime((int)$timeParts[0], (int)$timeParts[1]);
                    }
                }
                
                if ($appointmentDateTime->isPast()) {
                    $completedAt = fake()->dateTimeBetween(
                        $appointmentDateTime,
                        'now'
                    );

                    // 60% chance to be published
                    if (fake()->boolean(60)) {
                        $publishedAt = fake()->dateTimeBetween($completedAt, 'now');
                    }
                } else {
                    // If appointment is in future, set status to pending
                    $status = 'pending';
                    $completedAt = null;
                }
            }

            TestResult::create([
                'appointment_id' => $appointment->id,
                'result_data' => $this->generateResultData(),
                'status' => $status,
                'completed_at' => $completedAt,
                'published_at' => $publishedAt,
            ]);

            // Update appointment status to 'done' if result is completed
            if ($status === 'completed') {
                $appointment->update(['status' => 'done']);
            }
        }
        
        $this->command->info("Created " . $appointmentsToProcess->count() . " test results.");
    }

    /**
     * Generate sample result data.
     */
    private function generateResultData(): string
    {
        $templates = [
            "Hemoglobin: " . fake()->randomFloat(1, 12, 16) . " g/dL (normalno)\n" .
            "Hematokrit: " . fake()->numberBetween(35, 50) . "% (normalno)\n" .
            "Eritrociti: " . fake()->randomFloat(2, 4.0, 5.5) . " x 10^12/L (normalno)\n" .
            "Leukociti: " . fake()->randomFloat(1, 4.0, 10.0) . " x 10^9/L (normalno)\n" .
            "Trombociti: " . fake()->numberBetween(150, 400) . " x 10^9/L (normalno)",

            "Glukoza: " . fake()->randomFloat(1, 4.0, 6.5) . " mmol/L (normalno)\n" .
            "HbA1c: " . fake()->randomFloat(1, 4.5, 6.0) . "% (normalno)",

            "Holesterol ukupno: " . fake()->randomFloat(1, 4.0, 6.5) . " mmol/L\n" .
            "HDL: " . fake()->randomFloat(1, 1.0, 2.0) . " mmol/L\n" .
            "LDL: " . fake()->randomFloat(1, 2.0, 4.0) . " mmol/L\n" .
            "Trigliceridi: " . fake()->randomFloat(1, 0.5, 2.5) . " mmol/L",

            "TSH: " . fake()->randomFloat(2, 0.5, 4.0) . " mIU/L (normalno)\n" .
            "FT4: " . fake()->randomFloat(1, 12, 22) . " pmol/L (normalno)\n" .
            "FT3: " . fake()->randomFloat(1, 3.5, 6.5) . " pmol/L (normalno)",

            "Vitamin D: " . fake()->numberBetween(50, 100) . " nmol/L (normalno)\n" .
            "Kalcijum: " . fake()->randomFloat(1, 2.1, 2.6) . " mmol/L (normalno)\n" .
            "Fosfor: " . fake()->randomFloat(1, 0.8, 1.5) . " mmol/L (normalno)",

            "Kreatinin: " . fake()->numberBetween(60, 120) . " μmol/L (normalno)\n" .
            "Urea: " . fake()->randomFloat(1, 3.0, 7.0) . " mmol/L (normalno)\n" .
            "eGFR: " . fake()->numberBetween(80, 120) . " mL/min/1.73m² (normalno)",

            "ALT: " . fake()->numberBetween(10, 40) . " U/L (normalno)\n" .
            "AST: " . fake()->numberBetween(10, 40) . " U/L (normalno)\n" .
            "Bilirubin ukupno: " . fake()->numberBetween(5, 20) . " μmol/L (normalno)",
        ];

        return fake()->randomElement($templates);
    }
}
