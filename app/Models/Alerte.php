<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Alerte extends Model
{
    use HasFactory;

    protected $primaryKey = 'id_alerte';

    public $timestamps = false;

    /**
     * 'Statut',
     * 'Trajet_Regulier',
     *  'Domicile_Base',
     *  'Date_Alerte_Trajet',
     *  'Id_Trajet',
     *  'Id_Utilisateur',
     *  'Id_Jours',
     *  'Id_Domicile',
     *  'id_Base' 
     */

    protected $fillable = [
        'statut',
        'trajet_regulier',
        'domicile_base',
        'date_alerte_trajet',
        'id_trajet',
        'id_utilisateur',
        'id_jours',
        'id_commune',
        'id_base_militaire',
    ];

    public function trajet()
    {
        return $this->belongsTo(Trajet::class);
    }

    public function utilisateur()
    {
        return $this->belongsTo(User::class);
    }

    public function jours()
    {
        return $this->belongsTo(Jours::class);
    }

    public function commune()
    {
        return $this->belongsTo(Commune::class);
    }

    public function baseMilitaire()
    {
        return $this->belongsTo(BaseMilitaire::class);
    }


}
