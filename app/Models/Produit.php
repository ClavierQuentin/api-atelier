<?php

namespace App\Models;

use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;
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
        'categorie_id',
        'isAccueil',
        'url_externe'
    ];

    // public $with = ['categorie'];

    public function categorie()
    {
        return $this->belongsTo(Categorie::class);
    }

    //Fonction pour supprimer les images dans le cloud
    public function deleteImage()
    {
        //On récupère le nom de l'image via l'url
        $urlImage = explode("/", $this->url_image_produit);
        $publicId = $urlImage[count($urlImage)-1];

        //On enlève l'extension
        $publicName = explode(".", $publicId)[0];

        //Suppresion sur le cloud
        return $result = Cloudinary::destroy($publicName);
    }


}
