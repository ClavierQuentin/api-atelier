<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Carrousel extends Model
{
    use HasFactory;

    protected $fillable = [
        'url',
        'texte',
        'bouton'
    ];

    public function users()
    {
        return $this->belongsTo(User::class);
    }

    public function image()
    {
        return $this->belongsTo(Image::class);
    }
}
