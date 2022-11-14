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
        'online'
    ];

    public function users()
    {
        return $this->belongsTo(User::class);
    }

    public function images()
    {
        return $this->belongsToMany(Image::class, "deuxieme_banniere_image", "deuxieme_banniere_id","image_id");
    }

    //On retourne le tableau stocké en JSON décodé
    public function getArrayFromUrlsImages()
    {
        return json_decode($this->url_image);
    }

    //Fonction pour récuper le nom du fichier à partir de l'url stockée en base
    public function getNameFromUrl($url)
    {
        //On décompose l'url stockée en DB
        $fileName = explode("/", $url);

        //On récupère  le nom de l'image avec l'extension
        $publicName = $fileName[count($fileName)-1];

        return $publicName;
    }

    // Fonction pour supprimer toutes les images stockées en base sur le cloud
    public function deleteImages()
    {
        $urls = $this->getArrayFromUrlsImages();

        foreach($urls as $url) {

            //On récupère  le nom de l'image
            $fileName = $this->getNameFromUrl($url);

            //On récupère sans l'extension
            $publicName = explode(".", $fileName)[0];

            //Suppression en ligne
            $result = Cloudinary::destroy($publicName);

        }

        return;

    }
}
