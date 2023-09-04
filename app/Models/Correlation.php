<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Correlation extends Model
{
    use HasFactory;

    public $timestamps = false;
    
    protected $fillable = [
        'NumeroSalle',
        'IDEmployee',
        'DateRejoindre',
        'DateDepart',
    ];
}
