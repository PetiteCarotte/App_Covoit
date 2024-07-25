<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jours extends Model
{
    use HasFactory;

    protected $primaryKey = 'id_jours';

    protected $fillable = [
        'lundi',
        'mardi',
        'mercredi',
        'jeudi',
        'vendredi',
        'samedi',
        'dimanche',
    ];
    public $timestamps = false;

    public function trajet(){
        return $this->hasMany(Trajet::class);
    }
}
