<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use App\Rules\ValidPNIANumber;


class UserRequest extends FormRequest
{
    public function rules()
    {
        $userId = $this->route('user'); 

        return [
            'name' => 'required|string|max:255',
            'firstname' => 'required|string|max:255',
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique('users')->ignore($userId), 
            ],
            'nid' => [
                'required',
                'string',
                'regex:/^\d{10}$/', 
                Rule::unique('users')->ignore($userId), 
            ],
            'unite' => 'nullable|string|max:255',
            'numero_de_poste' => ['nullable', 'string', new ValidPNIANumber],
            'numero_de_telephone' => 'nullable|string|regex:/^(\+\d{1,3}[- ]?)?\d{10}$/',
            'password' => 'sometimes|nullable|string|min:8|confirmed',
            'nom_code_commune' => 'required|string',
            'nom_de_la_base' => 'required|string',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Le nom est obligatoire.',
            'firstname.required' => 'Le prénom est obligatoire.',
            'email.required' => 'L\'adresse email est obligatoire.',
            'email.email' => 'L\'adresse email doit être une adresse email valide.',
            'email.unique' => 'L\'adresse email est déjà utilisée.',
            'nid.required' => 'Le NID est obligatoire.',
            'nid.unique' => 'Le NID est déjà utilisé.',
            'nid.regex' => 'Le NID est composé de 10 caractères numériques',
            'nid.max' => 'Le NID doit comporter au maximum 10 caractères.',
            'password.min' => 'Le mot de passe doit comporter au moins 8 caractères.',
            'password.confirmed' => 'Les mots de passe ne correspondent pas.',
            'numero_de_telephone.regex' => 'Le numéro de téléphone doit être valide.',
            'nom_code_commune.required' => 'Le nom de la commune est obligatoire.',
            'nom_de_la_base.required' => 'Le nom de la base est obligatoire',
        ];
    }
}
