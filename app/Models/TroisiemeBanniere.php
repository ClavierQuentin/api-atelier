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
        'online'
    ];

    public function users()
    {
        return $this->belongsTo(User::class);
    }

    public function image()
    {
        return $this->belongsTo(Image::class);
    }

    public function image2()
    {
        return $this->belongsTo(Image::class, "image_id_2");
    }


}
