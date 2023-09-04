<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Eqcorrelation extends Model
{
    use HasFactory;

    public $timestamps = false;
    
    protected $fillable = [
        'ID_emplacement',
        'Type',
        'Modele',
        'Quantite_ajoute',
        'Quantite_deplacee',
        'Date_ajout',
        'Date_deplacement',
        'Etat',
    ];
}
