<?php

namespace App\Console\Commands;

use App\Models\Patient;
use App\Models\User;
use Illuminate\Console\Command;

class CreateMissingPatientProfiles extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'patients:create-missing-profiles';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Kreira Patient profile za korisnike sa role=user koji nemaju povezan Patient profil';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $users = User::where('role', 'user')
            ->whereDoesntHave('patient')
            ->get();

        if ($users->isEmpty()) {
            $this->info('Svi korisnici već imaju Patient profile.');
            return Command::SUCCESS;
        }

        $this->info("Pronađeno {$users->count()} korisnika bez Patient profila.");

        $created = 0;
        foreach ($users as $user) {
            // Podijelimo ime na first_name i last_name
            $nameParts = explode(' ', trim($user->name), 2);
            $firstName = $nameParts[0] ?? '';
            $lastName = $nameParts[1] ?? '';

            Patient::create([
                'user_id' => $user->id,
                'first_name' => $firstName,
                'last_name' => $lastName ?: $firstName,
                'email' => $user->email,
            ]);

            $created++;
            $this->line("Kreiran Patient profil za: {$user->email}");
        }

        $this->info("Uspješno kreirano {$created} Patient profila.");

        return Command::SUCCESS;
    }
}
