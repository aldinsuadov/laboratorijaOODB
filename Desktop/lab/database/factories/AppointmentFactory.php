<?php

namespace Database\Factories;

use App\Models\Appointment;
use App\Models\Patient;
use App\Models\TestType;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Appointment>
 */
class AppointmentFactory extends Factory
{
    protected $model = Appointment::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $statuses = ['scheduled', 'done', 'cancelled'];
        $status = $this->faker->randomElement($statuses);
        
        // Generate appointment date (past 6 months to future 1 month)
        $appointmentDate = $this->faker->dateTimeBetween('-6 months', '+1 month');
        
        // Generate time between 8:00 and 17:00
        $hour = $this->faker->numberBetween(8, 17);
        $minute = $this->faker->randomElement([0, 15, 30, 45]);
        $appointmentTime = sprintf('%02d:%02d:00', $hour, $minute);

        return [
            'patient_id' => Patient::factory(),
            'test_type_id' => TestType::factory(),
            'appointment_date' => $appointmentDate,
            'appointment_time' => $appointmentTime,
            'status' => $status,
            'notes' => $this->faker->optional(0.3)->sentence(),
        ];
    }
}
