<?php

namespace Database\Seeders;

use App\Models\Patient;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class PatientsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $patients = [
            [
                'first_name' => 'Amir',
                'last_name' => 'Hadžić',
            ],
            [
                'first_name' => 'Emir',
                'last_name' => 'Kovačević',
            ],
            [
                'first_name' => 'Haris',
                'last_name' => 'Mehić',
            ],
            [
                'first_name' => 'Adnan',
                'last_name' => 'Dedić',
            ],
            [
                'first_name' => 'Lejla',
                'last_name' => 'Alić',
            ],
            [
                'first_name' => 'Amina',
                'last_name' => 'Suljić',
            ],
            [
                'first_name' => 'Maja',
                'last_name' => 'Begović',
            ],
            [
                'first_name' => 'Nermin',
                'last_name' => 'Omerović',
            ],
            [
                'first_name' => 'Selma',
                'last_name' => 'Karić',
            ],
            [
                'first_name' => 'Faruk',
                'last_name' => 'Ćatić',
            ],
        ];

        $baseJmbg = 1111111111111; // samo za dummy podatke, važno je da su jedinstveni

        $created = 0;

        foreach ($patients as $index => $data) {
            Patient::create([
                'user_id' => null,
                'first_name' => $data['first_name'],
                'last_name' => $data['last_name'],
                'jmbg' => (string) ($baseJmbg + $index),
                'email' => strtolower($data['first_name'] . '.' . $data['last_name']) . '@example.com',
                'phone' => '037 ' . str_pad((string) (200000 + $index), 6, '0', STR_PAD_LEFT),
                'date_of_birth' => Carbon::now()->subYears(rand(25, 65))->subDays(rand(0, 365))->toDateString(),
                'address' => 'Ulica ' . $data['last_name'] . ' bb, BiH',
            ]);

            $created++;
        }

        $this->command->info("Created {$created} patients with realistic Bosnian names.");
    }
}
