<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Request;

class TexteAccueil extends Model
{
    use HasFactory;

    protected $fillable = [
        'titre_accueil',
        'texte_accueil',
        'titre_categories',
    ];

    public function users()
    {
        return $this->belongsTo(User::class);
    }
}
