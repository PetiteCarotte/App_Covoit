<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Trajet extends Model
{
    use HasFactory;

    /*
        dateDepart
    dateArrivee
    HeureDepart 
    QteBagages
    NbrPlaces
    Description	
    TrajetRegulier (boolean)
    Statut (boolean)
    Domicile_Base (boolean)
    Id_Conducteur (conducteur clé etrangere) (belongs to utilisateur)
    Id_Commune (cle etrangere) (belongs to Commune #Code_commune_INSEE)
    Id_BaseMilitaire (cle etrangere) (belongs to BaseMilitaire Id_BaseMilitaire)
    Id_Jours (cle etrangere)
    Id_Vehicule (cle etrangere) (belongs to Vehicule)
       
    */

    protected $fillable = [
        'date_depart',
        'heure_depart',
        'qte_bagages',
        'qte_bagages_occupee',
        'nbr_places',
        'nbr_places_occupe',
        'description',
        'trajet_regulier',
        'statut',
        'domicile_base',
        'id_conducteur',
        'id_commune',
        'id_base_militaire',
        'id_jours',
        //'id_vehicule',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

   

    public function commune()
    {
        return $this->belongsTo(Commune::class, 'id_commune', 'code_commune_insee');
    }

    public function baseMilitaire()
    {
        return $this->belongsTo(BaseMilitaire::class, 'id_base_militaire', 'id_base_militaire');
    }

    public function jours()
    {
        return $this->belongsTo(Jours::class, 'id_jours');
    }

    // public function vehicule()
    // {
    //     return $this->belongsTo(Vehicule::class, 'id_vehicule');
    // }

    public function reservations()
    {
        return $this->hasMany(Reservation::class, 'id_trajet', 'id');
    }

    public function alertes()
    {
        return $this->hasMany(Alerte::class);
    }

    

    public function updatePassengerCount()
{
    $this->loadCount('reservations');
    $this->nbr_places = $this->nbr_places - 1;
    $this->save();

    // Recalculate status if needed
    // Example: $this->statut = $this->passengerCount() / $this->reservations->count();
    // Adjust as per your application logic

    return $this;
}

  // Définir l'attribut d'accès pour calculer les places restantes
  public function getPlacesRestantesAttribute()
  {
      return $this->nbr_places - $this->nbr_places_occupe;
  }

  // Définir l'attribut d'accès pour calculer les places restantes
  public function getBagagesRestantesAttribute()
  {
      return $this->qte_bagages - $this->qte_bagages_occupee;
  }
}
