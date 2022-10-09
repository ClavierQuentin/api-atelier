<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Categorie extends Model
{
    use HasFactory;

    protected $fillable = [
        'nom_categorie',
        'url_image_categorie',
    ];

    public function users()
    {
        return $this->belongsToMany(User::class);
    }

    public function produits()
    {
        return $this->hasMany(Produit::class);
    }

    public function getProduits()
    {
        return $this->hasMany(Produit::class);
    }
}
