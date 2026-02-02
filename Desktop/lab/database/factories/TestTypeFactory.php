<?php

namespace Database\Factories;

use App\Models\TestType;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\TestType>
 */
class TestTypeFactory extends Factory
{
    protected $model = TestType::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $testNames = [
            'Krvna slika',
            'Holesterol',
            'Glukoza',
            'Hormoni štitne žlezde',
            'Vitamin D',
            'Hemoglobin',
            'Bilirubin',
            'Kreatinin',
            'Urea',
            'ALT (GPT)',
            'AST (GOT)',
            'Lipidni profil',
            'Koagulacija',
            'Tumor markeri',
            'Hepatitis panel',
        ];

        return [
            'name' => $this->faker->unique()->randomElement($testNames),
            'description' => $this->faker->optional(0.7)->sentence(),
            'price' => $this->faker->randomFloat(2, 10, 150),
        ];
    }
}
