<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Commune extends Model
{
    use HasFactory;

    protected $primaryKey = 'code_commune_insee';
    public $incrementing = false; // La clé primaire n'est pas auto-incrémentée
    protected $keyType = 'string'; // Le type de la clé primaire est string

    protected $fillable = [
        'code_commune_insee',
        'nom_de_la_commune',
        'code_postal',
        'libelle_d_acheminement',
    ];

    // public function users()
    // {
    //     return $this->hasMany(User::class);
    // }

    // public function trajets(){
    //     return $this->hasMany(Trajet::class);
    // }


}
