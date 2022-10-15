<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;


class DeuxiemeBanniere extends Model
{
    use HasFactory;

    protected $fillable = [
        'titre',
        'texte',
        'url_image',
        'online'
    ];

    public function users()
    {
        return $this->belongsTo(User::class);
    }

    //On retourne le tableau stocké en JSON décodé
    public function getArrayFromUrlsImages()
    {
        return json_decode($this->url_image);
    }

    //Fonction pour récuper le nom du fichier à partir de l'url stockée en base
    public function getNameFromUrl($url)
    {
        //On décompose l'url stockées en DB
        $urlImage = explode("/", $url);

        //On récupère  le nom de l'image avec l'extension
        $publicName = $urlImage[count($urlImage)-1];

        return $publicName;
    }

    // Fonction pour supprimer toutes les images stockées en base sur le cloud
    public function deleteImages()
    {
        $urls = $this->getArrayFromUrlsImages();

        foreach($urls as $url) {

            //On décompose l'url stockées en DB
            $urlImage = explode("/", $url);

            //On récupère  le nom de l'image
            $publicId = $urlImage[count($urlImage)-1];

            //On récupère sans l'extension
            $publicName = explode(".", $publicId)[0];

            return $result = Cloudinary::destroy($publicName);
        }


    }
}
