<?php

namespace Database\Factories;

use App\Models\Patient;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Patient>
 */
class PatientFactory extends Factory
{
    protected $model = Patient::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $gender = $this->faker->randomElement(['male', 'female']);
        $firstName = $gender === 'male' 
            ? $this->faker->firstNameMale() 
            : $this->faker->firstNameFemale();
        
        // Generate valid JMBG (13 digits)
        $jmbg = $this->faker->numerify('#############');

        return [
            'user_id' => null, // Will be set in seeder if needed
            'first_name' => $firstName,
            'last_name' => $this->faker->lastName(),
            'jmbg' => $jmbg,
            'email' => $this->faker->optional(0.8)->safeEmail(),
            'phone' => $this->faker->optional(0.9)->phoneNumber(),
            'date_of_birth' => $this->faker->dateTimeBetween('-80 years', '-18 years'),
            'address' => $this->faker->optional(0.7)->address(),
        ];
    }
}
