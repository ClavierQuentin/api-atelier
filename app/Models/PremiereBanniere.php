<?php

namespace App\Models;

use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PremiereBanniere extends Model
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

    //Fonction pour supprimer les images dans le cloud
    public function deleteImage()
    {
        //On décompose  l'url
        $fileName = explode("/", $this->url_image);

        //On récupère le nom du fichier
        $publicId = $fileName[count($fileName)-1];

        //On enlève l'extension
        $publicName = explode(".", $publicId)[0];

        //Suppresion sur le cloud
        return $result = Cloudinary::destroy($publicName);
    }
}
