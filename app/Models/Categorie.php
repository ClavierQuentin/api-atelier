<?php

namespace App\Models;

use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Categorie extends Model
{
    use HasFactory;

    protected $fillable = [
        'nom_categorie',
        'url_image_categorie',
    ];

    public $with = ['produits'];

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

    //Fonction pour supprimer les images dans le cloud
    public function deleteImage()
    {
        //On récupère le nom de l'image via l'url
        $urlImage = explode("/", $this->url_image_categorie);
        $publicId = $urlImage[count($urlImage)-1];

        //On enlève l'extension
        $publicName = explode(".", $publicId)[0];

        //Suppresion sur le cloud
        return $result = Cloudinary::destroy($publicName);
    }

}
