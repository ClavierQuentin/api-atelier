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
        'isAccueil'
    ];


    public function users()
    {
        return $this->belongsToMany(User::class);
    }

    public function produits()
    {
        return $this->hasMany(Produit::class);
    }


    //Fonction pour supprimer les images dans le cloud
    public function deleteImage()
    {
        //On décompose l'url
        $fileName = explode("/", $this->url_image_categorie);

        //On récupère le nom du ficher
        $publicId = $fileName[count($fileName)-1];

        //On enlève l'extension
        $publicName = explode(".", $publicId)[0];

        //Suppresion sur le cloud
        return $result = Cloudinary::destroy($publicName);
    }

}
