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

    //On retourne le tableau stock� en JSON d�cod�
    public function getArrayFromUrlsImages()
    {
        return json_decode($this->url_image);
    }

    //Fonction pour r�cuper le nom du fichier � partir de l'url stock�e en base
    public function getNameFromUrl($url)
    {
        //On d�compose l'url stock�es en DB
        $urlImage = explode("/", $url);

        //On r�cup�re  le nom de l'image avec l'extension
        $publicName = $urlImage[count($urlImage)-1];

        return $publicName;
    }

    // Fonction pour supprimer toutes les images stock�es en base sur le cloud
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

            $result = Cloudinary::destroy($publicName);

        }

        return;

    }
}
