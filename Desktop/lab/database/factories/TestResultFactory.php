<?php

namespace Database\Factories;

use App\Models\Appointment;
use App\Models\TestResult;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\TestResult>
 */
class TestResultFactory extends Factory
{
    protected $model = TestResult::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $status = $this->faker->randomElement(['pending', 'completed']);
        
        // Sample result data templates
        $resultTemplates = [
            "Hemoglobin: 14.5 g/dL (normalno)\nHematokrit: 42% (normalno)\nEritrociti: 4.8 x 10^12/L (normalno)\nLeukociti: 6.5 x 10^9/L (normalno)\nTrombociti: 250 x 10^9/L (normalno)",
            "Glukoza: 5.2 mmol/L (normalno)\nHbA1c: 5.4% (normalno)",
            "Holesterol ukupno: 5.1 mmol/L\nHDL: 1.2 mmol/L\nLDL: 3.2 mmol/L\nTrigliceridi: 1.5 mmol/L",
            "TSH: 2.1 mIU/L (normalno)\nFT4: 15.2 pmol/L (normalno)\nFT3: 4.8 pmol/L (normalno)",
            "Vitamin D: 65 nmol/L (normalno)\nKalcijum: 2.4 mmol/L (normalno)\nFosfor: 1.1 mmol/L (normalno)",
            "Kreatinin: 85 μmol/L (normalno)\nUrea: 5.2 mmol/L (normalno)\neGFR: 90 mL/min/1.73m² (normalno)",
            "ALT: 25 U/L (normalno)\nAST: 22 U/L (normalno)\nBilirubin ukupno: 12 μmol/L (normalno)",
        ];

        $resultData = $this->faker->randomElement($resultTemplates);
        $completedAt = $this->faker->optional(0.7)->dateTimeBetween('-3 months', 'now');
        $publishedAt = null;
        
        // If completed, sometimes publish it
        if ($completedAt && $this->faker->boolean(60)) {
            $publishedAt = $this->faker->dateTimeBetween($completedAt, 'now');
            $status = 'completed';
        }

        return [
            'appointment_id' => Appointment::factory(),
            'result_data' => $resultData,
            'status' => $status,
            'completed_at' => $completedAt,
            'published_at' => $publishedAt,
        ];
    }
}
