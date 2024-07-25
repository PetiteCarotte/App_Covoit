<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rapport extends Model
{
    use HasFactory;

    protected $primaryKey = 'id_rapport';

    public $timestamps = false;

    protected $fillable = [
        'description',
        'date_rapport',
        'statut',
        'id_utilisateur',
    ];

    public function utilisateur()
    {
        return $this->belongsTo(User::class);
    }

}
