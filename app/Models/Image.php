<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    use HasFactory;

    protected $fillable = [
        'url'
    ];

    public function users()
    {
        return $this->belongsTo(User::class);
    }

    public function premiereBanniere()
    {
        return $this->hasMany(PremiereBanniere::class);
    }

    public function deuxiemeBanniere()
    {
        return $this->belongsToMany(DeuxiemeBanniere::class,"deuxieme_banniere_image", "image_id", "deuxieme_banniere_id");
    }

    public function troisiemeBanniere()
    {
        return $this->hasMany(TroisiemeBanniere::class);
    }

    public function troisiemeBanniere2()
    {
        return $this->hasMany(Image::class, "image_id_2");
    }

    public function categorie()
    {
        return $this->hasMany(Categorie::class);
    }

    public function produit()
    {
        return $this->belongsToMany(Produit::class);
    }

    public function carrousel()
    {
        return $this->hasMany(Carrousel::class);
    }
}
