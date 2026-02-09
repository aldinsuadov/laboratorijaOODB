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
        $testTypes = [
            [
                'name' => 'Kompletna krvna slika (KKS)',
                'description' => 'Osnovna hematološka analiza koja obuhvata broj eritrocita, leukocita, trombocita, hemoglobin i hematokrit.',
                'price' => 15.00,
            ],
            [
                'name' => 'Biohemija – osnovni panel',
                'description' => 'Analiza parametara funkcije jetre i bubrega (ALT, AST, urea, kreatinin, elektroliti).',
                'price' => 25.00,
            ],
            [
                'name' => 'Lipidni profil',
                'description' => 'Određivanje ukupnog holesterola, HDL, LDL i triglicerida u serumu.',
                'price' => 20.00,
            ],
            [
                'name' => 'Šećer u krvi (glukoza)',
                'description' => 'Mjerenje koncentracije glukoze u plazmi natašte ili nasumično.',
                'price' => 8.00,
            ],
            [
                'name' => 'Hormoni štitne žlijezde (TSH, FT3, FT4)',
                'description' => 'Procjena funkcije štitne žlijezde određivanjem hormona TSH, slobodnog T3 i slobodnog T4.',
                'price' => 35.00,
            ],
        ];

        $created = 0;

        foreach ($testTypes as $data) {
            TestType::create($data);
            $created++;
        }

        $this->command->info("Created {$created} predefined test types.");
    }
}
