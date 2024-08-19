<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TrajetUpdateRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'date_depart' => ['nullable', 'date'],
            'qte_bagages' => ['nullable', 'integer', 'min:0'],
            'heure_depart' => ['nullable', 'date_format:H:i'],
            'nbr_places' => ['nullable', 'integer', 'min:1'],
            'description' => ['nullable', 'string', 'max:255'],
        ];
    }

    public function messages(): array
    {
        return [
            'date_depart.date' => 'La date de départ doit être une date valide.',
            'qte_bagages.integer' => 'La quantité de bagages doit être un nombre entier.',
            'qte_bagages.min' => 'La quantité de bagages ne peut pas être négative.',
            'heure_depart.date_format' => "L'heure de départ doit être au format HH:MM.",
            'nbr_places.integer' => 'Le nombre de places doit être un nombre entier.',
            'nbr_places.min' => 'Le nombre de places doit être au moins de 1.',
            'description.string' => 'La description doit être une chaîne de caractères.',
            'description.max' => 'La description ne peut pas dépasser 255 caractères.',
        ];
    }
}
