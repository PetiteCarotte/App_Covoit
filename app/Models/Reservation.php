<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    use HasFactory;

    /**
     * Id_Passager (passager) (belongs to utilisateur) (PrimaryKey)
     * Id_Trajet (PrimaryKey) (belongs to Trajet) 
     * DateReservation
     * Statut (En attente, Accepté, Refusé)
     */

    protected $primaryKey = ['id_passager', 'id_trajet'];
    public $incrementing = false;

    protected $fillable = [
        'id_passager',
        'id_trajet',
        'qte_bagages_demandee',
        'nbr_places_demande',
        'commentaire',
        'date_reservation',
        'statut',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'id_passager', 'id');
    }

    public function trajet()
    {
        return $this->belongsTo(Trajet::class, 'id_trajet', 'id');
    }

    // Pour permettre l'utilisation de clés composites
    protected function setKeysForSaveQuery($query)
    {
        $keys = $this->getKeyName();
        if (!is_array($keys)) {
            return parent::setKeysForSaveQuery($query);
        }

        foreach ($keys as $key) {
            $query->where($key, '=', $this->getOriginal($key));
        }

        return $query;
    }

    public function getKeyName()
    {
        return $this->primaryKey;
    }

}
