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
        'prix_produit',
        'categorie_id',
        'isAccueil',
        'url_externe'
    ];

    public $with = ['categorie', 'images'];

    public function categorie()
    {
        return $this->belongsTo(Categorie::class);
    }

    public function images()
    {
        return $this->belongsToMany(Image::class, "image_produit")->withPivot('image_id');
    }



}
