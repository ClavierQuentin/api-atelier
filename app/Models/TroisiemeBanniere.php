<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TroisiemeBanniere extends Model
{
    use HasFactory;
    protected $fillable = [
        'titre_principal',
        'texte_1',
        'texte_2',
        'titre_1',
        'titre_2',
        'url_image',
        'url_image_2'
    ];

    public function users()
    {
        return $this->belongsTo(User::class);
    }
}
