<?php

namespace App\Actions\Fortify;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Laravel\Fortify\Contracts\CreatesNewUsers;
use Laravel\Jetstream\Jetstream;
use Illuminate\Validation\ValidationException;





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
            'username'=>['required','string','max:15','unique:users'],
            'password' => $this->passwordRules(),
            'terms' => Jetstream::hasTermsAndPrivacyPolicyFeature() ? ['accepted', 'required'] : '',
        ])->validate();
      
        //limitar el numero de usuarios a 2
        $users=User::all();
        if(count($users)>=2){
            throw ValidationException::withMessages([
                'name' => __('No se pueden crear mas usuarios'),
            ]);
        }

        return User::create([
            'name' => $input['name'],
            'email' => $input['email'],
            'username'=>$input['username'],
            'password' => Hash::make($input['password']),
        ]);
    }
}
