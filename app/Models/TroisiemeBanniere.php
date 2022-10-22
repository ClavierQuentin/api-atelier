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
        //On décompose l'url stockée en DB
        $fileName = explode("/", $this->url_image);

        //On récupère  le nom de l'image
        $publicId = $fileName[count($fileName)-1];

        //On récupère sans l'extension
        $publicName = explode(".", $publicId)[0];

        //Suppression au cloud
        return $result = Cloudinary::destroy($publicName);
    }

        //FOnction pour supprimer la deuxieme image
        public function deleteImage2()
        {
        //On décompose l'url stockée en DB
        $fileName = explode("/", $this->url_image_2);

        //On récupère  le nom de l'image
        $publicId = $fileName[count($fileName)-1];

        //On récupère sans l'extension
        $publicName = explode(".", $publicId)[0];

            //Suppression au cloud
            return $result = Cloudinary::destroy($publicName);
        }

}
