<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BaseMilitaire extends Model
{
    use HasFactory;

    protected $primaryKey = 'id_base_militaire';
    public $incrementing = true; // La clé primaire est auto-incrémentée

    protected $fillable = [
        'nom_de_la_base',
        'nom_de_la_commune',
        'acronyme',
        'code_postal',
    ];

    public function user(){
        return $this->hasMany(User::class);
    }

    public function trajet(){
        return $this->hasMany(Trajet::class);
    }
}
