<?php

namespace App\Http\Requests;

use App\Models\Trajet;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class TrajetRequest extends FormRequest
{

    protected function prepareForValidation()
    {
        $this->merge([
            'domicile_base' => filter_var($this->domicile_base, FILTER_VALIDATE_BOOLEAN),
        ]);
    }


    /**
     * Les règles de validation qui s'appliquent à la requête.
     *
     * @return array
     */
    public function rules()
    {
        $rules = [
            'heure_depart' => 'required|date_format:H:i',
            'qte_bagages' => 'required|integer|min:0',
            'nbr_places' => 'required|integer|min:1',
            'description' => 'nullable|string|max:255',
            'id_commune' => 'nullable|exists:communes,code_commune_insee',
            'id_base_militaire' => 'required|exists:base_militaires,id_base_militaire',
            'domicile_base' => 'required|boolean',
        ];

        // Ajouter la règle pour date_depart seulement si trajet_regulier est faux
        if (!$this->trajet_regulier) {
            $rules['date_depart'] = 'required|date';
        }

        return $rules;
    }

    /**
     * Les messages de validation personnalisés pour les règles définies.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'date_depart.required' => 'La date de départ est obligatoire sauf pour un trajet régulier.',
            'date_depart.date' => 'La date de départ doit être une date valide.',
            'heure_depart.required' => 'L\'heure de départ est obligatoire.',
            'heure_depart.date_format' => 'L\'heure de départ doit être au format HH:MM.',
            'qte_bagages.required' => 'La quantité de bagages est obligatoire.',
            'qte_bagages.integer' => 'La quantité de bagages doit être un nombre entier.',
            'qte_bagages.min' => 'La quantité de bagages ne peut pas être négative.',
            'nbr_places.required' => 'Le nombre de places est obligatoire.',
            'nbr_places.integer' => 'Le nombre de places doit être un nombre entier.',
            'nbr_places.min' => 'Le nombre de places doit être au moins 1.',
            'description.string' => 'La description doit être une chaîne de caractères.',
            'description.max' => 'La description ne peut pas dépasser 255 caractères.',
            'id_commune.exists' => 'La commune sélectionnée n\'existe pas.',
            'id_base_militaire.required' => 'La base militaire est obligatoire.',
            'id_base_militaire.exists' => 'La base militaire sélectionnée n\'existe pas.',
            //'id_vehicule.exists' => 'Le véhicule sélectionné n\'existe pas.',
        ];
    }
}
