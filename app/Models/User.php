<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'firstname',
        'email', 
        'nid', //10 caracteres numeriques 
        'unite', 
        'numero_de_poste', //PNIA, exemple : 811 721 82 19
        'numero_de_telephone', //Regex pour un numéro de telephone privé
        'password', //9 caracteres minimum 
        'id_commune', //Commune de préférence 
        'id_base_militaire', //Base de préférence
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function commune()
    {
        return $this->belongsTo(Commune::class);
    }

    public function baseMilitaire()
    {
        return $this->belongsTo(BaseMilitaire::class);
    }

    public function trajets()
    {
        return $this->hasMany(Trajet::class, 'id_conducteur'); // 'id_conducteur' correspond à la clé étrangère dans la table 'trajets'
    }


    public function reservations()
    {
        return $this->hasMany(User::class);
    }

    public function rapports()
    {
        return $this->hasMany(Rapport::class);
    }
}
