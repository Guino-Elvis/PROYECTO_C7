<?php

namespace App\Actions\Fortify;

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

            'apellido_m' => ['required', 'string', 'max:255'], // Corrected validation rule
            'apellido_p' => ['required', 'string', 'max:255'], // Corrected validation rule
            'dni' => ['required', 'string', 'max:255'], // Corrected validation rule
            'direccion' => ['required', 'string', 'max:255'], // Corrected validation rule
            'telefono' => ['required', 'string', 'max:255'], // Corrected validation rule
            'password' => $this->passwordRules(),
            'terms' => Jetstream::hasTermsAndPrivacyPolicyFeature() ? ['accepted', 'required'] : '',
        ])->validate();

        return User::create([
            'name' => $input['name'],
            'email' => $input['email'],
            'apellido_p' => $input['apellido_p'],
            'apellido_m' => $input['apellido_m'],
            'dni' => $input['dni'],
            'direccion' => $input['direccion'],
            'telefono' => $input['telefono'],
            'password' => Hash::make($input['password']),
        ]);
    }
}
