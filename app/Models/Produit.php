<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Produit extends Model
{
    use HasFactory;
    protected $fillable = [
        'nom_produit',
        'description_courte_produit',
        'description_longue_produit',
        'url_image_produit',
        'prix_produit',
        'isAcceuil'
    ];

    public $with = ['categorie'];

    public function categorie()
    {
        return $this->belongsTo(Categorie::class);
    }
}
