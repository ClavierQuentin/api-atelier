<?php

namespace App\Models;

use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;
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
        'url_image_2',
        'online'
    ];

    public function users()
    {
        return $this->belongsTo(User::class);
    }

    //FOnction pour supprimer la premiere image
    public function deleteImage1()
    {
        //On décompose l'url stockée en DB et on récupère le nom du fichier
        $fileName = explode("/", $this->url_image)[count($this->url_image)-1];

        //On r�cup�re  le nom de l'image
        // $publicId = $urlImage[count($urlImage)-1];

        //On récupère sans l'extension
        $publicName = explode(".", $fileName)[0];

        //Suppression au cloud
        return $result = Cloudinary::destroy($publicName);
    }

        //FOnction pour supprimer la deuxieme image
        public function deleteImage2()
        {
            //On décompose l'url stockée en DB et on récupère le nom du fichier
            $fileName = explode("/", $this->url_image_2)[count($this->url_image_2)-1];

            //On r�cup�re  le nom de l'image
            // $publicId = $urlImage[count($urlImage)-1];

            //On récupère sans l'extension
            $publicName = explode(".", $fileName)[0];

            //Suppression au cloud
            return $result = Cloudinary::destroy($publicName);
        }

}
