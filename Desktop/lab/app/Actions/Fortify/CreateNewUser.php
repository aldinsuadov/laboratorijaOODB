<?php

namespace App\Actions\Fortify;

use App\Models\Patient;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Laravel\Fortify\Contracts\CreatesNewUsers;
use Laravel\Jetstream\Jetstream;

class CreateNewUser implements CreatesNewUsers
{
    use PasswordValidationRules;

    /**
     * Validate and create a newly registered user.
     *
     * @param  array<string, string>  $input
     */
    public function create(array $input): User
    {
        Validator::make($input, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => $this->passwordRules(),
            'terms' => Jetstream::hasTermsAndPrivacyPolicyFeature() ? ['accepted', 'required'] : '',
        ])->validate();

        $user = User::create([
            'name' => $input['name'],
            'email' => $input['email'],
            'password' => Hash::make($input['password']),
            'role' => 'user', // Eksplicitno postavljamo role na 'user'
        ]);

        // Automatski kreiramo Patient profil za novog korisnika
        $this->createPatientProfile($user, $input);

        return $user;
    }

    /**
     * Create a patient profile for the newly registered user.
     *
     * @param  User  $user
     * @param  array<string, string>  $input
     * @return void
     */
    protected function createPatientProfile(User $user, array $input): void
    {
        // Podijelimo ime na first_name i last_name
        $nameParts = explode(' ', trim($input['name']), 2);
        $firstName = $nameParts[0] ?? '';
        $lastName = $nameParts[1] ?? '';

        Patient::create([
            'user_id' => $user->id,
            'first_name' => $firstName,
            'last_name' => $lastName ?: $firstName, // Ako nema prezimena, koristimo ime
            'email' => $input['email'],
            // jmbg, date_of_birth, phone, address ostaju nullable
            // Korisnik može kasnije ažurirati svoj profil
        ]);
    }
}
